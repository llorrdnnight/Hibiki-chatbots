
<!------ Include the above in your HEAD tag ---------->
<?php
    
    include("dbconnect.php");
    if(isset($_GET['chatid'])){
        $_SESSION['currentID'] = $_GET['chatid'];
    };

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf=8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="/common/ico/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/common/ico/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/common/ico/favicon-16x16.png">
		<link rel="manifest" href="/common/ico/site.webmanifest">
		<link rel="mask-icon" href="/common/ico/safari-pinned-tab.svg" color="#7da9da">
		<meta name="msapplication-TileColor" content="#7da9da">
		<meta name="theme-color" content="#ffffff">
	
		<title>Customer Service</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="/bot/jquery.js"></script>
        <link rel="stylesheet" href="/bot/main.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"></script>
		<!-- common style import  -->
		<link href="/employee/src/css/common.css" rel="stylesheet">
	</head>
	<!--Coded With Love By Mutiullah Samim-->
	<body>

	<!-- Add the nav bar to the page -->
    <?php include_once("employee/src/php/navbar.php"); ?>

		<div class="container-fluid">
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
                                $('#problemfix').load('/bot/chatref.php');
                                    /*var auto_refresh = setInterval(function(){
                                    $('#problemfix').load('/bot/chatref.php');
                                    return false;}, 5000);*/
                                </script>
						</ui>
					</div>
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
                                $('#problemfix2').load('/bot/chatrefemp.php');
                                    /*var auto_refresh = setInterval(function(){
                                    $('#problemfix2').load('/bot/chatrefemp.php');
                                    return false;}, 5000);*/
                                </script>

						</ui>
					</div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="/bot/images/usericon.png" class="rounded-circle user_img">
									
								</div>
								<div class="user_info">
									<span>Chat with <?php if(isset($_SESSION['currentID'])){ echo $_SESSION['currentID'];}?>
									
									</span>
									
									
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
						$('#mainchat').load('/bot/mainchat.php');
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
		<?php 
									if(isset($_SESSION['currentID'])){
										echo "<script>var Room_ID = '".$_SESSION['currentID']."';</script><script src='/bot/chatbot.js'></script>";
									};	
									?>
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

	window.location.href = "/bot/chatchange.php?menu=" + this.id;

    /*$.get('/bot/chatchange.php', { menu: this.id }, function(data){

    });*/
});
</script>

