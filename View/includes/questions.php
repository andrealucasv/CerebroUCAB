<?php
$user_id = $_SESSION['user_id'];
global $tweets;
foreach($tweets as $tweet) { 

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

} 
$tweet_link = $tweet->id;

if($retweet_sign)
$comment_count = Question::countComments($retweeted_tweet->id);
else  $comment_count = Question::countComments($tweet->id); 

?>
         
        <div class="box-tweet feed" style="position: relative;" >
        <div class="post-category <?php echo htmlspecialchars($tweet_real->category); ?>">
          <?php echo htmlspecialchars($tweet_real->category); ?>
        </div>

       <a href="status/<?php echo $tweet_link; ?>">
        <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
        </a>
        
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
        <span class="time-twitter"><?php echo $timeAgo ?></span>
        </p>
        <p class="tweet-links">
        <?php

        echo Question::getTweetLinks($tweet_real->status); ?>
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
        <?php  
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

        <div class="grid-reactions">
        <div class="grid-box-reaction">
        <div class="hover-reaction hover-reaction-comment comment"
        data-user = "<?php echo $user_id; ?>" 
        data-tweet = "<?php 
        if($retweet_sign)
        echo $retweeted_tweet->id;
        else  echo $tweet->id; ?>">
          <?php $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Definir la URL que deseas comparar
          $userName_id=User::getUserNameById($user_id);
$target_url = "http://localhost/CerebroUCAB/". $userName_id;
if ($current_url !== $target_url) {
    // Mostrar el ícono y el contador de comentarios solo si la URL no coincide
    ?>
    <i class="far fa-comment"></i>
    <div class="mt-counter likes-count d-inline-block">
        <p> <?php if($comment_count > 0) echo $comment_count; ?>  </p>
    </div>
    <?php
}
?>
      
        </div>
        </div>
        

        
        </div>
        </div>
        </div>

        </div>


        <div class="popupTweet">

        </div>
        <div class="popupComment">

        </div>




<?php } ?>