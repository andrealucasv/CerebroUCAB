<?php 

include '../../Model/Classes/init.php' ;
  
$user_id = $_SESSION['user_id'];

$user = User::getData($user_id);
$notify_count = User::CountNotification($user_id);

if (User::checkLogIn() === false) 
header('location: index.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración | Cerebro UCAB</title>
    <link rel="stylesheet" href="View/Css/bootstrap.min.css">
    <link rel="stylesheet" href="View/Css/all.min.css">

    <link rel="stylesheet" href="View/Css/profile_style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="View/iconos/cerebro.png">  
   
</head>
<body>
     


    <div id="mine">
    <div class="wrapper-left">
        <div class="sidebar-left">
          <div class="grid-sidebar" style="margin-top: 12px">
            <div class="icon-sidebar-align">
              <img src="<?php echo BASE_URL . "/View/iconos/cerebro.png"; ?>" alt="" height="60px" width="60px" />
            </div>
          </div>

          <a href="home.php">
          <div class="grid-sidebar bg-active" style="margin-top: 12px">
            <div class="icon-sidebar-align">
              <img src="<?php echo BASE_URL . "/View/iconos/home.png"; ?>" alt="" height="26.25px" width="26.25px" />
            </div>
            <div class="wrapper-left-elements">
              <a href="home.php" style="margin-top: 4px;"><strong>Inicio</strong></a>
            </div>
          </div>
          </a>
  
          <a href="notification.php">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align position-relative">
                <?php if ($notify_count > 0) { ?>
              <i class="notify-count"><?php echo $notify_count; ?></i> 
              <?php } ?>
              <img
                src="<?php echo BASE_URL . "/View/iconos/notif.png"; ?>"
                alt=""
                height="26.25px"
                width="26.25px"
              />
            </div>
  
            <div class="wrapper-left-elements">
              <a href="notification.php" style="margin-top: 4px"><strong>Notificaciones</strong></a>
            </div>
          </div>
          </a>
        
            <a href="<?php echo BASE_URL . $user->username; ?>">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align">
              <img src="<?php echo BASE_URL . "/View/iconos/prof.png"; ?>" alt="" height="26.25px" width="26.25px" />
            </div>
  
            <div class="wrapper-left-elements">
              
              <a  href="<?php echo BASE_URL . $user->username; ?>"  style="margin-top: 4px"><strong>Perfil</strong></a>
            
            </div>
          </div>
          </a>
          <a href="<?php echo BASE_URL . "account.php"; ?>">
          <div class="grid-sidebar ">
            <div class="icon-sidebar-align">
              <img src="<?php echo BASE_URL . "/View/iconos/setting.png"; ?>" alt="" height="26.25px" width="26.25px" />
            </div>
  
            <div class="wrapper-left-elements">
              <a class="wrapper-left-active" href="<?php echo BASE_URL . "account.php"; ?>" style="margin-top: 4px"><strong>Configuración</strong></a>
            </div>
           
            
          </div>
          </a>
          <a href="View/includes/logout.php">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align">
            <i style="font-size: 26px;" class="fas fa-sign-out-alt"></i>
            </div>
  
            <div class="wrapper-left-elements">
              <a  href="View/includes/logout.php" style="margin-top: 4px"><strong>Cerrar Sesión</strong></a>
            </div>
          </div>
          </a>
          
  
          <div class="box-user">
            <div class="grid-user">
              <div>
                <img
                  src="Public/users/<?php echo $user->img ?>"
                  alt="user"
                  class="img-user"
                />
              </div>
              <div>
                <p class="name"><strong><?php if($user->name !== null) {
                echo $user->name; } ?></strong></p>
                <p class="username">@<?php echo $user->username; ?></p>
              </div>
              <div class="mt-arrow">
                <img
                  src="https://i.ibb.co/mRLLwdW/arrow-down.png"
                  alt=""
                  height="18.75px"
                  width="18.75px"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
          
  

      <div class="grid-posts">
        <div class="border-right">
          <div class="grid-toolbar-center">
            <div class="center-input-search">
              
            </div>
           
          </div>

          <div class="box-fixed" id="box-fixed"></div>
  
          <div class="box-home feed">
               <div class="container">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <p style="color:white !important; background-color: #007934 !important; border: 2px solid #007934 !important;" class="nav-link active text-center" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true" >Cambiar Contraseña</p>
        
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        <form method="POST" action="Controller/handleProfile/handleChangePassword.php" class="py-4" >
                    <script src="View/js/jquery-3.5.1.min.js"></script>
                    <?php  if (isset($_SESSION['errors_password'] )) {
                        
                        ?>
                        

                         <script>  
                                $(document).ready(function(){
                            $("#v-pills-profile-tab").click();
                    
                          });
                          </script>

                        <?php foreach ($_SESSION['errors_password'] as $error) { ?>

                            <div  class="alert alert-danger" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>  
                            </div> 
                                    <?php }   ?> 

                        <?php }  unset($_SESSION['errors_password'])  ?>

                        <?php  if (isset($_SESSION['PasswordChange'] )) {
                        
                        ?>
                        

                         <script>  
                                $(document).ready(function(){
                            $("#v-pills-profile-tab").click();
                    
                          });
                          </script>

                        <?php foreach ($_SESSION['PasswordChange'] as $error) { ?>

                            <div  class="alert alert-success" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>  
                            </div> 
                                    <?php }   ?> 

                        <?php }  unset($_SESSION['PasswordChange'])  ?>


                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese su actual contraseña</label>
                        <input type="password" name="old_password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Contraseña actual">
                    
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Ingrese una nueva contraseña</label>
                        <input type="password" name="new_password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña nueva">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">Ingrese nuevamente la nueva contraseña</label>
                        <input type="password" name="ver_password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña nueva">
                      </div>
                      
                      <div class="text-center">

                        <button style="background-color: #007934; border: 2px solid #007934;" type="submit" name="submit" class="btn btn-primary">Guardar Cambios</button>
                      </div>

                    </form>

                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                  </div>
     
                </div>
                   
               </div>
           
          </div>
        </div>
        <div> 
            
        <div style="width: 90%;" class="container">

        
       </div>


  
        </div>
      </div> </div>
      <script src="View/js/search.js"></script>    
       <script src="View/js/follow.js"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
        <script src="View/js/popper.min.js"></script>
        <script src="View/js/bootstrap.min.js"></script>
</body>

<style>

  .container {
    padding-left: 55px;
  }

</style>

</html>