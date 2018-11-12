<?php

require_once './vendor/autoload.php';

use Endroid\QrCode\QrCode;

$qrCode = new QrCode($_GET['email']);
// $qrCode = new QrCode("ghari.cs@gmail.com");
$qrCode->setLogoPath(__DIR__ . '/eventfavicon.png');
$qrCode->setLogoWidth(100);
header('Content-Type:'.$qrCode->getContentType());
echo $qrCode->writeString();

?>


