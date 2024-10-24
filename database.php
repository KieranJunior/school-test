<?php

$host_name = "localhost";
$db = "tlevel_kieran";
$db_password = "Kjunior10.";
$username = "tlevel_kieran";

$con = mysqli_connect("$host_name","$username","$db_password","$db");
if(!$con){
    die("something went wrong");
}
