import { ServerManager } from './ServerManager';
import * as dotenv from 'dotenv';
import * as FileSystem from 'fs';

dotenv.config({
    path: __dirname + '/../../.env'
});

const env = process.env;
const config = {
    authHost: env.APP_URL,
    port: env.SOCKETIO_PORT,
    http: {
        protocol: 'https',
        key: FileSystem.readFileSync(env.SSL_KEY),
        cert: FileSystem.readFileSync(env.SSL_CERT)
    },
    redis: {
        path: env.REDIS_SOCKET,
        password: env.REDIS_PASSWORD,
        db: 4
    },
};

const app = new ServerManager(config);
app.run();