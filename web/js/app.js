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
        } else if (data.cmdType === 'newtoy') {
            processInboundToy(data);
        } else if (data.cmdType === 'toylock') {
            processInboundToyLock(data);
        } else if (data.cmdType === 'toymove') {
            processInboundToyMove(data);
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

function processInboundToy(message) {
    console.log('recieving toy');
    console.log(message);
    dropInImage(message.url, message.tid);
}

//if another user begins altering a toy, grey it out and make it undraggable
function processInboundToyLock(message) {
    console.log('locking toy');
    lockImage(message.tid);
}

function processInboundToyMove(message) {
    console.log('moving toy');
    //it would be a good idea to check if the selected object's class is Toy
    if (message.tid && message.left && message.top) {
        moveImage(message.tid, message.top, message.left);
        //$('#' + message.tid).css({"left": locationX, "top": locationY});
    } else {
        console.log('Message Format Mismatch: processInboundToyMove');
        console.log(message);
    }
};

//Outbound Functions

function login(user, sesh) {
    session.user = user;
    session.session = sesh;
    $('#login').css({visibility:'hidden'});
    var backlogreq = {'cmdType': 'backlog',
                      'session': session.session,
                      'user': session.user
                     };
    conn.send(JSON.stringify(backlogreq));
};

function processOutboundToy(url) {
    console.log('sending toy')
    var maplockreq = {'cmdType': 'newtoy',
                   'user': session.user,
                   'session': session.session,
                   'url': url };
    conn.send(JSON.stringify(maplockreq));
};

function processOutboundToyLock(tid) {
    var maplockreq = {'cmdType': 'toylock',
                   'user': session.user,
                   'session': session.session,
                   'tid': tid
                    };
    console.log(maplockreq);
    conn.send(JSON.stringify(maplockreq));
};

function processOutboundToyMove(tid, top, left) {
    var mapmovereq = {'cmdType': 'toymove',
                   'user': session.user,
                   'session': session.session,
                   'tid': tid,
                   'top': top,
                   'left': left };
    console.log(mapmovereq);
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
