<?php

  include '../../Model/Classes/init.php' ;
  
   $user_id = $_SESSION['user_id'];

   $user = User::getData($user_id);
   
   if (User::checkLogIn() === false) 
   header('location: index.php');
   $category = isset($_POST['category']) ? $_POST['category'] : 'todas';
   $tweets = Question::tweets($category);
   

   $notify_count = User::CountNotification($user_id);
 
?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Cerebro UCAB</title>
    
    <link rel="shortcut icon" type="image/png" href="View/iconos/cerebro.png"> 
    <link rel="stylesheet" href="View/Css/bootstrap.min.css">
        <link rel="stylesheet" href="View/Css/all.min.css">
        <link rel="stylesheet" href="View/Css/home_style.css?v=<?php echo time(); ?>">
    
   
</head>
<body>
 
  <script src="View/js/jquery-3.5.1.min.js"></script>
     
    <?php  if (isset($_SESSION['welcome'])) { ?>
      <script>
       $(document).ready(function(){

        $("#welcome").modal('show');
      
 
       });
      </script>
    
<div class="modal fade" id="welcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div  class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="">
        <div class="text-center">
         <span  class="modal-title font-weight-bold text-center" id="exampleModalLongTitle">
          <span style="font-size: 20px;">Bienvenido <span style="color:#007934"><?php echo $user->name; ?></span>  </span>  
         </span>
        </div>

      </div>
      <div class="modal-body">
        <div class="text-center">
       
        <h4 style="font-weight: 600; " >¡Has sido registrado con éxito!</h4>
 
        </div>
        <p>Ya puedes interactuar con las funciones de nuestra página. Si tienes alguna duda pudes publicarla para que así otros 
          usuarios puedan ayudarte. Revisa las preguntas publicadas quizás sean de tu interés o puedas ayudar a alguien.
        </p>
      </div>
      
    </div>
  </div>
</div>

      <?php unset($_SESSION['welcome']); } ?>

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
              <a class="wrapper-left-active" href="home.php" style="margin-top: 4px;"><strong>Inicio</strong></a>
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
              <div class="input-group-login" id="whathappen">
                
                <div class="container">
                  <div class="part-1">
                    <div class="header">
                      <div class="home">
                        <h2>Inicio</h2>
                      </div>

                    </div>
            
                    <div class="text">
                      <form class="" action="./Controller/handleForum/handleQuestion.php" method="post" enctype="multipart/form-data">
                      <div class="categoria">
                          <label class="labelCategoria" style="margin-left: 20px;">Categoría de pregunta: </label>
                          <select id="category" name="category">
                            <option value="Académico">Académico</option>
                            <option value="Social">Social</option>
                          </select>      
                          </div>
                      <div class="inner">
            
                            <img src="Public/users/<?php echo $user->img ?>" alt="profile photo">
                        
                          <label>
            
                            <textarea class="text-whathappen" name="status" rows="8" cols="80" placeholder="¿Qué duda tienes?"></textarea>
                        
                        </label>
                        </div> 

                        <div class="position-relative upload-photo"> 
                          <img class="img-upload-tmp" src="Public/questions/tweet-60666d6b426a1.jpg" alt="">
                          <div class="icon-bg">
                          <i id="#upload-delete-tmp" class="fas fa-times position-absolute upload-delete"></i>  

                          </div>
                        </div>


                        <div class="bottom"> 
                          
                          <div class="bottom-container">
                              
                            
                              
                           
                            <label for="tweet_img" class="ml-3 mb-2 uni">

                              <i class="fa fa-image item1-pair"></i>
                            </label>
                            <input class="tweet_img" id="tweet_img" type="file" name="tweet_img">    
                                
                          </div>
                          <div class="hash-box">
                        
                              <ul style="margin-bottom: 0;">


                              </ul>
                          
                          </div>
                          <?php if (isset($_SESSION['errors_tweet'])) { 
                            
                            foreach($_SESSION['errors_tweet'] as $t) {?>
                            
                          <div class="alert alert-danger">
                          <span class="item2-pair"> <?php echo $t; ?> </span>
                          </div>
                         
                         <?php } } unset($_SESSION['errors_tweet']); ?>
                          
                          <div>
                         
                          <span class="bioCount" id="count" style="color: #007934 !important;">140</span>
                            <input id="tweet-input" type="submit" name="tweet" value="Preguntar" class="submit"
                            >
                          </div>
                      </div>
                      </form>
                    </div>
                  </div>
                  <div class="part-2">
            
                  </div>
            
                </div>
                
                
              </div>
            </div>
          </div>
          <div class="box-fixed" id="box-fixed"></div>
            
          <?php  include '../includes/questions.php'; ?>

        </div>


        <div class="wrapper-right">
            <div style="width: 90%;" class="container">

          <div class="input-group py-2 m-auto pr-5 position-relative">
          
          </div>
          </div>


       

            
          <div class="box-share">
            <?php 
              if($category=="todas"){
                $mostrar = "Todas";
              }else{
                $mostrar = $category;
              }
            ?>
            <p class="txt-Category"><strong>Categoría Actual:</strong> </p>    
            <p class="txt-Category2"><?php echo $mostrar; ?></p>                          
            <p class="txt-share"><strong>Decide que ver:</strong></p>
            <form method="POST" action="home.php">
              <input type="hidden" name="category" value="todas">
              <button type="submit" class="btn-contenido">Todo</button>
            </form>
            <form method="POST" action="home.php">
              <input type="hidden" name="category" value="Social">
              <button type="submit" class="btn-contenido">Social</button>
            </form>
            <form method="POST" action="home.php">
              <input type="hidden" name="category" value="Académico">
              <button type="submit" class="btn-contenido">Académico</button>
            </form>
          </div>

  
  
        </div>
      </div>
      </div> 
      <script src="View/js/search.js"></script>
          <script src="View/js/photo.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="View/js/hashtag.js"></script>
          <script type="text/javascript" src="View/js/like.js"></script>
          <script type="text/javascript" src="View/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="View/js/retweet.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="View/js/follow.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <script src="View/js/jquery-3.5.1.min.js"></script>

        <script src="View/js/popper.min.js"></script>
        <script src="View/js/bootstrap.min.js"></script>
        <script>
          $(function () {
  var regex = /[#|@](\w+)$/ig;

  $(document).on('keyup', '.text-whathappen', function () {
    var content = $.trim($(this).val());
    var text = content.match(regex);
    var max = 140;

    if (text != null) {
      var dataString = 'hashtag=' + text;

      $.ajax({
        type: "POST",
        url: "core/ajax/getHashtag.php",
        data: dataString,
        cache: false,
        success: function (data) {
          $('.hash-box ul').html(data);
          $('.hash-box li').click(function () {
            var value = $.trim($(this).find('.getValue').text());
            var oldContent = $('.text-whathappen').val();
            var newContent = oldContent.replace(regex, "");

            $('.text-whathappen').val(newContent + value + ' ');
            $('.hash-box li').hide();
            $('.text-whathappen').focus();

            $('#count').text(max - content.length);
          })
        }
      })


    } else {
      $('.hash-box li').hide();
    }

    $('#count').text(max - content.length);

    if (content.length >= max) {
      $('#count').css('color', '#f00');

    } else {
      $('#count').css('color', '#007934');
    }
  });
});


        </script>
</body>
</html> 