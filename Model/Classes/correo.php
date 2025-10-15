<?php

class correo extends Connect {

    public function guardarCodigo($numeroAleatorio, $correo) {
        $stmt = self::connect()->prepare('INSERT INTO `verificacion` (correo,codigo) VALUES (:correo,:codigo)');
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $numeroAleatorio, PDO::PARAM_STR);
        if ($stmt->execute()) {
            echo 'bien';
            return true;
        } else {
            echo 'mori';
            return false;
        }
    }

    public function enviarCorreo($correo, $int) {
        $to = $correo;
        $numeroAleatorio = mt_rand(1000, 9999);
        $subject = "Código de verificación de CEREBRO UCAB";
        if ($int == 0) {
            $message = "Tu código de verificación es: " . $numeroAleatorio;
        } else {
            $message = "Tu código de verificación es: " . $int;
        }
        $headers = 'From: postmaster@localhost.com\r\n';
        if (mail($to, $subject, $message, $headers)) {
            // si se envio
        } else {
            // no se envio
        }
        return $numeroAleatorio;
    }

    public function correoRegistrado($correo) {
        $stmt = self::connect()->prepare("SELECT `correo` from `verificacion` WHERE `correo` = :correo");
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function obtenerCodigo($correo) {
        $stmt = self::connect()->prepare("SELECT codigo FROM verificacion WHERE correo = :correo");
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();
        $codigo = $stmt->fetch(PDO::FETCH_COLUMN);
        return $codigo;
    }

    public function verificarCorreo($correo) {
        $partes = explode('@', $correo);
        $dominio = end($partes);
        $dominioEsperado = "est.ucab.edu.ve";
        if (strcasecmp($dominio, $dominioEsperado) === 0) {
            return true; // El correo es válido
        } else {
            return false; // El correo no es válido
        }
    }

    public static function gestionarCodigo($correo) {
        if (isset($correo)) {
            // Uso de $this para llamar a los métodos de instancia de la misma clase
            $instance = new self();
            if ($instance->verificarCorreo($correo)) {
                if ($instance->correoRegistrado($correo)) {
                    $instance->enviarCorreo($correo, self::obtenerCodigo($correo));
                } else {
                    $cod = $instance->enviarCorreo($correo, 0);
                    $instance->guardarCodigo($cod, $correo);
                }
            return true;
            } else {
                //correo invalido
            }
        }
    }
}
