<?php

?>

    <form action="./Controller/handleUser/handlelogin.php" class="login-box" method="POST">
            <input class="input-box" name="email" type="email"  placeholder="Correo-Ucab">
            <input class="input-box" name="password" type="password" placeholder="Contraseña">
            <input type="submit" name="login" class="login-btn" value="Ingresar"> 
            <div class="con">
    <?php 
    
    if(isset($_SESSION['errors'])) {
          foreach ($_SESSION['errors'] as $error) {
          echo ' <li class="error-li">
          <div class="span-fp-error">'.$error.'</div>
          </li>';
          
          }
          unset($_SESSION['errors']);  

         
          
    } 
        
      ?>
    </div>
    </form>

    
 
	
	