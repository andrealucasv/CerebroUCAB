<?php 

?>
       <script src="View/js/jquery-3.4.1.slim.min.js"></script>
<form action="./Controller/handleUser/handleSignUp.php" method="post">
<?php  if (isset($_SESSION['errors_signup'] )) { ?>
        <script>  
             $(document).ready(function(){

        $("#exampleModalCenter").modal('show');
 
       });
      </script>
                <?php foreach ($_SESSION['errors_signup'] as $error) { ?>
                       <div  class="alert alert-danger" role="alert">
                        <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </div>  <?php }  }
                        unset($_SESSION['errors_signup']) ?> </p>  
<?php  if (isset($_SESSION['correoEnviado'] )) { ?>
        <script>  
             $(document).ready(function(){
        $("#exampleModalCenter").modal('show');
 
       });
      </script>
                <?php foreach ($_SESSION['correoEnviado'] as $error) { ?>
                       <div  class="alert alert-success" role="alert">
                        <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </div>  <?php }  }
                        unset($_SESSION['correoEnviado']) ?> </p>  
                        <div class="form-group">
                       <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nombre Completo">
                    </div>
                    <div class="form-group">
                      
                       <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Correo UCAB">
                    </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
                  
                </div>
                <div class="form-group">
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Código enviado al correo UCAB">
                </div>
                  <div class="text-center">
                  <button type="submit" name="signup" class="btn btn-primary">Únete</button>
                  <button type="submit" name="enviarCorreo" class="btn btn-secondary">Enviar Código</button>
                  <br><br>
                  <h6>Ten en cuenta que al presionar el botón de "Enviar Código" los datos se reiniciarán solo coloque el correo</h6>
                  </div>
                  
               
</form>