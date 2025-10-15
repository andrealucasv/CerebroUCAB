<?php
namespace validation;
require_once 'ValidInterface.php';


class Email implements ValidInterface {
    private $db;
    private $name;
    private $value;

    public function __construct($name , $value) {
         $this->name = $name;
         $this->value = $value;
    }

    public function validate() {
        // Validación utilizando filter_var para verificar el formato del correo electrónico
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return "Este correo no es válido.";
        }

        // Validación adicional para verificar si el correo electrónico termina con "@est.uca.edu.ve"
        if (!endsWith($this->value, '@est.ucab.edu.ve')) {
            return "Debe ingresar un correo UCAB (@est.uca.edu.ve)";
        }

        return ''; // Si pasa ambas validaciones, el correo electrónico es válido
    }

    public function verificaCorreo($correo) {
        $partes = explode('@', $correo);
        $dominio = end($partes);
        $dominioEsperado = "est.ucab.edu.ve";
        if (strcasecmp($dominio, $dominioEsperado) === 0) {
            return true; // El correo es válido
        } else {
            return false; // El correo no es válido
        }
    }

    public function guardarCodigo($numeroAleatorio,$correo){
        $this->db->query('INSERT INTO verificacion (correo,codigo) VALUES (:correo,:codigo)');
        $this->db->bind(':correo' , $correo);
        $this->db->bind(':codigo' , $numeroAleatorio);
        if($this->db->execute()){
            echo 'bien';
            return true;
        }else{
            echo 'mori';
            return false;
        }
    }

    public function enviarCorreo($correo,$int){
        $to = $correo;
        $numeroAleatorio = mt_rand(1000, 9999);
        $subject = "Código de verificación de CEREBRO UCAB";
        if($int==0){
            $message = "Tu código de verificación es: " . $numeroAleatorio;    
        }else{
            $message = "Tu código de verificación es: " . $int;    
        }
        $headers = 'From: postmaster@localhost.com\r\n'; 
        if(mail($to, $subject, $message, $headers)){
            //si se envio
        }else{
                //no se envio
        }
        return $numeroAleatorio;
    }

    public function validarCodigo($correo,$codigo){
        $this->db->query('SELECT correo FROM verificacion WHERE correo = :correo AND codigo = :codigo');
        $this->db->bind(':correo', $correo);
        $this->db->bind(':codigo', $codigo);
        if($this->db->rowCount()){
            return true;
        }else{
            return false;
        }   
    }

    public function validarCorreoRep($correo){
        $this->db->query('SELECT correo FROM verificacion WHERE correo = :correo');
        $this->db->bind(':correo', $correo);
        if($this->db->rowCount()){
            return false;
        }else{
            return true;
        }   
    }

    public function obtenerCodigo($correo){
        $this->db->query('SELECT codigo FROM verificacion WHERE correo = :correo');
        $this->db->bind(':correo', $correo);
        $result = $this->db->register();
        if ($result) {
            return $result->codigo;
        } else {
            return null; 
        }
    }

}

// Función para verificar si una cadena termina con otra cadena
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

// Ejemplo de uso
$email = new Email('Correo', 'usuario@est.ucab.edu.ve');
echo $email->validate(); // Esto debería imprimir una cadena vacía, indicando que el correo electrónico es válido
