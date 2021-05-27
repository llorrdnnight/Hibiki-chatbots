from flask import Flask, render_template
from flask_socketio import *
from bot import *
from database import *



app = Flask(__name__)
app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app, cors_allowed_origins='*')

@socketio.event
def connect():
    print("I'm connected!")

@socketio.event
def connect_error(data):
    print("The connection failed!")

@socketio.event
def disconnect():
    print("I'm disconnected!")

@socketio.on('message')
def handle_message(msg):
    print(msg)

    if msg["type"] == "connected":
        print("new connection")
        context[msg["room"]] = {}
        active_tag_list[msg["room"]] = []
        join_room(msg["room"])
        New_room(msg["room"]) #database save room 
        #Hi! What can I do for you?
        #insert_chat( msg["room"], "E", "Hi! What can I do for you?" )
        #emit('room_message', {"type":"response", "data": "Hi! What can I do for you?"}, room=msg["room"])
    elif msg["type"] == "message":
        if not msg["data"] == "":
            insert_chat( msg["room"], "C", str(msg["data"])) #saves user mesage in database
            #print("Message from client: " + str(msg["data"]))
            emit('room_message', {"type":"message", "data": str(msg["data"])}, room=msg["room"])
            if AI_check(msg["room"]):    
                if msg["data"] == "context":
                    print(context)
                # get a output prediction from the model
                results = model.predict([bag_of_words(str(msg["data"]), words, msg["room"])])
                
                # get the index with the highest value (probability)
                results_index = numpy.argmax(results)
                print(results_index)
                if results[0][results_index] < 0.05:
                    emit('room_message', {"type":"response", "data": random.choice(no_response)}, room=msg["room"])
                else:
                    # get the tag that matches the highest index
                    tag = labels[results_index]
                    for tg in data["intents"]:
                        if tg['tag'] == tag:
                            aswerTag(tg, msg["room"])
                            break

    elif msg["type"] == "Employee":
        insert_chat( msg["room"], "E", str(msg["data"])) #saves user mesage in database
        emit('room_message', {"type":"response", "data": str(msg["data"])}, room=msg["room"])

if __name__ == '__main__':
    socketio.run(app, host='0.0.0.0', port=5000)
    
