import * as SocketIO from 'socket.io';
import * as Redis from 'ioredis';
import * as Http from 'http';
import * as Https from 'https';
import * as Net from 'net';
import { Channel } from './Channel';
import { Logger } from './Logger';

export class ServerManager {
    public defaultOptions: any = {
        authHost: 'http://localhost',
        endpoint: '/broadcasting/auth',
        clients: [],
        port: 6001,
        http: {
            protocol: 'http',
            key: '',
            cert: ''
        },
        redis: {
            path: '',
            password: '',
            db: 0
        },
        socketio: {

        }
    };

    // httpプロトコルサーバ(http/https)
    httpServer: Net.Server;

    // Socket.ioのサーバー
    ioServer: SocketIO.Server;

    // GET操作とかに使う方のクライアント
    redisClient: Redis.Redis;

    // PSUBSCRIBE専用のクライアント
    redisSubscriber: Redis.Redis;

    // Echoのチャンネル情報
    channels: Channel;

    // 適用するオプション
    options: any;

    constructor(additionalOptions: any) {
        Logger.initialize();
        this.options = Object.assign(this.defaultOptions, additionalOptions);

        if (this.options.http.protocol === 'https') {
            this.httpServer = Https.createServer(this.options.http);
        } else {
            this.httpServer = Http.createServer();
        }

        this.redisClient = new Redis(this.options.redis);
        this.redisSubscriber = new Redis(this.options.redis);
        this.ioServer = SocketIO(this.httpServer, this.options.socketio);
        this.channels = new Channel(this.redisClient, this.ioServer, this.options);
    }

    run(): void {
        this.initializeRedisSubscriber();
        this.httpServer.listen(this.options.port);
        this.onConnect();
    }

    startup(): void {
        Logger.default.info('Laravel Echo Server has started!');
    }

    private initializeRedisSubscriber(): void {
        this.redisSubscriber.psubscribe('*', (err: string) => { });
        this.redisSubscriber.on('*', this.onReceiveRedisEvent);
    }

    private broadcastToAll(channel: string, message: any): void {
        this.ioServer.to(channel).emit(message.event, channel, message.data);
    }

    private broadcastToOthers(socket: SocketIO.Socket, channel: string, message: any): void {
        socket.broadcast.to(channel).emit(message.event, channel, message.data);
    }

    // ハンドラー ------------------------------------------------------------------------
    private onReceiveRedisEvent(subscribe: string, channel: string, messageJson: string): void {
        const message = JSON.parse(messageJson);
        if (message.socket && this.ioServer.sockets.connected[message.socket]) {
            this.broadcastToOthers(this.ioServer.sockets.connected[message.socket], channel, message);
        } else {
            this.broadcastToAll(channel, message);
        }
    }

    private onConnect(): void {
        this.ioServer.on('connection', socket => {
            this.onSubscribe(socket);
            this.onUnsubscribe(socket);
            this.onDisconnecting(socket);
            this.onClientEvent(socket);
        });
    }

    private onSubscribe(socket: SocketIO.Socket): void {
        socket.on('subscribe', data => {
            this.channels.join(socket, data);
        });
    }

    private onUnsubscribe(socket: SocketIO.Socket): void {
        socket.on('unsubscribe', data => {
            this.channels.leave(socket, data.channel, 'unsubscribed');
        });
    }

    private onDisconnecting(socket: SocketIO.Socket): void {
        socket.on('disconnectiing', reason => {
            Object.keys(socket.rooms).forEach(room => {
                if (room !== socket.id) this.channels.leave(socket, room, reason);
            });
        });
    }

    private onClientEvent(socket: SocketIO.Socket): void {
        socket.on('client event', data => {
            this.channels.triggerClientEvent(socket, data);
        })
    }
}