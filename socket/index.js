//TODO: update socket.io to verion 4 in package.json, you had to downgrade it because of FLutter
const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
require('dotenv').config();

//https://socket.io/docs/v4/handling-cors/
const io = require("socket.io")(server, {
    cors: {
        origin: process.env.SITE_DOMAIN,
        methods: ["GET", "POST"]
    }
});

var redisPort = process.env.REDIS_PORT;
var redisHost = process.env.REDIS_HOST;
var redisPassword = process.env.REDIS_PASSWORD;
var appEnv = process.env.APP_ENV;
var ioRedis = require('ioredis');

var redis = new ioRedis(
    {
        host: redisHost,
        port: redisPort,
        password: redisPassword
    }
);

redis.subscribe('timechat_database_socket_chat_message_channel');

redis.on('message', function (channel, message) {
    if (appEnv !== 'production') {
        //console.log(message);
        console.log(channel);
    }

    message  = JSON.parse(message);
    io.emit('socket_chat_message_channel_'+message.data.conversation_identifier, message.data);
});

/*
redis.monitor(function (err, monitor) {
    monitor.on('monitor', function (time, args, source, database) {
        console.log(time + ": " + (args));
    });
});
*/

var broadcastPort = process.env.BROADCAST_PORT;
server.listen(broadcastPort, function () {
    console.log('Socket server is running.');
});


app.get('/', (req, res) => {
    res.sendFile(__dirname + '/sample_index.html');
});

io.on('connection', (socket) => {
    console.log('a user connected X');
});

