<?php  
   
    if (isset($_GET['username']) === true && empty($_GET['username']) === false ) {
        include '../../Model/Classes/init.php' ;
        $username = User::checkInput($_GET['username']);
        $profileId = User::getIdByUsername($username);
        $profileData = User::getData($profileId);
        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);
        $tweets = Question::tweetsUser($profileData->id);
        $liked_tweets = Question::likedTweets($profileData->id);
        $media_tweets = Question::mediaTweets($profileData->id);
        $notify_count = User::CountNotification($user_id);
      
        if (!$profileData)
            header('location: index.php');

            if (User::checkLogIn() === false) 
            header('location: index.php');    

    }
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $profileData->name; ?> (@<?php echo $profileData->username; ?>) | Cerebro UCAB</title>
    <link rel="stylesheet" href="View/css/bootstrap.min.css">
    <link rel="stylesheet" href="View/css/all.min.css">
    <link rel="stylesheet" href="View/css/profile_style.css?v=<?php echo time(); ?>">
  
    <link rel="shortcut icon" type="image/png" href="View/iconos/cerebro.png">  
   
</head>
<body>

<script src="View/js/jquery-3.5.1.min.js"></script>

   
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
              
              <a class="wrapper-left-active" href="<?php echo BASE_URL . $user->username; ?>"  style="margin-top: 4px"><strong>Perfil</strong></a>
            
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
                 <div   class="row position-fixed box-name">
                       <div class="col-xs-2">
                       <a href="javascript: history.go(-1);"> <i style="font-size:20px; color:#007934;" class="fas fa-arrow-left arrow-style"></i> </a>
                       </div>
                       <div class="col-xs-10">
                           <span class="home-name"> <?php echo $profileData->name; ?></span>
                           <p class="home-tweets-num">
                              <?php echo Question::countTweets($profileData->id); ?> </p>
                      </div>
                 </div>
                  
                 <div class="row mt-5">
                     
                    <div class="col-md-12">
                      <img class="w-100 home-img-cover" src="Public/users/<?php echo $profileData->imgCover; ?>" alt="">
                    </div>

                 </div>

                 <div class="row justify-content-between">
                      <img class="home-img-user" src="Public/users/<?php echo $profileData->img; ?>" alt="">
   

                      <?php if ($user->id == $profileData->id) { ?>
                      <button class="home-edit-button" data-toggle="modal" data-target="#edit">Editar Perfil</button>
                 
                    <!-- Modal Editar Perfil -->
                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">

                        <form method="POST" action="Controller/handleProfile/handleUpdateData.php" enctype="multipart/form-data">

                            <div style="width: 240%;" class="d-flex justify-content-between">
                            <div>
                            <h5 class="modal-title d-inline" id="exampleModalLongTitle">Editar Perfil</h5>
                            </div>
                            <div>

                            <button type="submit" name="update" class="btn-save">Guardar</button>
                            </div>
                                
                         </div>
                            
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-12">
                            <div class="image-upload">
                                <label for="cover-input">
                                <i style="top: 80px;
                                 left:200px;
                                 color:white;
                                 font-size:18px " class="far fa-images position-absolute"></i> 
                                  </label>
                                  <input id="cover-input" type="file" name="cover"/>
                                  <a href="Controller/handleProfile/handleDeleteCover.php" style="top: 80px;
                                 left:260px;
                                 color:red;
                                 font-size:18px " class="fas fa-times position-absolute"></a> 
                               
                                  <img id="preview-cover" class="w-100 home-img-cover" src="Public/users/<?php echo $profileData->imgCover; ?>" alt="">
                            </div>
                            </div>
                          
                            <div class="image-upload">
                            
                            <label for="file-input">
                                <i style="top: 240px;
                                 left:100px;
                                 color:white;
                                 font-size:18px;
                                 z-index:20 " class="far fa-images position-absolute"></i> 
                                  </label>
                                <input id="file-input" name="image" type="file"/>
                            </div>


                            <img id="preview-user" class="home-img-user" src="Public/users/<?php echo $profileData->img; ?>" alt="">

                            </div>
                            <?php  if (isset($_SESSION['errors'] )) { ?>
                            <script>  
                                $(document).ready(function(){
                            $("#edit").modal('show');
                    
                          });
                          </script>
                                    <?php foreach ($_SESSION['errors'] as $error) { ?>
                                          <div  class="alert alert-danger" role="alert">
                                            <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </div>  <?php }  }
                                            unset($_SESSION['errors']) ?> </p>  


                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="<?php echo $user->name; ?>" aria-describedby="emailHelp" placeholder="Nombre/Apodo">
                            </div>
                            <div class="form-group">
                            <input type="text" name="bio" class="form-control" id="exampleInputEmail1" value="<?php if ($user->bio !== null) 
                            echo $user->bio ;?>" aria-describedby="emailHelp" placeholder="Descripción">
                            </div>
                        <div class="form-group">
                        
                            <input type="text" name="website" class="form-control" id="exampleInputEmail1" value="<?php if ($user->website !== null) 
                            echo $user->website ;?>" aria-describedby="emailHelp" placeholder="Instagram">
                        
                        </div>
                        <div class="form-group">
                            
                            <input type="text" name="location" class="form-control" value="<?php if ($user->location !== null) 
                            echo $user->location ;?>" id="exampleInputPassword1" placeholder="Ubicación">
                        </div>
                        <div class="text-center">
                        </div>
                            </form>
                        </div>
                        
                        </div>
                    </div>
                    </div> 

                    <?php } 
                      ?> 


                 </div>
                  <div class="home-title">
                    <h4><?php echo $profileData->name; ?></h4>
                    <p class="user-handle" style="color: gray;">@<?php echo $profileData->username; ?>
                    
                    <p class="bio"><?php echo $profileData->bio; ?> </p>
                  </div>

                  <div class="row home-loc-link ml-2">
                      <?php if (!empty($profileData->location)) { ?>
                    <div class="col-md-4">
                      <li class=""> <i class="fas fa-map-marker-alt"></i> <?php echo $profileData->location; ?></li>
                    </div>
                    <?php } ?>
                    <?php if (!empty($profileData->website)) { ?>
                    <div class="col-md-4">
                    <li><p>Ig:
                    <?php echo $profileData->website?></P></li>
                    </div>
                    <?php } ?>


                  </div>
                  <div class="row home-follow ml-2 mt-1">
                      <div class="col-md-3">
                          
                      
                      </div>
                      <div class="col-md-3">
                      
                      </div>   
                  </div>
                  
                  <div class="popupUsers">
                    
                  </div>

                     <ul class="nav nav-tabs justify-content-center mt-4" id="myTab" role="tablist">
                       <li class="nav-item">
                         <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                           Preguntas</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                           Imágenes</a>
                       </li>
                     </ul>
                 
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <?php include '../includes/questions.php'; ?>
                        
                  </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php
                       $tweets = $media_tweets;
                       include '../includes/questions.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                     
                       <?php
                       $tweets = $liked_tweets;
                       include '../includes/questions.php'; ?>
                  
                  </div>
                  </div>
            
               </div>
         
          </div>
        </div>
        <div class="wrapper-right">
            <div style="width: 90%;" class="container">

            <div class="input-group py-2 m-auto pr-5 position-relative">


            </div>
            </div>
            </div>



           
  
        </div>
      </div> </div>


      
           <script src="View/js/search.js"></script>
            <script src="View/js/photo.js"></script>
            <script src="View/js/follow.js?v=<?php echo time(); ?>"></script>
            <script src="View/js/users.js?v=<?php echo time(); ?>"></script>
            <script type="text/javascript" src="View/js/hashtag.js"></script>
          <script type="text/javascript" src="View/js/like.js"></script>
          <script type="text/javascript" src="View/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="View/js/retweet.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <script src="View/js/jquery-3.5.1.min.js"></script>
        <script src="View/js/popper.min.js"></script>
        <script src="View/js/bootstrap.min.js"></script>
</body>

<style>

  .container {
    padding-left: 55px;
  }

</style>
</html>