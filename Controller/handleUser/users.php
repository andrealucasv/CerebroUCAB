<?php

include '../init.php';

class users {
    public function handleUsers() {
        $user_id = $_SESSION['user_id'];
        $u_id = 1;
        $flag = true;
        $headline = "";
        $users = [];

        if (isset($_POST['likeby']) && !empty($_POST['likeby'])) {
            $tweet_id = $_POST['likeby'];
            $users = Question::usersLiked($tweet_id);
            $headline = "Punteada por";

        } 
    }
}

// Uso de la clase users
$users = new users();
$users->handleUsers();
?>
