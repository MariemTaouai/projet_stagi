<?php 
$mysqli=new mysqli("localhost","root","","login_db");
if ($mysqli->connect_errno)
{
    die("connection error !!");
}
return $mysqli;