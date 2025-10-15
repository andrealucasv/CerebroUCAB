<?php
include '../../Model/Classes/init.php';
include '../../Model/Classes/Score.php';

class HandleScore {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "tweetphp";

    public function handleScore() {
        // Ajusta la zona horaria a tu zona horaria deseada
        date_default_timezone_set('America/Caracas'); // Ajusta esto a tu zona horaria

        // Crea un objeto de tipo Score
        $score = new Score($this->servername, $this->username, $this->password, $this->dbname);

        // Define la acción a realizar
        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        $comment_id = $_POST['comment_id'] ?? $_GET['comment_id'] ?? null;
        $user_id = $_POST['user_id'] ?? $_GET['user_id'] ?? null;
        $post_id = $_POST['post_id'] ?? $_GET['post_id'] ?? null;

        if (!$comment_id) {
            die("Comment ID is required.");
        }

        // Verifica que el comment_id exista
        $score->verifyCommentId($comment_id, $for_user);

        if ($action == 'add' || $action == 'update') {
            $rating = $_POST['rating'] ?? null;
            $score->addOrUpdateRating($comment_id, $user_id, $rating);
            if ($for_user != $user_id) {
                $data_notify = [
                    'notify_for' => $for_user,
                    'notify_from' => $user_id,
                    'target' => $post_id,
                    'type' => 'like',
                    'time' => date("Y-m-d H:i:s"),
                    'count' => '0',
                    'status' => '0'
                ];
                $score->createNotification($data_notify);
            }
        } elseif ($action == 'delete') {
            $score->deleteRating($comment_id, $user_id);
        } elseif ($action == 'average') {
            $score->calculateAverageRating($comment_id);
        }

        // Recupera la puntuación actual del usuario para el comentario
        $score->getCurrentRating($comment_id, $user_id);
    }
}

// Crear un objeto de HandleScore y llamar al método handleScore
$handleScore = new HandleScore();
$handleScore->handleScore();
?>
