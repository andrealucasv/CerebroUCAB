<?php 
include '../../Model/Classes/init.php';
require_once '../../Model/validation/Validator.php';
require_once '../../Model/Classes/User.php';
require_once '../../Model/validation/Email.php';
require_once '../../Model/Classes/correo.php';
use validation\Validator;

class HandleSignUp {
    public function handleSignUp() {
        if (isset($_POST['signup'])) {
   
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $codigo = $_POST['username'];
            $usuario = new User();
            $username = $usuario->extraerUsuario($email);
        
        
            if(!empty($email) || !empty($password) || !empty($name) || !empty($username))   {
            $email = User::checkInput($email);
            $password = User::checkInput($password); 
            $name = User::checkInput($name); 
        
        
           } 
           
              
        
            $v = new Validator; 
            $v->rules('name' , $name , ['required' , 'string' , 'max:20']);
            $v->rules('username' , $username , ['required' , 'string' , 'max:20']);
            $v->rules('email' , $email , ['required' , 'email']);
            $v->rules('password' , $password , ['required' , 'string' , 'min:5']);
            $errors = $v->errors;
            
            if ($errors == []){
                $username = str_replace(' ', '', $username);
                
                if(User::checkEmail($email) === true) {
                    $_SESSION['errors_signup'] = ['Este correo ya esta registrado.'];
                    header('location: ../../index.php')  ;
                } else if (User::checkUserName($username) === true) {
                    $_SESSION['errors_signup'] = ['Ya existe este usuario.'];
                    header('location: ../../index.php')  ;
                } else if (User::compararCodigo($email,$codigo)) { //aca va la funcion de validar codigo
                    User::register($email , $password ,$name , $username);    
                } else {
                    $_SESSION['errors_signup'] = ['El código no es válido.'];
                    header('location: ../../index.php')  ;
                }
            } else { 
                
                $_SESSION['errors_signup'] = $errors;  
            header('location: ../../index.php'); }
                
        } else {
            if (isset($_POST['enviarCorreo'])) {
                $email = $_POST['email'];
                echo $email;
                if(correo::gestionarCodigo($email)){
                    $_SESSION['correoEnviado'] = ['Correo enviado correctamente.'];
                    header('location: ../../index.php')  ;    
                }else{
                    $_SESSION['errors_signup'] = ['Debes ingresar un correo válido para enviarte el codigo.'];
                    header('location: ../../index.php')  ;
                }
            }else{
                header('location: ../../index.php')  ;
            }
        }
}
}

// Instanciar la clase y llamar al método
$handleSignUp = new HandleSignUp();
$handleSignUp->handleSignUp();
?>
