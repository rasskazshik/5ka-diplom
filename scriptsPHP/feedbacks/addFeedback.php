<?php
$marketAddress=$_POST['address'];
$feedbackText=$_POST['feedbackText'];
session_start();
//если пользователь авторизован
if(isset($_SESSION['user-info']))
{
    $lastname=$_SESSION['user-info']['last_name'];
    $firstname=$_SESSION['user-info']['first_name'];
    $profile=$_SESSION['user-info']['profile'];
    $photo=$_SESSION['user-info']['photo'];
    require_once '../mysqlDatabaseAPI/databaseAPI.php';
    //вызов метода добавления пользователя
    DatabaseAPI::AddFeedback($firstname,$lastname,$photo,$profile,$marketAddress,$feedbackText);
}