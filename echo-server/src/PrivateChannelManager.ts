import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';
import * as SocketIO from 'socket.io';
import { Logger } from './Logger';

export class PrivateChannelManager {
    constructor(private options) {

    }

    authenticate(socket: SocketIO.Socket, data: any): Promise<any> {
        const config: AxiosRequestConfig = {
            method: 'post',
            baseURL: this.options.authHost || this.options.host,
            url: this.options.endpoint,
            headers: (data.auth && data.auth.headers) || {},
            data: { channel_name: data.channel }
        }
        return this.sendRequest(socket, config);
    }

    sendRequest(socket: SocketIO.Socket, config: AxiosRequestConfig): Promise<any> {
        const updatedConfig = Object.assign(config.headers, {
            'Cookie': socket.request.headers.cookie,
            'X-Requested-With': 'XMLHttpRequest'
        });

        return new Promise<any>((resolve, reject) => {
            axios(updatedConfig).then((response: AxiosResponse) => {
                // TODO: errorに関する処理
                if (response.status !== 200) {
                    Logger.default.error('Private channel authentication failed.');
                    reject({
                        reason: 'Cannot be authenticated',
                        status: response.status
                    });
                }
                Logger.default.info('Private channel authentication succeeded.');
                resolve(response.data);
            });
        });
    }
}