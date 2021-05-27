document.write('<button class="open-button" onclick="openForm()">Chat</button> <div class="chat-popup" id="myForm"><iframe class="chatframe"');
document.write('src="http://localhost:5000/chat"');
document.write('frameborder="0"></iframe><button type="button" class="btn cancel" onclick="closeForm()">X</button> </div>');
function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }

