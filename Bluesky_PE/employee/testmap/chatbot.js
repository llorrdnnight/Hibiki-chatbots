let socket = null;
let room = Room_ID;


    console.log("room:", room);

    //socket = io("http://10.128.30.7",{
    //    path: '/chat'
    //});

    //socket = io.connect('http://10.128.47.135:5000/');
    socket = io.connect('http://localhost:5000/');


    socket.on('connect', function () {
        console.log("chat connected");
        // join the room
        socket.emit('join', room);
        // send connection message to server
        let msg = { type: "connected", data: {}, id: socket.id, room: room }
        socket.send(msg);

        socket.on('room_message', function (msg) {
            console.log(msg);

            if(msg.type == "message") {
                $( "#mainchat" ).append(`<div class="d-flex justify-content-start mb-4">
                <div class="img_cont_msg">
                    <img src="../images/usericon.png" class="rounded-circle user_img_msg">
                </div>
                <div class="msg_cotainer">
                ${msg.data}
                </div>
                </div>`);
                // scroll to bottom
                let box = document.getElementById("mainchat");
                box.scrollTop = box.scrollHeight;
            } else if(msg.type == "response_page") {

                let linkNode = document.createElement("a");
                let textnode = document.createTextNode(msg.data);
                linkNode.appendChild(textnode);
                linkNode.href = msg.link;

                let node = document.createElement("div");
                node.className = "chat-response";
                node.appendChild(linkNode);
    
                let wrapper = document.createElement("div");
                wrapper.appendChild(node);
                wrapper.className = "chat-wrapper";
    
                document.getElementById("chatMessages").appendChild(wrapper);
    
                // scroll to bottom
                let box = document.getElementById("chatMessages");
                box.scrollTop = box.scrollHeight;
            }

            
        });
    });

    socket.on('disconnect', function () {
        console.log('chat disconnected');
    });

    // https://www.w3schools.com/howto/howto_js_trigger_button_enter.asp
    // Get the input field
    let input = document.getElementById("chatControlsText");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", handleEnter);



function handleEnter(event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        if (document.getElementById("chatControlsText").value != ""){
            // Cancel the default action, if needed
            event.preventDefault();
            // sen message
            sendMsg();
        }
    }

}

function stopChat() {
    document.getElementById("chatbox").style.display = "none";
    document.getElementById("chatActionButton").style.display = "block";
    socket.disconnect();

    // remove event listeren
    let input = document.getElementById("chatControlsText");
    input.removeEventListener("keyup", handleEnter);
}

function sendMsg() {
    if (socket.connected) {
        let msg = { type: "Employee", data: document.getElementById("chatControlsText").value, id: socket.id, room: room }
        socket.send(msg);
        $( "#mainchat" ).append(`<div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                ${document.getElementById("chatControlsText").value}
                                </div>
                                <div class="img_cont_msg">
                            <img src="../images/usericon.png" class="rounded-circle user_img_msg">
                                </div>
        </div>`);
      

        // scroll to bottom
        let box = document.getElementById("mainchat");
        box.scrollTop = box.scrollHeight;
    } else {
        console.log("Not connected");
    }
}


