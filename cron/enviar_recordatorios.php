<?php
// ==========================================
//  CRON PARA ENVIAR RECORDATORIOS DE MEMBRESÍA
//  Ejecutado automáticamente 1 vez al día
// ==========================================

// 1. Cargar conexión
require_once __DIR__ . '/../config/db_connection.php';

// 2. Cargar modelos y PHPMailer
require_once __DIR__ . '/../app/models/MembresiaModel.php';
require_once __DIR__ . '/../libs/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../libs/vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$model = new MembresiaModel($connection);

// 3. Obtener membresías que expiran en 3 días
$membresias = $model->obtenerMembresiasPorVencer(3);

if (empty($membresias)) {
    echo "No hay recordatorios por enviar hoy.\n";
    exit;
}

echo "Enviando correos...\n";

foreach ($membresias as $mem) {
    try {
        $mail = new PHPMailer(true);

        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "misalalobg@gmail.com";   // 🔴 Cambiar
        $mail->Password = "bfwi whis uqwv ibxa";  // 🔴 Cambiar
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Para evitar fallos en localhost
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // DESTINOS
        $mail->setFrom("TU_CORREO@gmail.com", "Sport Zona");
        $mail->addAddress($mem['correo']);

        // CONTENIDO
        $mail->isHTML(true);
        $mail->Subject = "Tu membresía está por expirar";

        $mail->Body = "
            <h2>Hola {$mem['nombre']},</h2>
            <p>Tu membresía está próxima a expirar.</p>
            <p><strong>Fecha de vencimiento:</strong> {$mem['fechaFin']}</p>
            <p>Te recomendamos renovarla para no perder acceso al gimnasio.</p>
            <br><br>
            <p><strong>Sport Zona</strong></p>
        ";

        $mail->send();

        echo "Correo enviado a {$mem['correo']}\n";

    } catch (Exception $e) {
        echo "Error enviando a {$mem['correo']}: {$mail->ErrorInfo}\n";
    }
}

echo "CRON finalizado.\n";
