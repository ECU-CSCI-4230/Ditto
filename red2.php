<?php
include('session.php');
if(isset($_SESSION['login_user'])){
    header("Location:account.php");
} else {
    header("Location:signOreg.html");
}