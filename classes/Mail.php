<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {
    protected $mail;

    public function __construct() {
        // Crear una nueva instancia de PHPMailer
        $this->mail = new PHPMailer();
    }

    public function setData() {
        // Configurar SMTP
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['EMAIL_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['EMAIL_USER'];
        $this->mail->Password = $_ENV['EMAIL_PASS'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $_ENV['EMAIL_PORT'];    
    }

    public function setContent() {
        // Configurar el contenido del email
        $this->mail->setFrom($_POST['email'], $_POST['nombre']);  
        $this->mail->addAddress("admin@admin.com", 'BienesRaices.com');
        $this->mail->Subject = 'Tienes un mensaje nuevo';

        // Habilitar HTML en el email
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';

        // Definir el contenido del email
        $contenido = '<html>'; 
        $contenido .= '<p>Tienes un nuevo mensaje:</p>';
        $contenido .= '<p>Nombre: ' . $_POST['nombre'] . '</p>';

        if($_POST['contacto'] === 'telefono') {
            $contenido .= '<p>Eligió ser contactado por Teléfono</p>';
            $contenido .= '<p>Telefono: ' . $_POST['telefono'] . '</p>';
            $contenido .= '<p>Fecha preferida de contacto: ' . $_POST['fecha'] . '</p>';
            $contenido .= '<p>Hora preferida de contacto: ' . $_POST['hora'] . '</p>';
        } else {
            $contenido .= '<p>Eligió ser contactado por E-mail</p>';
            $contenido .= '<p>Email: ' . $_POST['email'] . '</p>';
        }

        $contenido .= '<p>Mensaje: ' . $_POST['mensaje'] . '</p>';
        $contenido .= '<p>Vende o Compra: ' . $_POST['tipo'] . '</p>';
        $contenido .= '<p>Precio/Presupuesto: $' . $_POST['precio'] . '</p>';
        $contenido .= '</html>';
    
        $this->mail->Body = $contenido;
        $this->mail->AltBody = "Texto alternativo sin HTML";
    }

    // Enviar el email
    public function send() {
        return $this->mail->send();
    }
}