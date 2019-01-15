<?php
$feedbacks=DatabaseAPI::GetFeedbacksWithoutComment($address);
if($feedbacks->num_rows>0){
print<<<END
    <div class="commentTitle container">
        <h3>Необходимо ответить на отзывы:</h3>
    </div>
END;
    //перебираем все отзывы из результата
    while($feedback=mysqli_fetch_assoc($feedbacks)){
        $marketAdress=$feedback['marketAdress'];
        $feedbackId=$feedback['feedbackId'];
        $date=$feedback['date'];
        $feedbackText=$feedback['feedbackText'];
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
                $date
                $marketAdress
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <div class="feedbackText">
            $feedbackText 
        </div>
        <div class="userInfo">
            Ответ:
        </div>
        <textarea feedbackIdTextarea="$feedbackId" class="feedbackTextarea"></textarea>
        <input type="button" feedbackIdToComment="$feedbackId" value="Ответить на отзыв"/>
        <input type="button" feedbackIdToDelete="$feedbackId" value="Удалить отзыв"/>
    </div>
END;
    }
}
else
{
print<<<END
    <div class="commentTitle container">
        <h3>Новые отзывы отсутствуют</h3>
    </div>
END;
}