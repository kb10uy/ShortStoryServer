import * as SocketIO from 'socket.io';
import { Redis } from 'ioredis';
import { PrivateChannelManager } from "./PrivateChannelManager";
import { PresenceChannelManager } from "./PresenceChannelManager";
import { Logger } from './Logger';

export class Channel {

    // 非publicなチャンネルのパターン
    protected _privateChannelPatterns: string[] = ['private-*', 'presence-*'];

    // クライアントからのイベント(whisper?)のパターン
    protected _allowedClientEventPatterns: string[] = ['client-*'];

    // Private/Presenceなチャンネル
    privateChannels: PrivateChannelManager;
    presenceChannels: PresenceChannelManager;

    constructor(private redisClient: Redis, private ioServer: SocketIO.Server, private options: any) {
        this.privateChannels = new PrivateChannelManager(options);
        this.presenceChannels = new PresenceChannelManager(redisClient, ioServer, options);
    }

    join(socket: SocketIO.Socket, data: any): void {
        if (!data.channel) return;
        if (this.isPrvate(data.channel)) {
            this.joinPrivate(socket, data);
        } else {
            socket.join(data.channel);
            this.onJoin(socket, data.channel);
        }
    }

    joinPrivate(socket: SocketIO.Socket, data: any): void {
        this.privateChannels.authenticate(socket, data).then(response => {
            socket.join(data.channel);

            if (this.isPresence(data.channel)) {
                let member = response.channel_data;
                try {
                    member = JSON.parse(response.channel_data);
                } catch (e) { }

                this.presenceChannels.join(socket, data.channel, member);
            }

            this.onJoin(socket, data.channel);
        });
    }

    leave(socket: SocketIO.Socket, channel: string, reason: string): void {
        if (channel) {
            if (this.isPresence(channel)) this.presenceChannels.leave(socket, channel);
        }
        socket.leave(channel);
        this.onLeave(socket, channel);
    }

    triggerClientEvent(socket: SocketIO.Socket, data: any): void {
        if (data.event && data.channel) {
            if (this.isClientEvent(data.event) &&
                this.isPrvate(data.channel) &&
                this.isInChannel(socket, data.channel)) {
                this.ioServer.sockets.connected[socket.id]
                    .broadcast.to(data.channel)
                    .emit(data.event, data.channel, data.data);
            }
        }
    }


    isPrvate(channel: string): boolean {
        return this._privateChannelPatterns.every(pattern => {
            const regex = new RegExp(pattern.replace('\*', '.*'));
            return regex.test(channel);
        });
    }

    isPresence(channel: string): boolean {
        return channel.startsWith('presence-');
    }

    isClientEvent(event: string): boolean {
        return this._privateChannelPatterns.every(pattern => {
            const regex = new RegExp(pattern.replace('\*', '.*'));
            return regex.test(event);
        });
    }

    isInChannel(socket: SocketIO.Socket, channel: string): boolean {
        return !!socket.rooms[channel];
    }

    onJoin(socket: SocketIO.Socket, channel: string): void {
        Logger.default.info(`User #${ socket.id } joined "${ channel }"`);
    }

    onLeave(socket: SocketIO.Socket, channel: string): void {
        Logger.default.info(`User #${ socket.id } left "${ channel }"`);
    }
}