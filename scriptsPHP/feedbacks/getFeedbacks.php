<?php
$address=$_POST['address'];
//$date=gmdate('Y-m-d H:i:s', time() + 3*3600);
session_start();
print<<<END
<h3 class="contentHeader marketAddress">$address</h3>
END;
//если пользователь авторизован
$isAuth=false;
if(isset($_SESSION['user-info']))
{
    $isAuth=true;
    $lastname=$_SESSION['user-info']['last_name'];
    $firstname=$_SESSION['user-info']['first_name'];
    $profile=$_SESSION['user-info']['profile'];
    $photo=$_SESSION['user-info']['photo'];
print<<<END
    <!--шаблон добавления отзыва-->
    <div class="feedback container">
        <div class="userInfo">
            <a href="$profile"><img src="$photo"> $firstname $lastname</a>
        </div>
        <textarea class="feedbackTextarea"></textarea>
        <input type="button" class='addFeedbackButton' value="Отправить отзыв"/>
    </div>
END;
}
require_once '../mysqlDatabaseAPI/databaseAPI.php';
//ты пока получаешь mysqli_result или null, если запрос навернулся
$allFeedbacks=DatabaseAPI::GetFeedbacks($address);
if($allFeedbacks->num_rows>0){
    //перебираем все отзывы из результата
    while($feedback=mysqli_fetch_assoc($allFeedbacks)){
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
        if($isAuth&&$userProfile==$profile)
        {
            $isUsersFeedback=true;
        }
        //если это отзыв авторизованного пользователя
        if($isUsersFeedback)
        {
            //если отзыв имеет ответ представителя
            if($feedbackComment)
            {
print<<<END
    <div class="feedback container">
        <div class="feedbackTitle">
            <span class="date">
                $date
                $address
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <div class="feedbackText">
            $feedbackText 
        </div>
        <div class="userInfo">
            <img src="images/5ka.png"> Пятёрочка
        </div>
        <div class="feedbackText">
            $feedbackComment 
        </div>
        <input type="button" feedbackId="$feedbackId" value="Удалить свой отзыв"/>
    </div>
END;
            }
            else
            {
print<<<END
    <div class="feedback container">
        <div class="feedbackTitle">
            <span class="date">
                $date
                $address
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <div class="feedbackText">
            $feedbackText 
        </div>
        <input type="button" feedbackId="$feedbackId" value="Удалить свой отзыв"/>
    </div>
END;
            }
        }
        //если отзыв не авторизованного пользователя
        else
        {
            //если отзыв имеет ответ представителя
            if($feedbackComment)
            {
print<<<END
    <div class="feedback container">
        <div class="feedbackTitle">
            <span class="date">
                $date
                $address
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <div class="feedbackText">
            $feedbackText 
        </div>
        <div class="userInfo">
            <img src="images/5ka.png"> Пятёрочка
        </div>
        <div class="feedbackText">
            $feedbackComment 
        </div>
    </div>
END;
            }
            else
            {
print<<<END
    <div class="feedback container">
        <div class="feedbackTitle">
            <span class="date">
                $date
                $address
            </span>
        </div>
        <div class="userInfo">
            <img src="$userPhoto"> <a href="$userProfile">$userName $userLastname</a>
        </div>
        <div class="feedbackText">
            $feedbackText 
        </div>
    </div>
END;
            }
        }
    }
}
else{
print<<<END
<p class="contentHeader">Никто еще не оставил свой отзыв.</p>
END;
}