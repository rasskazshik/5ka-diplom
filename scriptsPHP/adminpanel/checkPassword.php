<?php
$password=$_POST['password'];
require_once '../mysqlDatabaseAPI/databaseAPI.php';
if(!DatabaseAPI::CheckAdminPassword($password)){
    exit("access denine");
}