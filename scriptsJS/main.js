//флаг активного анимирования навигации
var navNotAnimate=true;

//вызов скрипта удаления сессионных данных пользователя
//и перезагрузка страницы
$(document).on('click','.logout',function(){
    $.post("scriptsPHP/userAuth/logOut.php",{},function(){
        window.location = window.location.href;;
    });
});

//выгрузка контента с предназначением ресурса
function NavToPurpose(){     
    navNotAnimate=false;
    $(".navigation a").removeClass("active");
    $(".navToPurpose").addClass("active");
    $.post("content/purpose.php",function(responce){
        $(".contentRow").slideToggle(500,function(){
            $(".contentRow").html(responce);
            $(".contentRow").slideToggle(500,function(){                    
                navNotAnimate=true;
            });
        }); 
   });
}

$(".navToPurpose").on("click",function(event){
    event.preventDefault();
    if(navNotAnimate&&!$(".navToPurpose").hasClass("active"))
    {   
        NavToPurpose();
        $.cookie("navTo","ToPurpose");
    }
});

//выгрузка контента со списком торговых точек
function NavToFeedback(){ 
    navNotAnimate=false;
    $(".navigation a").removeClass("active");
    $(".navToFeedback").addClass("active");
    $.post("content/feedback.php",function(responce){
        $(".contentRow").slideToggle(500,function(){
            $(".contentRow").html(responce);
            $(".contentRow").slideToggle(500,function(){
                navNotAnimate=true;
            });
        }); 
   });
}

$(".navToFeedback").on("click",function(event){
    event.preventDefault();
    if(navNotAnimate&&!$(".navToFeedback").hasClass("active"))
    {    
        NavToFeedback();
        $.cookie("navTo","ToFeedback");
    }
});

//выгрузка контента со списком предложений торговой сети Пятерочка
function NavToOtherOrders(){     
        navNotAnimate=false;
        $(".navigation a").removeClass("active");
        $(".navToOtherOrders").addClass("active");
        $.post("content/otherOrders.php",function(responce){
            $(".contentRow").slideToggle(500,function(){
                $(".contentRow").html(responce);
                $(".contentRow").slideToggle(500,function(){
                    navNotAnimate=true;
                });
            }); 
       });
}
$(".navToOtherOrders").on("click",function(event){
    event.preventDefault();
    if(navNotAnimate&&!$(".navToOtherOrders").hasClass("active"))
    {  
        NavToOtherOrders();
        $.cookie("navTo","ToOtherOrders");
    }
});

//навигация с запросом cookie-данных
function Navigate(){
    var navigate = $.cookie("navTo");
    if (navigate==""||navigate==null) {
        $.cookie("navTo","ToPurpose");
        NavToPurpose();
        return;
    }
    if (navigate=="ToPurpose") {
        NavToPurpose();
        return;
    }
    if (navigate=="ToFeedback") {
        NavToFeedback();
        return;
    }
    if (navigate=="ToOtherOrders") {
        NavToOtherOrders();
        return;
    }
}

$(document).ready(Navigate());

//добавление нового отзыва
$(document).on('click','.addFeedbackButton',function(){
    //получение данных
    let address=$(".marketAddress").html();
    let text=$(".feedbackTextarea").val();
    if(text=="")
    {
        alert("Нельзя оставить пустым поле отзыва!");
        return;
    }
    $.post("scriptsPHP/feedbacks/addFeedback.php",{address:address,feedbackText:text},function(){
        //callback после добавления - обновляем список отзывов 
        $.post("scriptsPHP/feedbacks/getFeedbacks.php",{address:address},function(feedbacks){
            $(".feedbackContainer").slideToggle(500,function(){
            $(".feedbackContainer").html(feedbacks);
            $(".feedbackContainer").slideToggle(500);
            });
        });
    });
});

//маркировка пользователем отзыва как удаленного
$(document).on('click','[feedbackId]',function(){
    //подтверждение намерения
    if(!confirm("Вы точно желаете удалить свой отзыв?"))
    {
        return;
    }
    //получение данных
    let address=$(".marketAddress").html();
    let feedbackId=$(this).attr("feedbackId");
    $.post("scriptsPHP/feedbacks/markDeletedByUser.php",{feedbackId:feedbackId},function(){
        //callback после маркировки - обновляем список отзывов 
        $.post("scriptsPHP/feedbacks/getFeedbacks.php",{address:address},function(feedbacks){
            $(".feedbackContainer").slideToggle(500,function(){
            $(".feedbackContainer").html(feedbacks);
            $(".feedbackContainer").slideToggle(500);
            });
        });
    });
});

