<?php
include '../../Model/Classes/init.php' ;



class HandleComment {

    public function handleComment() {
		$servername = "localhost";
		$dbname = "tweetphp";
		$username = "root";
		$password = "";
		$user_id = $_SESSION['user_id'];
		$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Verificar conexión
	if ($conn->connect_error) {
		die("Conexión fallida: " . $conn->connect_error);
	}
		
		// comentarios
		if(isset($_POST['qoute']) && !empty($_POST['qoute'])){
			$tweet_id  = $_POST['qoute'];
			$get_id    = $_POST['user_id'];
			$comment   = User::checkInput($_POST['comment']);
			date_default_timezone_set("America/Caracas");
				
	
				$data = [
					'user_id' => $_SESSION['user_id'] , 
					'post_id' => $tweet_id , 
					'comment' => $comment , 
					'time' => date("Y-m-d H:i:s") ,
				];
				if ($comment != '') {
					$for_user = Question::getData($tweet_id)->user_id;
			
						if($for_user != $user_id) {
							$data_notify = [
							'notify_for' => $for_user ,
							'notify_from' => $user_id ,
							'target' => $tweet_id , 
							'type' => 'comment' ,
							'time' => date("Y-m-d H:i:s") ,
							'count' => '0' , 
							'status' => '0'
							];
					
							Question::create('notifications' , $data_notify);
							
						} 
				 User::create('comments' , $data);
	
				}
		}
	
		if(isset($_POST['reply']) && !empty($_POST['reply'])){
			$tweet_id  = $_POST['reply'];
			$get_id    = $_POST['user_id'];
		
			$comment   = User::checkInput($_POST['comment']);
	
				date_default_timezone_set("America/Caracas");
			  
			
				$data = [
					'user_id' => $_SESSION['user_id'] , 
					'comment_id' => $tweet_id , 
					'reply' => $comment , 
					'time' => date("Y-m-d H:i:s") ,
				];
				if ($comment != '') { 
					// notification
					$for_user = Question::getComment($tweet_id)->user_id;
					$target = Question::getComment($tweet_id)->post_id;
			
					if($for_user != $user_id) {
						$data_notify = [
						'notify_for' => $for_user ,
						'notify_from' => $user_id ,
						'target' => $target , 
						'type' => 'reply' ,
						'time' => date("Y-m-d H:i:s") ,
						'count' => '0' , 
						'status' => '0'
						];
				
						Question::create('notifications' , $data_notify);
						
					} 
					
				 User::create('replies' , $data);
				}
		}
		if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
			$tweet_id   = $_POST['showPopup'];
			$user       = User::getData($user_id);
			$retweet_comment = false;
			$qoq = false;
			if (Question::isRetweet($tweet_id)) {
			$retweet =Question::getRetweet($tweet_id);
			if ($retweet->retweet_id == null) {
	
				if ($retweet->retweet_msg != null) {

	
					$user_tweet = User::getData($retweet->user_id) ;
					 $timeAgo = Question::getTimeAgo($retweet->post_on) ; 
					 $qoute = $retweet->retweet_msg;
					 $retweet_comment = true;
			   
	
				  $tweet_inner = Question::getTweet($retweet->tweet_id);
				  $user_inner_tweet = User::getData($tweet_inner->user_id) ;
				  $timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on); 
	
	
				} else {

					$tweet      = Question::getTweet($retweet->tweet_id);
					$user_tweet = User::getData($tweet->user_id);
					$timeAgo = Question::getTimeAgo($tweet->post_on) ; 
				}
			} else {

				if ($retweet->retweet_msg == null) {
					
					$retweeted_tweet = Question::getRetweet($retweet->retweet_id);
	
					if($retweeted_tweet->tweet_id != null) {
							$user_tweet = User::getData($retweeted_tweet->user_id) ;
							$timeAgo = Question::getTimeAgo($retweeted_tweet->post_on) ; 
	
							$retweet_inner = Question::getRetweet($retweet->retweet_id);
	
							$qoute = $retweet_inner->retweet_msg;
							$retweet_comment = true;
					
	
						
						$tweet_inner = Question::getTweet($retweet_inner->tweet_id);
						$user_inner_tweet = User::getData($tweet_inner->user_id) ;
						$timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on); 
	
					} else {

	
							 $user_tweet = User::getData($retweeted_tweet->user_id) ;
							$timeAgo = Question::getTimeAgo($retweeted_tweet->post_on) ; 
	
							$retweet_inner = Question::getRetweet($retweet->retweet_id);
	
							$qoute = $retweet_inner->retweet_msg;
							$retweet_comment = true;
							$qoq = true;
	
						
						$tweet_inner = Question::getRetweet($retweeted_tweet->retweet_id);
						$user_inner_tweet = User::getData($tweet_inner->user_id) ;
						$timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on); 
						$inner_qoute = $tweet_inner->retweet_msg;
	
					}
				} else {
	
					$user_tweet = User::getData($retweet->user_id) ;
					$timeAgo = Question::getTimeAgo($retweet->post_on) ; 
					$qoute = $retweet->retweet_msg;
					$qoq = true; 
					
					$tweet_inner = Question::getRetweet($retweet->retweet_id);
					$user_inner_tweet = User::getData($tweet_inner->user_id) ;
					$timeAgo_inner = Question::getTimeAgo($tweet_inner->post_on);
					$inner_qoute = $tweet_inner->retweet_msg;
				}
				
			}	
	
		} else {
	
			$tweet      = Question::getTweet($tweet_id);
			$user_tweet = User::getData($tweet->user_id);
			$timeAgo = Question::getTimeAgo($tweet->post_on) ;
			
	
		}
		
	?>
	<div class="retweet-popup">
	<div class="wrap5">
		<div class="retweet-popup-body-wrap">
			<div class="retweet-popup-heading">
				<h3>Responder Pregunta</h3>
				<span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
			</div>
			<div class="retweet-popup-input">
				<div class="retweet-popup-input-inner">
					<input  class="retweet-msg" type="text" placeholder="Agregar Comentario..."/>
				</div>
			</div>
			
					
			<div class="grid-tweet py-2">
				  <div>
					<img
					  src="Public/users/<?php echo $user_tweet->img; ?>"
					  alt=""
					  class="img-user-tweet"
					/>
				  </div>
	  
				  <div>
					<p>
					  <strong> <?php echo $user_tweet->name ?> </strong>
					  <span class="username-twitter">@<?php echo $user_tweet->username ?> </span>
					  <span class="username-twitter"><?php echo $timeAgo ?></span>
					</p>
					<p>
					<?php
					  if ($retweet_comment || $qoq)
					  echo  Question::getTweetLinks($qoute);
					  else echo  Question::getTweetLinks($tweet->status); ?>
					</p>
					
					<?php if ($retweet_comment == false && $qoq == false) { ?>
					<?php if ($tweet->img != null) { ?>
					<p class="mt-post-tweet">
					  <img
						src="Public/questions/<?php echo $tweet->img; ?>"
						alt=""
						class="img-post-retweet"
					  />
					</p>
				   <?php } ?>
				   <?php }  else { ?>
	
					<div  class="mt-post-tweet comment-post">
	
					<div class="grid-tweet py-3  ">
					<div>
					<img
					src="Public/users/<?php echo $user_inner_tweet->img; ?>"
					alt=""
					class="img-user-tweet"
					/>
					</div>
	
					<div>
					<p>
					<strong> <?php echo $user_inner_tweet->name ?> </strong>
					<span class="username-twitter">@<?php echo $user_inner_tweet->username ?> </span>
					<span class="username-twitter"><?php echo $timeAgo_inner ?></span>
					</p>
					<p>
					<?php 
						if ($qoq)
						echo $inner_qoute;
						else  echo  Question::getTweetLinks($tweet_inner->status); ?>
					</p>
					<?php
					if($qoq == false) {
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
				   
	
		</div>
	</div>
	
	
			<div class="retweet-popup-footer"> 
				<div class="retweet-popup-footer-right">
					<button class="comment-it" 
					data-tweet="<?php echo $tweet_id;?>"
					data-user="<?php echo $user_id;?>"
					data-tmp="<?php echo $retweet_comment; ?>" 
					data-qoq="<?php echo $qoq; ?>" 
				 type="submit"><i class="fas fa-pencil-alt" aria-hidden="true"></i>Comentar</button>
				</div>
			</div> 
			
	
	</div>
	
	<!-- Post Comment PopUp ends-->
	
	<?php }  
	
	
	if(isset($_POST['showReply']) && !empty($_POST['showReply'])){
		$comment_id   = $_POST['showReply'];
		$user       = User::getData($user_id);
		
	
		$tweet      = Question::getComment($comment_id);
		$user_tweet = User::getData($tweet->user_id);
		$timeAgo = Question::getTimeAgo($tweet->time) ; 
	
	?>
	<div class="retweet-popup">
	<div class="wrap5">
	<div class="retweet-popup-body-wrap">
		<div class="retweet-popup-heading">
			<h3>Responder</h3>
			<span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
		</div>
		<div class="retweet-popup-input">
			<div class="retweet-popup-input-inner">
				<input  class="retweet-msg" type="text" placeholder="Comentar.."/>
			</div>
		</div>
		
				
		<div class="grid-tweet py-2">
			  <div>
				<img
				  src="Public/users/<?php echo $user_tweet->img; ?>"
				  alt=""
				  class="img-user-tweet"
				/>
			  </div>
	
			  <div>
				<p>
				  <strong> <?php echo $user_tweet->name ?> </strong>
				  <span class="username-twitter">@<?php echo $user_tweet->username ?> </span>
				  <span class="username-twitter"><?php echo $timeAgo ?></span>
				</p>
				<p>
				<?php
				   echo  Question::getTweetLinks($tweet->comment); ?>
				</p>
	
	</div>
	</div>
	   
	
	
	
	
		<div class="retweet-popup-footer"> 
			<div class="retweet-popup-footer-right">
				<button class="reply-it" 
				data-tweet="<?php echo $comment_id;?>"
				data-user="<?php echo $user_id;?>"
			 type="submit"><i class="fas fa-pencil-alt" aria-hidden="true"></i>Comentar</button>
			</div>
		</div> 
		
	
	</div>
	
	<!-- Retweet PopUp ends-->
	<?php }
		// Verificar que el ID del comentario fue enviado
	if (isset($_POST['reply_id'])) {
		// Obtener el id del comentario a eliminar
		$reply_id = intval($_POST['reply_id']);
	
		// Verificar que el id del comentario no es nulo
		if ($reply_id > 0) {
			// Mostrar el ID del comentario para depuración
			echo "ID del comentario a eliminar: " . $reply_id . "<br>";
	
			// Iniciar una transacción
			$conn->begin_transaction();
	
			try {
				// 2. Buscar y eliminar en la tabla "replies"
				$sql_delete_replies = "DELETE FROM replies WHERE id = ?";
				$stmt_replies = $conn->prepare($sql_delete_replies);
				$stmt_replies->bind_param("i", $reply_id);
				if (!$stmt_replies->execute()) {
					throw new Exception($stmt_replies->error);
				}
				$stmt_replies->close();
	
				// Confirmar la transacción
				$conn->commit();
	
				// Redirigir a la página anterior
				$previousPage = $_SERVER['HTTP_REFERER'];
				header("Location: $previousPage");
				exit();
			} catch (Exception $e) {
				// Revertir la transacción en caso de error
				$conn->rollback();
				echo "Error al eliminar el comentario: " . $e->getMessage();
			}
		} else {
		   
		}
	} 
	// Verificar que el ID del comentario fue enviado
	if (isset($_POST['comment_id'])) {
		// Obtener el id del comentario a eliminar
		$comment_id = intval($_POST['comment_id']);
	
		// Verificar que el id del comentario no es nulo
		if ($comment_id > 0) {
			// Mostrar el ID del comentario para depuración
			echo "ID del comentario a eliminar: " . $comment_id . "<br>";
	
			// Iniciar una transacción
			$conn->begin_transaction();
	
			try {
				// 1. Buscar y eliminar en la tabla "comment_ratings"
				$sql_delete_ratings = "DELETE FROM comment_ratings WHERE comment_id = ?";
				$stmt_ratings = $conn->prepare($sql_delete_ratings);
				$stmt_ratings->bind_param("i", $comment_id);
				if (!$stmt_ratings->execute()) {
					throw new Exception($stmt_ratings->error);
				}
				$stmt_ratings->close();
	
				// 2. Buscar y eliminar en la tabla "comments"
				$sql_delete_comment = "DELETE FROM comments WHERE id = ?";
				$stmt_comment = $conn->prepare($sql_delete_comment);
				$stmt_comment->bind_param("i", $comment_id);
				if (!$stmt_comment->execute()) {
					throw new Exception($stmt_comment->error);
				}
				$stmt_comment->close();
	
				// Confirmar la transacción
				$conn->commit();
	
				// Redirigir a la página anterior
				$previousPage = $_SERVER['HTTP_REFERER'];
				header("Location: $previousPage");
				exit();
			} catch (Exception $e) {
				// Revertir la transacción en caso de error
				$conn->rollback();
				echo "Error al eliminar el comentario: " . $e->getMessage();
			}
		} else {
			
		}
	} else {
		
	}
	
	// Cerrar conexión
	$conn->close();
	

	
	
	
    }
}

// Crear un objeto de HandleScore y llamar al método handleScore
$handleComment = new HandleComment();
$handleComment->handleComment();
?>
