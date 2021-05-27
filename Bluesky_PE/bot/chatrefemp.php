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
            $url = "/portal/customerservice?chatid=".$test;

            echo   "<li>
                        <div class='row'>
                            <!--<div class='col'>
                                <img src='/bot/images/usericon.png' class='rounded-circle user_img'>
                            </div>-->
                            <div class='col'>
                                <a href='$url'>$test</a>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col'>
                                <form method='get' action='/bot/chatchange.php'>
                                    <button class='knop btn btn-sm btn-dark' type'submit'  name='ON' value='$test'><i class='fas fa-robot'/> Turn ON AI</button>
                                    <button class='knop btn btn-sm btn-dark' type'submit'  name='DEL' value='$test'><i class='fas fa-trash'/> Remove Chat</button>
                                </form>
                            </div>
                        </div>
                    </li>";
        }    
    }
    
 ?>