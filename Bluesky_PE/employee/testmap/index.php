
<!------ Include the above in your HEAD tag ---------->
<?php
    
    include("dbconnect.php");
    session_start();
    if(isset($_GET['chatid'])){
        $_SESSION['currentID'] = $_GET['chatid'];
    };

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script  type="text/javascript" src="./jquery.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="jquery.js"></script>
        <link rel="stylesheet" href="main.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"></script>
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<body>

		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
					<div class="input-group">
							<div class="user_info">
								<span>chats by AI</span>
							</div>
						</div>
					</div>
					<div  class="card-body contacts_body">
						<ui id="problemfix" class="contacts">
						
                            <script type="text/javascript">
                                $('#problemfix').load('chatref.php');
                                    var auto_refresh = setInterval(function(){
                                    $('#problemfix').load('chatref.php');
                                    return false;}, 5000);
                                </script>
						</ui>
					</div>
					
					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<div class="user_info">
								<span>chats in progress</span>
							</div>
						</div>
					</div>
					<div  class="card-body contacts_body">
						
						<ui id="problemfix2" class="contacts">
						
                            <script type="text/javascript">
                                $('#problemfix2').load('chatrefemp.php');
                                    var auto_refresh = setInterval(function(){
                                    $('#problemfix2').load('chatrefemp.php');
                                    return false;}, 5000);
                                </script>

						</ui>
					</div>
					
					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="../images/usericon.png" class="rounded-circle user_img">
									
								</div>
								<div class="user_info">
									<span>Chat with <?php if(isset($_SESSION['currentID'])){ echo $_SESSION['currentID'];}?>
									<?php if(isset($_SESSION['currentID'])){
									echo "<script>var Room_ID = '".$_SESSION['currentID']."';</script><script src='./chatbot.js'></script></span>";
									};	?>
									
									
								</div>
								
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul class="chatalter">
									<li id="remove"><a href="?action=test"><i class="fas fa-trash"></i> Remove Chat</a></li>
									<li id="enable"><i class="fas fa-robot"></i> Enable AI</li>
									<li id="route"><i class="fas fa-sign-out-alt"></i> Leave Chat</li>
								</ul>
							</div>
						</div>
						<div id="mainchat" class="card-body msg_card_body">
							
						<script type="text/javascript">
						$('#mainchat').load('mainchat.php');
						</script>
							
						</div>
						<div class="card-footer">
							<div class="input-group">
									<input class="form-control type_msg" type="text" id="chatControlsText" name="message"/>
									<div class="input-group-append">
										<input class="input-group-text send_btn" type="submit" name="send" onclick="sendMsg()"/>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script>
//scrolt chat naar laatste bericht
$('#mainchat').animate({
scrollTop: $('#mainchat').get(0).scrollHeight}, 250);

$(document).ready(function(){
    $('#action_menu_btn').click(function() {
      $('.action_menu').toggle("slide");
    });
});

$('.chatalter li').on('click', function(){
    $.get('chatchange.php', { menu: this.id }, function(data){

    });
});
</script>

