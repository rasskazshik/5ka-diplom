<?php
$feedbackId=$_POST['feedbackId'];
$comment=$_POST['commentText'];
require_once '../mysqlDatabaseAPI/databaseAPI.php';
DatabaseAPI::UpdateComment($feedbackId,$comment);