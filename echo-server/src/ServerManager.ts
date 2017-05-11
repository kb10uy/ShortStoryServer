import * as SocketIO from "socket.io";
import * as Redis from "ioredis";

export class ServerManager {

    // GET操作とかに使う方のクライアント
    redisClient : Redis.Redis;

    // PSUBSCRIBE専用のクライアント
    redisSubscriber : Redis.Redis;

    constructor(redisOption: any) {
        this.redisClient = new Redis(redisOption);
        this.redisSubscriber = new Redis(redisOption);
    }

    run() : void {

    }
}