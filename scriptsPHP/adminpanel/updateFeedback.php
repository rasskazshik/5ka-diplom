<?php
$feedbackId=$_POST['feedbackId'];
$comment=$_POST['commentText'];
$feedback=$_POST['feedbackText'];
require_once '../mysqlDatabaseAPI/databaseAPI.php';
DatabaseAPI::UpdateFeedback($feedbackId,$feedback,$comment);