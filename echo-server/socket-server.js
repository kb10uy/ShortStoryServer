const Redis = require('ioredis');
const Cookie = require('cookie');
const Crypto = require('crypto');
const PHPUnserialize = require('php-unserialize');
const SocketIO = require('socket.io');
const FileSystem = require('fs');
const _ = require('lodash');
require('dotenv').config({
    path: __dirname + '/../.env'
});

const env = process.env;
const port = env.SOCKETIO_PORT;
const redisSetting = {
    path: env.REDIS_SOCKET,
    password: env.REDIS_PASSWORD,
    db: env.REDIS_BROADCAST_DB_NUMBER
};
const redis = new Redis(redisSetting);
const redisReceiver = new Redis(redisSetting);

var server = null;
if (env.APP_PROTOCOL === 'https') {
    server = require('https').createServer({
        key: FileSystem.readFileSync(env.SSL_KEY),
        cert: FileSystem.readFileSync(env.SSL_CERT)
    });
    console.log('Using HTTPS');
} else {
    server = require('http').createServer();
}
const io = SocketIO(server);
server.listen(port);
// -------------------------------------------------

redisReceiver.psubscribe('*', (err, count) => {});
redisReceiver.on('pmessage', onBroadcastMessage);

io.on('connection', (user) => {
    console.log('User connected.');
});

console.log('ShortStoryServer Socket.io Server Started on Port ' + port);

// -------------------------------------------------
function onBroadcastMessage(subscribe, channel, messageJson) {
    const message = JSON.parse(messageJson);
    if (message.socket && findConnection(message.socket)) {
        sendToOthers(findConnection(message.socket), channel, message);
    } else {
        sendAll(channel, message);
    }
    console.log(channel, message.event, message.data);
}

function sendAll(channel, message) {
    io.to(channel).emit(message.event, channel, message.data);
}

function sendToOthers(socket, channel, message) {
    socket.broadcast.to(channel).emit(message.event, channel, message.data);
}

function findConnection(socketId) {
    return io.sockets.connected[socketId];
}