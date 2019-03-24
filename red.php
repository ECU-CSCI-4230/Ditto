<?php
include('session.php');
if(isset($_SESSION['login_user'])){
    header("Location:index.php");
} else {
    header("Location:signOreg.html");
}
/**
 * Created by PhpStorm.
 * User: mccle
 * Date: 3/24/2019
 * Time: 12:44 AM
 */