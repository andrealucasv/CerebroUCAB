<?php 

  
    include '../../Model/Classes/init.php' ;
    
    if (isset($_SESSION['user_id'])) {
      header('location: home.php');
    }
   
?>

<html>
	<head>
		<title>Cerebro UCAB</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
        
        <link rel="stylesheet" href="View/Css/index_style.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="View/Css/bootstrap.min.css">
        <link rel="stylesheet" href="View/Css/all.min.css">

		<link rel="shortcut icon" type="image/png" href="../iconos/cerebro.png"> 
	</head>
<body>
<main class="twt-main">
            <section class="twt-login">
                <?php include '../includes/login.php';  ?>
                    <div class="slow-login">
                        <img class="login-bird" src="<?php echo BASE_URL . "/View/iconos/cerebroLogin.png"; ?>" alt="bird">
                        <button class="login-small-display signin-btn pri-btn">Log in</button>
                        <span class="front-para">Pregunta y aclara tus dudas</span>
                        <span class="join">¡Únete a Cerebro UCAB!</span>
                        <button type="button" id="auto" onclick="" class="signup-btn pri-btn" data-toggle="modal" data-target="#exampleModalCenter">
                            Registrate</button>
                            
                             
                            <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="font-weight: 700;" class="modal-title" id="exampleModalLongTitle">Registrate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    
         <?php  include '../includes/signup-form.php' ?>
      </div>
      
    </div>
  </div>
</div>


                    </div>
            </section>
            <section class="twt-features">
                <div class="features-div">
                    <img class="twt-icon" src='https://image.ibb.co/bzvrkp/search_icon.png'>
                    <p>Pregunta sobre las materias.</p>
                    <img class="twt-icon" src="https://image.ibb.co/mZPTWU/heart_icon.png">
                    <p>Ayuda a los demás</p>
                    <img class="twt-icon" src="https://image.ibb.co/kw2Ad9/conv_icon.png">
                    <p>Conversa en los foros.</p>
                </div>
            </section>
            <footer>
                
            </footer>
        </main>
        
        <script src="View/js/jquery-3.4.1.slim.min.js"></script>
        <script src="View/js/popper.min.js"></script>
        <script src="View/js/bootstrap.min.js"></script>
        <script src="View/js/mine.js"></script>
</body>
</html>
