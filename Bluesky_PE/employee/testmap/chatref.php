<?php
include ('dbconnect.php');


    

    $df= mysqli_query($conn,"SELECT * FROM `chatrooms` WHERE  `AI_ON_OFF` = 'ON'");
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
                                        <button class='knop' type'submit'  name='OFF' value='$test'><i class='fas fa-robot'/>Turn OFF AI</button>
                                        <button class='knop' type'submit'  name='DEL' value='$test'><i class='fas fa-trash'/>Remove Chat</button>
                                    </form>
                                </div>
                            </div>
                        
                    </li>";
        }    
    }
    
 ?>


                         