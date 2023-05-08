<?php
session_start();
$auth = $_SESSION['login'];

if ($auth) {
    $_SESSION = [];
    header('Location: ./');
}
