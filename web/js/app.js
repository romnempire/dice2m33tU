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
        }
    } else {
        console.log('Message Format Mismatch: onmessage');
        console.log(e.data);
    }
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

function processInboundMessage(json) {
    if (json.user && json.timestamp && json.text) {
        $('#allPosts').append('<div class="message"><div class="text">' + json.text
                          + '</div><div class="metadata">' + json.user + ' '
                          + json.timestamp + '</div></div>');
    } else {
        console.log('Message Format Mismatch: processMessage');
        console.log(e.data);
    }
};

function processInboundMapMove(json) {
    //it would be a good idea to check if the selected object's class is Toy
    if (json.id && json.locationX && json.locationY) {
        $('#' + json.id).css({"left": locationX, "top": locationY});
    } else {
        console.log('Message Format Mismatch: processMapMove');
        console.log(e.data);
    }

};

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
