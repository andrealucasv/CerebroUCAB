<?php 
include '../../Model/Classes/init.php';
require_once '../../Model/validation/Validator.php';
require_once '../../Model/Classes/image.php';

use validation\Validator;

class handleQuestion {
    public function handleQuestion() {
        if (User::checkLogIn() === false) {
            header('location: index.php'); 
            exit();
        }

        if (isset($_POST['tweet'])) {
            $status = User::checkInput($_POST['status']);
            $img = $_FILES['tweet_img'];

            if ($_POST['status'] == '' && $img['name'] == '') {
                $_SESSION['errors_tweet'] = ['Status or image are required'];
                header('location: ../../home.php'); 
                exit();
            }

            $v = new Validator;
            $v->rules('status', $status, ['string', 'max:14']);
            if ($img['name'] != '') {
                $v->rules('image', $img, ['image']);
            }

            $errors = $v->errors;

            if ($errors == []) { 
                if ($img['name'] != '') {
                    $image = new Image($img, "tweet"); 
                    $tweetImg = $image->new_name;
                } else {
                    $tweetImg = null;
                }

                date_default_timezone_set("America/Caracas");
                $data = [
                    'user_id' => $_SESSION['user_id'], 
                    'post_on' => date("Y-m-d H:i:s")
                ];
                $post_id = User::create('posts', $data);
                $questionCategory = $_POST['category'];
                $data_tweet = [
                    'post_id' => $post_id,
                    'status' => $status,
                    'img' => $tweetImg,
                    'category' => $questionCategory
                ];
                User::create('tweets', $data_tweet);

                if ($img['name'] != '') {
                    $image->upload();
                }

                preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $mention);
                $user_id = $_SESSION['user_id'];
                foreach ($mention[1] as $men) {
                    $id = User::getIdByUsername($men);
                    if ($id != $user_id) {
                        $data_notify = [
                            'notify_for' => $id,
                            'notify_from' => $user_id,
                            'target' => $post_id,
                            'type' => 'mention',
                            'time' => date("Y-m-d H:i:s"),
                            'count' => '0',
                            'status' => '0'
                        ];
                        Question::create('notifications', $data_notify);
                    }
                }

                preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
                if (!empty($hashtag)) { 
                    Question::addTrend($status);
                }

                header('location: ../../home.php');
            } else {
                $_SESSION['errors_tweet'] = $errors;
                header('location: ../../home.php');
            }
        } else {
            header('location: ../../home.php');
        }
    }
}

// Instanciar la clase y llamar al método
$handleQuestion = new handleQuestion();
$handleQuestion->handleQuestion();
?>
