<?php
$feedbackId=$_POST['feedbackId'];
require_once '../mysqlDatabaseAPI/databaseAPI.php';
DatabaseAPI::DeleteFeedback($feedbackId);