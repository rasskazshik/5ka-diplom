<?php
$userId=$_POST['userId'];
$marketId=$_POST['marketId'];
require_once '../mysqlDatabaseAPI/databaseAPI.php';
$feedbacks=DatabaseAPI::GetSearchedFeedbacks($userId,$marketId);
if($feedbacks->num_rows>0){
print<<<END
    <div class="commentTitle container">
        <h3>Найдено:</h3>
    </div>
END;
    //перебираем все отзывы из результата
    while($feedback=mysqli_fetch_assoc($feedbacks)){
        $marketAdress=$feedback['marketAdress'];
        $deletedByUser=$feedback['deletedByUser'];
        $deletedByUserMark="Активный отзыв";
        if($deletedByUser==1)
        {
            $deletedByUserMark="Удаленный пользователем отзыв";
        }
        $feedbackId=$feedback['feedbackId'];
        $date=$feedback['date'];
        $feedbackText=$feedback['feedbackText'];
        $feedbackComment=$feedback['feedbackComment'];
        $userId=$feedback['userId'];
        $userName=$feedback['userName'];
        $userLastname=$feedback['userLastname'];
        $userPhoto=$feedback['userPhoto'];
        $userProfile=$feedback['userProfile'];
        $isUsersFeedback=false;
print<<<END
    <div class="feedback container">
        <div class="feedbackTitle">
            <span class="date">
                $deletedByUserMark
                $date
                $marketAdress
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <textarea feedbackIdTextareaFeedback="$feedbackId" class="feedbackTextarea">$feedbackText</textarea>
        <div class="userInfo">
            Ответ:
        </div>
        <textarea feedbackIdTextareaComment="$feedbackId" class="feedbackTextarea">$feedbackComment</textarea>
        <input type="button" feedbackIdToUpdate="$feedbackId" value="Изменить текст отзыва"/>
        <input type="button" feedbackIdToDeleteSearch="$feedbackId" value="Удалить отзыв"/>
    </div>
END;
    }
}
else
{
print<<<END
    <div class="commentTitle container">
        <h3>Искомые отзывы отсутствуют</h3>
    </div>
END;
}