//переход к контенту администратора
$(".authButton").on("click",function(){    
    navNotAnimate=false;
    $(".navigation a").removeClass("active");
    let password = $("#adminPassword").val();
    $.post("content/adminpanel.php",
    {
        password:password
    },
    function(responce){
        if(responce=="access denine")
        {
            //добавляем маркер ошибки
            $("#adminPassword").addClass("is-invalid");            
            return;
        }
        //чистим поле с паролем
        $("#adminPassword").val("");
        //убираем маркер ошибки, если он был
        $("#adminPassword").removeClass("is-invalid");
        $('#adminAuth').modal('hide');
        //вставляем динамически сгенерированный контент
        $(".contentRow").slideToggle(500,function(){
            $(".contentRow").html(responce);
            $(".contentRow").slideToggle(500,function(){
                navNotAnimate=true;
            });
        }); 
    });
});

//удаление отзыва из базы данных в ответе
$(document).on('click','[feedbackIdToDelete]',function(){
    //подтверждение намерения
    if(!confirm("Вы точно желаете удалить отзыв? Отзыв навсегда будет стерт из базы данных."))
    {
        return;
    }
    //получение данных
    let feedbackId=$(this).attr("feedbackIdToDelete");
    $.post("scriptsPHP/adminpanel/deleteFeedback.php",{feedbackId:feedbackId},function(){
        //callback после удаления - обновляем список отзывов 
        $.post("scriptsPHP/adminpanel/getFeedbacksWithoutCommentForAjax.php",{},function(feedbacks){
            $(".containerForFeedbacksWithoutComment").slideToggle(500,function(){
            $(".containerForFeedbacksWithoutComment").html(feedbacks);
            $(".containerForFeedbacksWithoutComment").slideToggle(500);
            });
        });
    });
});

//обновление комментария в ответе
$(document).on('click','[feedbackIdToComment]',function(){
    //получение данных
    let feedbackId=$(this).attr("feedbackIdToComment");
    let commentText=$("[feedbackIdTextarea='"+feedbackId+"']").val();
    if(commentText=="")
    {
        alert("Нельзя оставить пустым поле комментария!");
        return;
    }
    //подтверждение намерения
    if(!confirm("Вы точно желаете прокомментировать отзыв?"))
    {
        return;
    }
    
    $.post("scriptsPHP/adminpanel/updateComment.php",{feedbackId:feedbackId,commentText:commentText},function(){
        //callback после обновления комментария - обновляем список отзывов 
        $.post("scriptsPHP/adminpanel/getFeedbacksWithoutCommentForAjax.php",{},function(feedbacks){
            $(".containerForFeedbacksWithoutComment").slideToggle(500,function(){
            $(".containerForFeedbacksWithoutComment").html(feedbacks);
            $(".containerForFeedbacksWithoutComment").slideToggle(500);
            });
        });
    });
});

//кнопки открытия и закрытия разделов административной панели
$(document).on("click",".waitForCommentButton",function(){
    $(".containerForFeedbacksWithoutComment").slideToggle(500);
});
$(document).on("click",".manageFeedbackButton",function(){
    $(".containerForManageFeedbacks").slideToggle(500);
});

//пользовательская валидация ввода имени (необходима для препятсвования ввода "левых" значений)
//на старых браузерах проверка не работает, необходима серверная валидация
$(document).on('change','[list="usersNames"]', function() {
    var optionFound = false,
      datalist = this.list;
    // Определение, существует ли option с текущим значением input.
    for (var i = 0; i < datalist.options.length; i++) {
        if ((this.value == datalist.options[i].value)||(this.value=="")) {
            optionFound = true;
            break;
        }
    }
    // используйте функцию setCustomValidity API проверки ограничений валидации
    // чтобы обеспечить ответ пользователю, если нужное значение в datalist отсутствует
    if (optionFound) {
      this.setCustomValidity('');
    } else {
      this.setCustomValidity('Пожалуйста, выберите значение из списка');
    }
});  
//пользовательская валидация ввода имени (необходима для препятсвования ввода "левых" значений)
//на старых браузерах проверка не работает, необходима серверная валидация
$(document).on('change','[list="marketAddresses"]', function() {
    var optionFound = false,
      datalist = this.list;
    // Определение, существует ли option с текущим значением input.
    for (var i = 0; i < datalist.options.length; i++) {
        if ((this.value == datalist.options[i].value)||(this.value=="")) {
            optionFound = true;
            break;
        }
    }
    // используйте функцию setCustomValidity API проверки ограничений валидации
    // чтобы обеспечить ответ пользователю, если нужное значение в datalist отсутствует
    if (optionFound) {
      this.setCustomValidity('');
    } else {
      this.setCustomValidity('Пожалуйста, выберите значение из списка');
    }
}); 

