<?php
$password=$_POST['password'];
require_once '../scriptsPHP/mysqlDatabaseAPI/databaseAPI.php';
if(!DatabaseAPI::CheckAdminPassword($password)){
    exit("access denine");
}

print<<<END
    <div class="row adminpanel container no-gutters">
        <span  class="container"><div class="waitForCommentButton">Ответить на отзывы</div></span>
    </div>
    <div class='containerForFeedbacksWithoutComment container'>
END;

require_once '../scriptsPHP/adminpanel/getFeedbacksWithoutComment.php';

print<<<END
    </div>
    <div class="row adminpanel container no-gutters">
        <span  class="container"><div class="manageFeedbackButton">Управление отзывами</div></span>
    </div>
    <div class='containerForManageFeedbacks container'>
END;
require_once '../scriptsPHP/adminpanel/manageFeedbacks.php';
echo '</div>';

