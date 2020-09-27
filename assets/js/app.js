import '../css/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import $ from 'jquery';
import io from 'socket.io-client';
import move from 'move-js';
import JsBarcode from 'jsbarcode'

JsBarcode('#barcode').init();

let socket = io('http://45.143.95.87:8888');

let setCoords = (elementId, x, y) => {
    let element = document.getElementById(elementId);
    element.style.position = 'absolute';
    element.style.top = y + 'px';
    element.style.left = x + 'px';
}

socket.on('connect', function() {
    console.log('connected');
});

socket.on('pos', (pos) => {
    console.log(pos);
    const x = Math.floor(pos.x / 5 + 300);
    const y = Math.floor(pos.y / 5 + 300);
    const loaderId = pos.loader;
    const containerId = pos.container;
    setCoords(loaderId, x, y);
    setCoords(containerId, x, y - 20);
});