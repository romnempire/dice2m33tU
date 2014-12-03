var conn = new WebSocket('ws://hatch04.cs.unc.edu:8080');
var session = {};

conn.onopen = function(e) {
    console.log('Connection established!');
};

conn.onmessage = function(e) {
    var data = $.parseJSON(e.data);
    if (data.cmdType) {
        if (data.cmdType === 'message') {
            processInboundMessage(data);
        } else if (data.cmdType === 'mapmove') {
            processInboundMapMove(data);
        } else if (data.cmdType === 'maplock') {
            processInboundMapLock(data);
        }
    } else {
        console.log('Message Format Mismatch: onmessage');
        console.log(e.data);
    }
};

//Inbound Functions

function processInboundMessage(message) {
    if (message.user && message.timestamp && message.text) {
        $('#allPosts').append('<div class="message"><div class="text">' + message.text
                          + '</div><div class="metadata">' + message.user + ' '
                          + message.timestamp + '</div></div>');
    } else {
        console.log('Message Format Mismatch: processInboundMessage');
        console.log(message);
    }
};

function processInboundMapMove(message) {
    //it would be a good idea to check if the selected object's class is Toy
    if (message.id && message.locationX && message.locationY) {
        $('#' + message.id).css({"left": locationX, "top": locationY});
    } else {
        console.log('Message Format Mismatch: processInboundMapMove');
        console.log(message);
    }
};

//if another user begins altering a toy, grey it out and make it undraggable
function processInboundMapLock(message) {

}

//Outbound Functions

function login(user, session) {
    session.user = user;
    session.session = session;
    $('#login').css({visibility:'hidden'});
    var backlogreq = {'cmdType': 'backlog',
                      'session': session.session,
                      'user': session.user
                     };
    conn.send(JSON.stringify(backlogreq));
};

function processOutboundMapLock(mapobject) {
    var maplockreq = {'cmdType': 'maplock',
                   'user': session.user,
                   'session': session.session,
                   'mapobject': mapobject };
    conn.send(JSON.stringify(maplockreq));
};

function processOutboundMapMove(mapobject, top, left) {
    var mapmovereq = {'cmdType': 'mapmove',
                   'user': session.user,
                   'session': session.session,
                   'mapobject': mapobject,
                   'top': top,
                   'left': left };
    conn.send(JSON.stringify(mapmovereq));
};

function processOutboundMessage(text, timestamp) {
    var messagereq = {'cmdType': 'message',
                   'user': session.user,
                   'session': session.session,
                   'text': text};
    conn.send(JSON.stringify(messagereq));
};

//not tested
function processOutboundDiceRoll(type, quantity) {
    var rollreq = {'cmdType': 'diceroll',
                   'user': session.user,
                   'session': session.session,
                   'type':type,
                   'quantity': quantity };
    conn.send(JSON.stringify(rollreq));
};