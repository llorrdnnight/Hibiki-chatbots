import chatbot 
from flask import Flask, render_template, request, session
from datetime import timedelta 
import database

app = Flask(__name__)
app.static_folder = 'static'
app.secret_key = "hello"
app.permanent_session_lifetime = timedelta(minutes=1)

@app.route("/chat")
def home():
	session.permanent = True
	if "ID" in session: 
		uniqe_session_id = session["ID"]
		data = database.reloaded_page(uniqe_session_id)
		return render_template("chat2.html",data=data)
	else:
		session["ID"] = database.random_id() #get a uniqe session id 
		return render_template("chat.html")
@app.route("/get")
def getrespont():
	if request.method == "GET": #better POST ?
		if "ID" in session:
			uniqe_session_id = session["ID"]
			if database.AI(uniqe_session_id) :
				user_text = str(request.args.get('search'))
				user_text = user_text.replace('<', "&lt;").replace('>', "&gt;");
				bot_responce = chatbot.chat(user_text) 
				database.insert_chat(uniqe_session_id,"A", user_text)
				database.insert_chat(uniqe_session_id,"R", bot_responce)
				userText ='<div class="outgoing" id="jes"> <span class="msg2">{}</span> </div>'.format(user_text)
				output = '<div class="incomming" id="jes"> <span class="msg1">{}</span> </div>'.format(bot_responce)
				output =   userText + output
				return output 
			else:
				user_text = str(request.args.get('search'))
				user_text = user_text.replace('<', "&lt;").replace('>', "&gt;");
				userText ='<div class="outgoing" id="jes"> <span class="msg2">{}</span> </div>'.format(user_text)
				return userText 
if __name__ == "__main__":
		app.run(debug=True)
		app.run(host = '0.0.0.0',port = 5000)
