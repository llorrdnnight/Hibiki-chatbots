<?php
session_start();
include('dbconnect.php');

$result = '';



    if(isset($_SESSION['currentID'])){
      $id = $_SESSION['currentID'];
      $df= mysqli_query($conn,"SELECT * from chats WHERE Room_ID = '$id'");

      {
          while($r = mysqli_fetch_array($df)){
            if($r['Room_ID']==$id){
              if($r['Customer_Employee']=="E"){
                $result.='  <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                '.$r['Text'].'
                                </div>
                                <div class="img_cont_msg">
                            <img src="../images/usericon.png" class="rounded-circle user_img_msg">
                                </div>
                            </div>';
              }else{
                $result.='<div class="d-flex justify-content-start mb-4">
                <div class="img_cont_msg">
                    <img src="../images/usericon.png" class="rounded-circle user_img_msg">
                </div>
                <div class="msg_cotainer">
                '.$r['Text'].'
                </div>
            </div>';
              }
            }
          }  
      }
    }else{

    }

    echo $result;

 ?>
