<?php
   include '../../Model/Classes/init.php' ;
  
   $user_id = $_SESSION['user_id'];
  
   $user = User::getData($user_id);
   
   if (User::checkLogIn() === false) 
   header('location: index.php');


   $tweet_id =  $_GET['post_id'];
   $tweet = Question::getData($tweet_id);
   $notify_count = User::CountNotification($user_id);
 
    
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta | Cerebro UCAB</title>
    <base href="<?php echo BASE_URL; ?>">
    <link rel="shortcut icon" type="image/png" href="View/iconos/cerebro.png"> 
    <link rel="stylesheet" href="View/Css/bootstrap.min.css">
    <link rel="stylesheet" href="View/Css/all.min.css">
    <link rel="stylesheet" href="View/Css/home_style.css?v=<?php echo time(); ?>">
    
   
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
              
                
                <div class="container" style="border-bottom: 1px solid #E9ECEF;">
                 
                  <div class="row">
                       <div class="col-xs-1">
                      
                 <a href="javascript: history.go(-1);"> <i style="font-size:20px; color:#007934;" class="fas fa-arrow-left arrow-style"></i> </a>
                       </div>
                       <div class="col-xs-10 mt-1">
                           <p class="tweet-name" style="
                           font-weight:700"> </p>
                          
                      </div>
               

            
                    
                  </div>
                  <div class="part-2">
            
                  </div>
            
                </div>
                
                
             
            </div>
          </div> 
          
          <div class="box-fixed" id="box-fixed"></div>
          
          <?php 

                $retweet_sign = false;
                $retweet_comment =false;
                $qoq = false;

            if (Question::isTweet($tweet->id)) {

              $tweet_user = User::getData($tweet->user_id) ;
              $tweet_real = Question::getTweet($tweet->id);
              $timeAgo = Question::getTimeAgo($tweet->post_on) ; 
              $likes_count = Question::countLikes($tweet->id) ;
              $user_like_it = Question::userLikeIt($user_id ,$tweet->id);
              $retweets_count = Question::countRetweets($tweet->id) ;
              $user_retweeted_it = Question::userRetweeetedIt($user_id ,$tweet->id);

            } else if (Question::isRetweet($tweet->id)) {

              $retweet = Question::getRetweet($tweet->id);

              if ($retweet->retweet_msg == null) {
                
                    if ($retweet->retweet_id == null) {

                    $retweeted_tweet = Question::getTweet($retweet->tweet_id);
                    $tweet_user = User::getData($retweeted_tweet->user_id) ;
                    $tweet_real = Question::getTweet($retweet->tweet_id);
                    $timeAgo = Question::getTimeAgo($tweet_real->post_on) ; 
                    $likes_count = Question::countLikes($retweet->tweet_id) ;
                    $user_like_it = Question::userLikeIt($user_id ,$retweet->tweet_id);
                    $retweets_count = Question::countRetweets($retweet->tweet_id) ;
                    $user_retweeted_it = Question::userRetweeetedIt($user_id ,$retweet->tweet_id); 
                    $retweeted_user = User::getData($tweet->user_id);
                    $retweet_sign = true;
                    } else {

                    $retweeted_tweet = Question::getRetweet($retweet->retweet_id);

                        if($retweeted_tweet->tweet_id != null) {

                        $tweet_user = User::getData($retweeted_tweet->user_id) ;
                        $timeAgo = Question::getTimeAgo($retweeted_tweet->post_on) ; 
                        $likes_count = Question::countLikes($retweeted_tweet->post_id) ;
                        $user_like_it = Question::userLikeIt($user_id ,$retweeted_tweet->post_id);
                        $retweets_count = Question::countRetweets($retweeted_tweet->post_id) ;
                        $user_retweeted_it = Question::userRetweeetedIt($user_id ,$retweeted_tweet->post_id);
                      
                        
                        $tweet_inner = Question::getTweet($retweeted_tweet->tweet_id);
                        $user_inner_tweet = User::getData($tweet_inner->user_id) ;
                        $timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on); 
                        $retweeted_user = User::getData($tweet->user_id);
                        $retweet_sign = true;

                        $qoute = $retweeted_tweet->retweet_msg;
                        $retweet_comment = true;
                        } else {

                        $retweet_sign = true;
                        $tweet_user = User::getData($retweeted_tweet->user_id) ;

                         $timeAgo = Question::getTimeAgo($retweeted_tweet->post_on) ; 
                        $likes_count = Question::countLikes($retweeted_tweet->post_id) ;
                        $user_like_it = Question::userLikeIt($user_id ,$retweeted_tweet->post_id);
                        $retweets_count = Question::countRetweets($retweeted_tweet->post_id) ;
                        $user_retweeted_it = Question::userRetweeetedIt($user_id ,$retweeted_tweet->post_id);
 
                        $qoq = true; 
                        $qoute = $retweeted_tweet->retweet_msg;
                        $tweet_inner = Question::getRetweet($retweeted_tweet->retweet_id);
                        $user_inner_tweet = User::getData($tweet_inner->user_id) ;
                        $timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on);
                        $inner_qoute  = $tweet_inner->retweet_msg;

                        $retweeted_user = User::getData($tweet->user_id);

                        }
                    }

            } else {
              if ($retweet->retweet_id == null) {
              $tweet_user = User::getData($tweet->user_id) ;
              $timeAgo = Question::getTimeAgo($tweet->post_on) ; 
              $likes_count = Question::countLikes($tweet->id) ;
              $user_like_it = Question::userLikeIt($user_id ,$tweet->id);
              $retweets_count = Question::countRetweets($tweet->id) ;
              $user_retweeted_it = Question::userRetweeetedIt($user_id ,$tweet->id);
              $qoute = $retweet->retweet_msg;
              $retweet_comment = true;
          

              $tweet_inner = Question::getTweet($retweet->tweet_id);
              $user_inner_tweet = User::getData($tweet_inner->user_id) ;
              $timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on); 
            } else {

            $tweet_user = User::getData($tweet->user_id) ;
            $timeAgo = Question::getTimeAgo($tweet->post_on) ; 
            $likes_count = Question::countLikes($tweet->id) ;
            $user_like_it = Question::userLikeIt($user_id ,$tweet->id);
            $retweets_count = Question::countRetweets($tweet->id) ;
            $user_retweeted_it = Question::userRetweeetedIt($user_id ,$tweet->id);
            $qoute = $retweet->retweet_msg;
            $qoq = true; 
            
            $tweet_inner = Question::getRetweet($retweet->retweet_id);
            $user_inner_tweet = User::getData($tweet_inner->user_id) ;
            $timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on);
            $inner_qoute = $tweet_inner->retweet_msg;
            if($inner_qoute == null) {
                            
              $tweet_innerr = Question::getRetweet($tweet_inner->retweet_id);
              $inner_qoute = $tweet_innerr->retweet_msg;

            }

            }

            }

            } 
             $tweet_link = $tweet->id;
              if ($retweet_sign)
              $comments = Question::comments($retweeted_tweet->id);
              else  $comments = Question::comments($tweet_id);

            
            if($retweet_sign)
             $comment_count = Question::countComments($retweeted_tweet->id);
             else  $comment_count = Question::countComments($tweet->id); 
                     
            
            ?>
          
              
          <div class="box-tweet feed" style="position: relative;" >
                 <a href="status/<?php echo $tweet->id; ?>">
                    <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                 </a>
            <?php if ($retweet_sign) { ?>
            <span class="retweed-name"> <i class="fa fa-retweet retweet-name-i" aria-hidden="true"></i> 
            <a style="position: relative; z-index:100; color:rgb(102, 117, 130);" href="<?php echo $retweeted_user->name; ?> "> <?php  if($retweeted_user->id == $user_id) echo "You";
        else echo $retweeted_user->name; ?> </a>  retweeted</span>
             <?php } ?>
            <div class="grid-tweet">
                <a style="position: relative; z-index:1000" href="<?php echo $tweet_user->username;  ?>">
                <img
                src="Public/users/<?php echo $tweet_user->img; ?>"
                alt=""
                class="img-user-tweet"
                />
                </a >

                <div>
                <p> 
                <a style="position: relative; z-index:1000; color:black" href="<?php echo $tweet_user->username;  ?>">
                <strong> <?php echo $tweet_user->name ?> </strong> 
                </a>
                  <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo ?></span>
                </p>
                <p>
                  <?php
                  if ($retweet_comment || $qoq)
                  echo  Question::getTweetLinks($qoute);
                  else echo  Question::getTweetLinks($tweet_real->status); ?>
                </p>
                  <?php if ($retweet_comment == false && $qoq == false) { ?>
                <?php if ($tweet_real->img != null) { ?>
                <p class="mt-post-tweet">
                  <img
                    src="Public/questions/<?php echo $tweet_real->img; ?>"
                    alt=""
                    class="img-post-tweet"
                  />
                </p>
               <?php } } else { ?>
                  
                  <div  class="mt-post-tweet comment-post" style="position: relative;">
                 
                    <a href="status/<?php echo $tweet_inner->id; ?>">
                          <span class="" style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 2;"></span>
                       </a>
                  <div class="grid-tweet py-3 "  > 
                 
                  <a style="position: relative; z-index:1000" href="<?php echo $user_inner_tweet->username;  ?>">
                    <img
                    src="Public/users/<?php echo $user_inner_tweet->img; ?>"
                    alt=""
                    class="img-user-tweet"
                    />
                    </a >

                    <div>
                    <p> 
                    <a style="position: relative; z-index:1000; color:black" href="<?php echo $user_inner_tweet->username;  ?>">
                    <strong> <?php echo $user_inner_tweet->name ?> </strong> 
                    </a>
                  <span class="username-twitter">@<?php echo $user_inner_tweet->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo_inner ?></span>
                </p>
                <p>
                  <?php
                    if ($qoq)
                    echo Question::getTweetLinks($inner_qoute);
                    else  echo  Question::getTweetLinks($tweet_inner->status); ?>
                </p>
                <?php   // don't show img if quote of quote
                if ($qoq == false) { 
                if ($tweet_inner->img != null) { ?>
                <p class="mt-post-tweet">
                  <img
                    src="Public/questions/<?php echo $tweet_inner->img; ?>"
                    alt=""
                    class="img-post-retweet"
                  />
                </p>
               <?php } } ?>

              </div> 

            </div>
                         

                </div>
                    

                <?php } ?>

                <div class="row home-follow pt-3">
                       
                        <?php if($retweets_count > 0)  { ?>
                            <div class="col-md-2 users-count" >
                            <i class="retweets-u"
                            data-tweet="<?php 
                            if($retweet_sign)
                                echo $retweeted_tweet->id;
                            else  echo $tweet->id; ?>"> 
                     <span class="home-follow-count"> <?php echo $retweets_count ; ?> </span> Retweets</i>
                        </div> 
                        <?php } ?> 
                        <?php if($likes_count > 0)  { ?>
                        <div class="col-md-2 users-count">
                            <div class="likes-u" 
                            data-tweet="<?php 
                            if($retweet_sign)
                                echo $retweeted_tweet->id;
                            else  echo $tweet->id; ?>">
                             <span class="home-follow-count">  <?php echo $likes_count ; ?>  </span> Likes</div>
                        </div>   
                        <?php } ?> 
                  </div>

                <div class="grid-reactions">
                  <div class="grid-box-reaction">
                    <div class="hover-reaction hover-reaction-comment comment"
                    data-user = "<?php echo $user_id; ?>" 
                    data-tweet = "<?php 
                    if($retweet_sign)
                       echo $retweeted_tweet->id;
                   else  echo $tweet->id; ?>">
                     
                      <i class="far fa-comment"></i>
                      <div class="mt-counter likes-count d-inline-block">
                        <p> <?php if($comment_count > 0) echo $comment_count; ?> </p>
                      </div>
                    </div>
                  </div>
                 
                  <div class="grid-box-reaction">
                   
                    <div class="mt-counter">
                      <p></p>
                    </div>
                  </div>
                </div>
              </div> 
              
            </div>

           

            
          </div>

            
              <div class="comments">
          <?php foreach($comments as $comment) { 
                     $tweet_user = User::getData($comment->user_id) ;
                     $timeAgo = Question::getTimeAgo($comment->time);
                     $replies = Question::replies($comment->id);
                     $reply_count = Question::countReplies($comment->id);
              ?>
 
          <div class="box-comment feed py-2"  >
                
            <div class="grid-tweet">
              <div>
                <img
                  src="Public/users/<?php echo $tweet_user->img; ?>"
                  alt=""
                  class="img-user-tweet"
                />
              </div>
  
              <div>
                <p>
                  <strong> <?php echo $tweet_user->name ?> </strong>
                  <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo ?></span>
                </p>
                <p>
                  <?php
                 echo  Question::getTweetLinks($comment->comment); ?>
                </p>
                    
                <div class="grid-reactions">
                  <div class="grid-box-reaction-rep">
                    <div class="hover-reaction-rep hover-reaction-comment reply"
                    data-user = "<?php echo $user_id; ?>" 
                    data-tweet = "<?php 
                    echo $comment->id; ?>">
                     
                      <i class="far fa-comment"></i>
                      <div class="mt-counter likes-count d-inline-block">
                        <p > <?php if($reply_count > 0) echo $reply_count; ?> </p>
                      </div>
                    </div>
                  </div>
                 <!-- Puntuación del comentario -->
                  </div>
                  <div style="margin-top : 5px;">
                  
                  <label style="margin-top: 40px;" class="labelScore" id="labelScore-<?php echo $comment->id; ?>">
                    Puntuación: 0 
                  </label>
                  <i style="font-size: 14px; color: #ffdd00;" class="fas fa-star"></i>

                  </div>
                  
                 
        <form action="Controller/handleForum/handleScore.php" method="post" class="rating-form" id="ratingForm-<?php echo $comment->id; ?>">
            <input type="hidden" name="comment_id" value="<?php echo $comment->id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="post_id" value="<?php echo  $tweet_id; ?>">
            <p style="font-size: 14px; color: #4242425d; margin-top:5px;"><strong>Califica el comentario:</strong></p>
            <div class="star-rating">
                <input type="radio" id="star5-<?php echo $comment->id; ?>" name="rating" value="5"><label for="star5-<?php echo $comment->id; ?>" title="5 estrellas">&#9733;</label>
                <input type="radio" id="star4-<?php echo $comment->id; ?>" name="rating" value="4"><label for="star4-<?php echo $comment->id; ?>" title="4 estrellas">&#9733;</label>
                <input type="radio" id="star3-<?php echo $comment->id; ?>" name="rating" value="3"><label for="star3-<?php echo $comment->id; ?>" title="3 estrellas">&#9733;</label>
                <input type="radio" id="star2-<?php echo $comment->id; ?>" name="rating" value="2"><label for="star2-<?php echo $comment->id; ?>" title="2 estrellas">&#9733;</label>
                <input type="radio" id="star1-<?php echo $comment->id; ?>" name="rating" value="1"><label for="star1-<?php echo $comment->id; ?>" title="1 estrella">&#9733;</label>
            </div>
        </form>
        <?php if ($comment->user_id == $user_id): ?>
    <form method="POST" action="/CerebroUCAB/Controller/handleForum/HandleComment.php">
        <input type="hidden" name="comment_id" value="<?php echo $comment->id; ?>">
        <button type="submit" style="border: none; background: none;margin-bottom: 35px;">
            <i style="font-size: 14px; color: red;" class="fas fa-trash"></i>
            <span style="font-size: 14px; color: red;">Eliminar comentario</span>
        </button>
    </form>
<?php endif; ?>
              </div> 
            
              
            </div> 
          
        </div> 

                <?php foreach ($replies as $reply) {
                       $tweet_user = User::getData($reply->user_id) ;
                       $timeAgo = Question::getTimeAgo($reply->time);
                    
                    ?>
                        <div class="box-reply feed"  >
                                
                        
                                <div class="grid-tweet">
                                <div>
                                    <img
                                    src="Public/users/<?php echo $tweet_user->img; ?>"
                                    alt=""
                                    class="img-user-tweet"
                                    />
                                </div>
                    
                                <div>
                                    <p>
                                    <strong> <?php echo $tweet_user->name ?> </strong>
                                    <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                                    <span class="username-twitter"><?php echo $timeAgo ?></span>
                                    </p>
                                    <p>
                                    <?php
                                    echo  Question::getTweetLinks($reply->reply); ?>
                                    </p>
                                        
                                    <?php if ($reply->user_id == $user_id): ?>
    <form method="POST" action="/CerebroUCAB/Controller/handleForum/HandleComment.php"> 
    <input type="hidden" name="reply_id" value="<?php echo $reply->id ?>">
        <button type="submit" style="border: none; background: none;">
            <i style="font-size: 14px; color: red;" class="fas fa-trash"></i>
            <label style="font-size: 14px; color: red;">Eliminar comentario</label>
        </button>
    </form>
<?php endif; ?>
                                </div> 
                                
                               
                                </div> 
                            
                            </div> 

                            <?php } ?>
            <?php } ?>
         
          <div class="popupTweet">

          </div>
          <div class="popupComment">

           </div>
           <div class="popupUsers">

           </div>
            
           </div>

        </div> 

      
        <div class="wrapper-right">
            <div style="width: 90%;" class="container">

          <div class="input-group py-2 m-auto pr-5 position-relative">

         
          <div class="search-result">


          </div>
          </div>
          </div>
  
        </div>
      </div>
      </div> 

      <script src="View/js/search.js"></script>
      <script type="text/javascript" src="View/js/hashtag.js"></script>
      <script type="text/javascript" src="View/js/like.js"></script>
      <script type="text/javascript" src="View/js/users.js"></script>
      <script type="text/javascript" src="View/js/comment.js?v=<?php echo time(); ?>"></script>
      <script type="text/javascript" src="View/js/retweet.js?v=<?php echo time(); ?>"></script>
      <script type="text/javascript" src="View/js/follow.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <script src="View/js/jquery-3.5.1.min.js"></script>

        <script src="View/js/popper.min.js"></script>
        <script src="View/js/bootstrap.min.js"></script>
        <script src="View/js/score.js"></script>

        
        
</body>

</html> 