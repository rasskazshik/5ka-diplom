<?php 
session_start();
require_once 'scriptsPHP/userAuth/getUserInfo.php';
?>
<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset="utf-8" />
    <title>Пятерочка - оценка качества работы отделений</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" media="screen" href="styles/bootstrap.min.css" />
    <link defer rel="stylesheet" type="text/css" media="screen" href="styles/main.css" />
    <!--фреймворк jQuery-->
    <script defer src="scriptsJS/jquery-3.3.1.min.js"></script>
    <!--плагин jQuery для работы с куки-->
    <script defer src="scriptsJS/jquery.cookie.js"></script>
    <!--плагин для всплывающих подсказок (нужен для Bootstrap4)-->
    <script defer src="scriptsJS/popper.min.js"></script>
    <!--Bootstrap4)-->
    <script defer src="scriptsJS/bootstrap.min.js"></script>
    <!--собственные скрипты-->
    <script defer src="scriptsJS/main.js"></script>
    <!--скрипт виджета авторизации через соц-сети-->
    <script defer src="//ulogin.ru/js/ulogin.js"></script>
    <!--ссылка на API Яндекс.Карт-->
    <script defer src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<f8c2ff84-329d-4ed4-8280-a2b03eeca1fb>" type="text/javascript"></script>
    <!--программирование Яндекс.Карт-->
    <script defer src="scriptsJS/mapPref.js" type="text/javascript"></script>
</head>
<body>
    <div class="container bodyContainer">
        <div class="headerRow row no-gutters">
            <div class="col-md-3 headerCol">  
                <img class="logo col-md align-self-center" src="images\pyaterochka.jpg">          
            </div>
            <div class="col-md-3 headerCol">  
                <div class="subName">Оценка качества работы торговых точек</div>          
            </div>
            <div class="col-md-3 headerCol">  
                <div>
                    <div class="contactsInfo">
                        <a href="tel:8-800-555-55-05">8-800-555-55-05</a>
                    </div>
                    <div class="contactsInfoSubtext">Горячая линия</div>
                </div>
            </div>
            <div class="col-md-3 headerCol">    
            <!--встраиваем авторизацию через соц.сети-->
<?php
if(isset($_SESSION['user-info']))
{
    $lastname=$_SESSION['user-info']['last_name'];
    $firstname=$_SESSION['user-info']['first_name'];
    $profile=$_SESSION['user-info']['profile'];
    $photo=$_SESSION['user-info']['photo'];
print<<<EOF
<div class="nav-link auth container logout"><img class='purposeImage' src='$photo'>$lastname $firstname (выйти)</div> 
EOF;
}
else
{
    $domen=$_SERVER['HTTP_HOST'];
print<<<EOF
<div class="nav-link auth container">Авторизация<div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name,photo,profile;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=twitter,google,yandex,googleplus,instagram;redirect_uri=http%3A%2F%2F$domen;mobilebuttons=0;"></div></div>
EOF;
}
?>                   
            </div>
        </div>
        <!--навигация-->
        <div class="row navigation no-gutters">
            <a class="container navToPurpose active"><div>Предназначение</div></a>
            <a class="container navToFeedback"><div>Выбор торговой точки</div></a>
            <a class="container navToOtherOrders"><div>Другие предложения</div></a>
        </div>
        <!--контейнер для выгрузки контента-->
        <div class="row no-gutters content contentRow">

        </div>
        <!--футер-->
        <div class="row footer no-gutters">
            <span  class="container" data-toggle="modal" data-target="#adminAuth"><div>Вход для администатора</div></span>
        </div>
    </div>
    
    
        <!-- Модальное окно авторизации администратора -->
    <div class="modal fade" id="adminAuth" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><label for="password">Для перехода требуется ввести пароль</label></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">            
                <input type="password" class="form-control" id="adminPassword" aria-describedby="Введите пароль администратора" placeholder="Введите пароль администратора" name="password"/>
                <div class="invalid-feedback">
                    Введенный пароль не присутствует в базе данных
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary authButton">Вход</button>
          </div>
        </div>
      </div>
    </div>
  
</body>
</html>