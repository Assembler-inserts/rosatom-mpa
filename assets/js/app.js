import '../css/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import $ from 'jquery';
import io from 'socket.io-client';
import move from 'move-js';

let socket = io('http://45.143.95.87:8888');

socket.on('connect', function() {
    console.log('connected');
});

socket.on('pos', function(pos) {
    move('#container1').to(Math.abs(pos.x), Math.abs(pos.y)).end();
});