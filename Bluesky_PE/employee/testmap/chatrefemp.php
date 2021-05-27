<?php
include ('dbconnect.php');
session_start();
$employee = 'soosis';

    

$df= mysqli_query($conn,"SELECT * FROM `chatrooms` WHERE AI_ON_OFF = 'OFF'");
    if(mysqli_num_rows($df) == 0)
    {
        echo "No results found.";
    }
    else
    {
        while($r = mysqli_fetch_array($df)){
            
            $test = $r['Room_ID'];
            $url = "index.php?chatid=".$test;

            echo   "<li>
                            <div class='d-flex bd-highlight'>
                                <div class='img_cont'>
                                    <img src='../images/usericon.png' class='rounded-circle user_img'>
                                </div>
                                <div class='user_info'>
                                <a href='$url'><span> $test </span></a>
                                </div>
                                <div class='user_info'>
                                    <form method='get' action='chatchange.php'>
                                        <button class='knop' type'submit'  name='ON' value='$test'><i class='fas fa-robot'/>Turn ON AI</button>
                                        <button class='knop' type'submit'  name='DEL' value='$test'><i class='fas fa-trash'/>Delete Chat</button>
                                    </form>
                                </div>
                            </div>
                    </li>";
        }    
    }
    
 ?>