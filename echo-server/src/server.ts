import * as dotenv from 'dotenv';
import * as FileSystem from 'fs';
import { ServerManager } from './ServerManager';

dotenv.config({
    path: __dirname + '/../../.env'
});

const env = process.env;
let config: any = {
    authHost: env.APP_URL,
    port: env.SOCKETIO_PORT,
    http: {
        protocol: env.SOCKETIO_PROTOCOL,
    },
    redis: {
        path: env.REDIS_SOCKET,
        password: env.REDIS_PASSWORD,
        db: 4,
    },
};

if (env.SOCKETIO_PROTOCOL === 'https') {
    config.http.key = FileSystem.readFileSync(env.SSL_KEY || '');
    config.http.cert = FileSystem.readFileSync(env.SSL_CERT || '');
}

const app = new ServerManager(config);
app.run();