//поиск комментариев
$(document).on("click",".adminpanelSearchButton",function(){
    //запуск валидации формы
    //!!!-----------------------------------необходимо протестировать на дроиде----------------------------------------------------!!!
    let check = $(".searchForm")[0].checkValidity();
    if(check)
    {
        //получение данных
        let name=$(".searchName").val();
        let userId="";
        if (name!="")
        {
            userId = $("[value='"+name+"']").attr("userId");
        }
        let address=$(".searchAddress").val();
        let marketId="";
        if(address!="")
        {
            marketId = $("[value='"+address+"']").attr("marketId");
        }
        //отправка данных в серверный скрипт (предусмотреть серверную валидацию)
        $.post("scriptsPHP/adminpanel/search.php",{userId:userId,marketId:marketId},function(feedbacks){
            $(".searchContainer").slideToggle(500,function(){
            $(".searchContainer").html(feedbacks);
            $(".searchContainer").slideToggle(500);
            });
        });
    }
});

//удаление отзыва из базы данных в поиске
$(document).on('click','[feedbackIdToDeleteSearch]',function(){
    //подтверждение намерения
    if(!confirm("Вы точно желаете удалить отзыв? Отзыв навсегда будет стерт из базы данных."))
    {
        return;
    }
    //получение данных
    let feedbackId=$(this).attr("feedbackIdToDeleteSearch");
    $.post("scriptsPHP/adminpanel/deleteFeedback.php",{feedbackId:feedbackId},function(){
        //callback после удаления - обновляем список отзывов 
        //запуск валидации формы
        //!!!-----------------------------------необходимо протестировать на дроиде----------------------------------------------------!!!
        let check = $(".searchForm")[0].checkValidity();
        if(check)
        {
            //получение данных
            let name=$(".searchName").val();
            let userId="";
            if (name!="")
            {
                userId = $("[value='"+name+"']").attr("userId");
            }
            let address=$(".searchAddress").val();
            let marketId="";
            if(address!="")
            {
                marketId = $("[value='"+address+"']").attr("marketId");
            }
            //отправка данных в серверный скрипт (предусмотреть серверную валидацию)
            $.post("scriptsPHP/adminpanel/search.php",{userId:userId,marketId:marketId},function(feedbacks){
                $(".searchContainer").slideToggle(500,function(){
                $(".searchContainer").html(feedbacks);
                $(".searchContainer").slideToggle(500);
                });
            });
        }
    });
});

//обновление комментария в поиске
$(document).on('click','[feedbackIdToUpdate]',function(){
    //получение данных
    let feedbackId=$(this).attr("feedbackIdToUpdate");
    let feedbackText=$("[feedbackIdTextareaFeedback='"+feedbackId+"']").val();
    if(feedbackText=="")
    {
        alert("Нельзя оставить пустым поле отзыва!");
        return;
    }
    let commentText=$("[feedbackIdTextareaComment='"+feedbackId+"']").val();
    if(commentText=="")
    {
        alert("Нельзя оставить пустым поле комментария!");
        return;
    }
    //подтверждение намерения
    if(!confirm("Вы точно желаете изменить текст отзыва?"))
    {
        return;
    }
    
    $.post("scriptsPHP/adminpanel/updateFeedback.php",{feedbackId:feedbackId,commentText:commentText,feedbackText:feedbackText},function(){
        //callback после обновления комментария - обновляем список отзывов 
        //запуск валидации формы
        //!!!-----------------------------------необходимо протестировать на дроиде----------------------------------------------------!!!
        let check = $(".searchForm")[0].checkValidity();
        if(check)
        {
            //получение данных
            let name=$(".searchName").val();
            let userId="";
            if (name!="")
            {
                userId = $("[value='"+name+"']").attr("userId");
            }
            let address=$(".searchAddress").val();
            let marketId="";
            if(address!="")
            {
                marketId = $("[value='"+address+"']").attr("marketId");
            }
            //отправка данных в серверный скрипт (предусмотреть серверную валидацию)
            $.post("scriptsPHP/adminpanel/search.php",{userId:userId,marketId:marketId},function(feedbacks){
                $(".searchContainer").slideToggle(500,function(){
                $(".searchContainer").html(feedbacks);
                $(".searchContainer").slideToggle(500);
                });
            });
        }
    });
});