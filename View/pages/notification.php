<?php  
        include '../../Model/Classes/init.php' ;

        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);

        User::updateNotifications($user_id);
  
        $notify_count = User::CountNotification($user_id);
        $notofication = User::notification($user_id);
            if (User::checkLogIn() === false) 
            header('location: index.php');    

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones | Cerebro UCAB</title>
    <link rel="stylesheet" href="View/Css/bootstrap.min.css">
    <link rel="stylesheet" href="View/Css/all.min.css">
    <link rel="stylesheet" href="View/Css/profile_style.css?v=<?php echo time(); ?>">
  
    <link rel="shortcut icon" type="image/png" href="View/iconos/cerebro.png">  
   
</head>
<body>

<script src="assets/js/jquery-3.5.1.min.js"></script>

   
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
          <div class="grid-sidebar" >
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
              <a class="wrapper-left-active" href="notification.php" style="margin-top: 4px"><strong>Notificaciones</strong></a>
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
              <a href="<?php echo BASE_URL . "account.php"; ?>" style="margin-top: 4px"><strong>Configuración</strong></a>
            </div>
           
            
          </div>
          </a>
          <a href="View/includes/logout.php">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align">
            <i style="font-size: 26px;" class="fas fa-sign-out-alt"></i>
            </div>
  
            <div class="wrapper-left-elements">
              <a href="View/includes/logout.php" style="margin-top: 4px"><strong>Cerrar Sesión</strong></a>
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
                 <div style="border-bottom: 1px solid #F5F8FA;"  class="row position-fixed box-name">
                       <div class="col-xs-2">
                       <a href="javascript: history.go(-1);"> <i style="font-size:20px; color:#007934;" class="fas fa-arrow-left arrow-style"></i> </a>
                       </div>
                       <div class="col-xs-10">
                           <p style="margin-top: 12px;" class="home-name"> </p>
                      </div>
                 </div>

                 </div> 
                 <div class="container mt-5">

                     <?php foreach($notofication as $notify) { 
                         $user = User::getData($notify->notify_from);
                         $timeAgo = Question::getTimeAgo($notify->time);
                         ?>
                     <?php if ($notify->type == 'like') { 
                        $icon = "<i style='color: gold; font-size: 30px;' class='fa-star fas ml-2'></i>";
                        $msg = "Punteo tu respuesta.";                        
                        } else if ($notify->type == 'comment') { 
                            $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Respondio a tu pregunta";
                        } else if ($notify->type == 'reply') { 
                            $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Respondio a tu respuesta";
                        }?>
                      
                     <div style="position: relative; border-bottom:4px solid #F5F8FA;" class="box-tweet py-3 ">
                        <a href="
                        <?php if ($notify->type == 'follow'){ 
                            echo $user->username;
                        } else { ?>
                            status/<?php echo $notify->target; ?>
                        <?php } ?>  ">
                        <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                        </a>
                            <div class="grid-tweet">
                                <div class="icon mt-2">
                                    <?php echo $icon; ?>
                                </div>
                                <div class="notify-user">
                                    <p>
                                    <a style="position: relative; z-index:1000;" href="<?php echo $user->username;  ?>">
                                        <img class="img-user" src="Public/users/<?php echo $user->img ?>" alt="">
                                    </a> 
                                    
                                    </p>
                                    <p> <a style="font-weight: 700;
                                    font-size:18px;
                                    position: relative; z-index:1000;" href="<?php echo $user->username; ?>">
                                    <?php echo $user->name; ?> </a> <?php echo $msg; ?> 
                                    <span style="font-weight: 500;" class="ml-3">
                                      <?php echo $timeAgo; ?>
                                    </span> 
                                  </p>
                                </div>
                            </div>
                        </div> 
                     <?php  } ?> 
                 </div>
                
               
        
        </div>
        </div> 


      
           <script src="assets/js/search.js"></script>
            <script src="assets/js/photo.js"></script>
            <script src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
            <script src="assets/js/users.js?v=<?php echo time(); ?>"></script>
            <script type="text/javascript" src="assets/js/hashtag.js"></script>
          <script type="text/javascript" src="assets/js/like.js"></script>
          <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <script src="assets/js/jquery-3.5.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>

<style>

  .container {
    padding-left: 55px;
  }

</style>

</html>