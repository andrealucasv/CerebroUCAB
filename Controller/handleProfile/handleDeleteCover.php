<?php
include '../../Model/Classes/init.php';

class handleDeleteCover {
    public function handleDeleteCover() {
        if (User::checkLogIn() === false) {
            header('location: index.php');
            exit();
        }

        $username = User::getUserNameById($_SESSION['user_id']);
        $user = User::getData($_SESSION['user_id']);
        $currentCover = $user->imgCover;

        if ($currentCover !== 'cover.png') {
            unlink('../../Public/users/' . $currentCover);
        }

        $data = [
            'imgCover' => 'cover.png',
        ];

        $sign = User::update('users', $_SESSION['user_id'], $data);

        if ($sign == true) {
            header('location: ../../' . $username);
        } else {
            header('location: ../../' . $username);
        }
        exit();
    }
}

// Uso de la clase handleDeleteCover
$handleDeleteCover = new handleDeleteCover();
$handleDeleteCover->handleDeleteCover();
?>
