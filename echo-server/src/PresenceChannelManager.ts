import * as SocketIO from 'socket.io';
import { Redis } from 'ioredis';
import * as _ from 'lodash';
import { Logger } from './Logger';

export class PresenceChannelManager {
    // チャンネル情報保管しないといけないので
    // redisClient

    constructor(private redisClient: Redis, private ioServer: SocketIO.Server, private options: any) {

    }

    getMembers(channel: string): any {
        return JSON.parse(this.redisClient.get('echo-server-channel:' + channel)) || {};
    }

    setMembers(channel: string, members: any): void {
        this.redisClient.set('echo-server-channel:' + channel, JSON.stringify(members));
    }

    isMember(channel: string, member: any): Promise<boolean> {
        return new Promise<boolean>((resolve, reject) => {
            const members = this.getMembers(channel);
            this.removeInactiveMembers(channel, members, member).then((members: any) => {
                const target = members.filter(m => m.user_id == member.user_id);
                resolve(target && target.length);
            });
        });
    }

    removeInactiveMembers(channel: string, members: any[], member: any): Promise<any> {
        return new Promise<any>((resolve, reject) => {
            this.ioServer.of('/').in(channel).clients((error, clients: any[]) => {
                members = (members || []).filter(member => clients.indexOf(member.socketId) >= 0);
                this.setMembers(channel, members);

                resolve(members);
            });
        });
    }

    join(socket: SocketIO.Socket, channel: string, member: any) {
        this.isMember(channel, member).then(isMember => {
            const members = this.getMembers(channel) || [];
            member.socketId = socket.id;
            members.push(member);
            this.setMembers(channel, members);

            const subscribeMembers = _.uniqBy(members.reverse(), 'user_id');
            this.onSubscribed(socket, channel, subscribeMembers);

            if (!isMember) this.onJoin(socket, channel, member);
        });
    }

    leave(socket: SocketIO.Socket, channel: string) {
        const members: any[] = this.getMembers(channel) || [];
        const leavingMember = members.find(member => member.socketId == socket.id);
        const others = members.filter(member => member.socketId != leavingMember.socketId);
        this.setMembers(channel, others);

        this.isMember(channel, leavingMember).then(isMember => {
            if (isMember) return;
            delete leavingMember.socketId;
            this.onLeave(channel, leavingMember);
        });
    }

    // ハンドラー --------------------------------------------------
    onSubscribed(socket: SocketIO.Socket, channel: string, members: any): void {
        this.ioServer.to(socket.id).emit('presence:subscribed', channel, members);
    }

    onJoin(socket: SocketIO.Socket, channel: string, member: any): void {
        this.ioServer.sockets.connected[socket.id].broadcast.to(channel).emit('presence:joining', channel, member);
        Logger.default.info(`User #${ member.id } joined "${ channel }" (presence)`);
    }

    onLeave(channel: string, member: any): void {
        this.ioServer.to('channel').emit('presence:leaving', channel, member);
        Logger.default.info(`User #${ member.id } left "${ channel }" (presence)`);
    }
}