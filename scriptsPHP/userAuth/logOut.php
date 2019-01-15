<?php
session_start();
if(isset($_SESSION['user-info']))
{
    unset($_SESSION['user-info']);
}