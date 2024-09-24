<?php

if ($_SERVER['HTTPS']!="on") {
$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
header("Location:$redirect");
}

$headers = getallheaders();
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];

header('Content-Type: text/plain');

include_once 'snippet/securitytxt.php';
include_once 'sign/sign.php';

echo $securitytxt;

?>
