<?php
session_start();
include ('dbconnect.php');
$employee = 'soosis';
$id = $_SESSION['currentID'];

    //zet AI aan
    if(isset($_GET['ON'])){
        echo $_GET['ON']; //test echo
        $chatid = $_GET['ON'];
        $query = "UPDATE `chatrooms` SET `Employee`= '$employee' ,`AI_ON_OFF`='ON' WHERE `Room_ID` LIKE '$chatid'";
        mysqli_query($conn, $query) or die ("Error: an error has occurred while executing the query.");

    //zet AI uit
    }elseif(isset($_GET['OFF'])){
        echo $_GET['OFF']; //test echo
        $chatid = $_GET['OFF'];
        $query = "UPDATE `chatrooms` SET `Employee`= '$employee' ,`AI_ON_OFF`='OFF' WHERE `Room_ID` LIKE '$chatid'";
        mysqli_query($conn, $query) or die ("Error: an error has occurred while executing the query.");
    
    //Delete chat    
    }elseif(isset($_GET['DEL'])){
        echo $_GET['DEL']; //test echo
        $chatid = $_GET['DEL'];
        $query = "DELETE FROM `chatrooms` WHERE `Room_ID` LIKE '$chatid'";
        mysqli_query($conn,$query)or exit("Failed to connect");
        $query = "DELETE FROM `chats` WHERE `Room_ID` LIKE '$chatid'";
        mysqli_query($conn,$query)or exit("Failed to connect");
    }
    elseif(isset($_GET['menu'])){

        switch($_GET['menu']){
            case 'remove':
                $query = "DELETE FROM chatrooms WHERE Room_ID LIKE '$id'";
                mysqli_query($conn,$query)or exit("Failed to connect");
                $query = "DELETE FROM chats WHERE Room_ID LIKE '$id'";
                mysqli_query($conn,$query)or exit("Failed to connect");
                unset($_GET['chatid']);
                unset($_SESSION['currentID']);
                header("Location: /portal/customerservice");
                break;
            case 'enable':
                $query = "UPDATE chatrooms SET employee='AI', AI_ON_OFF='ON' WHERE Room_ID LIKE '$id'";
                mysqli_query($conn,$query)or exit("Failed to connect");
                break;
            case 'route':
                $query = "UPDATE chatrooms SET employee='$employee', AI_ON_OFF='OFF'  WHERE Room_ID LIKE '$id'";
                mysqli_query($conn,$query)or exit("Failed to connect");
                break;
            default:
                break;
        }

    }

    header("Location: /portal/customerservice");
?>