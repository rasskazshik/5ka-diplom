<?php
if(isset($_POST['token']))
{
    $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
    $_SESSION['user-info']['first_name']=$user['first_name'];//имя пользователя
    $_SESSION['user-info']['last_name']=$user['last_name'];//фамилия пользователя
    $_SESSION['user-info']['photo']=$user['photo'];//адрес квадратной аватарки (до 100*100)
    $_SESSION['user-info']['profile']=$user['profile'];//адрес профиля пользователя (ссылка на его страницу в соцсети, если удастся ее получить
    unset($_POST['token']);
}