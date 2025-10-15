<?php

    class User extends Connect {
            protected static $pdo;

        public function createNotification($data) {
            $dsn = 'mysql:host=localhost;dbname=tweetphp';
            $username = 'root';
            $password = '';
    
            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $columns = implode(', ', array_keys($data));
                $placeholders = ':' . implode(', :', array_keys($data));
                $sql = "INSERT INTO notifications ({$columns}) VALUES ({$placeholders})";
                
                $stmt = $pdo->prepare($sql);
                foreach ($data as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
                
                if ($stmt->execute() === FALSE) {
                    throw new Exception("Failed to insert notification.");
                }
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        }

        public static function CountNotification($user_id){
            $stmt = self::connect()->prepare("SELECT COUNT(notify_for) as count FROM `notifications`
            WHERE notify_for = :user_id AND count = 0");
             $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            $u = $stmt->fetch(PDO::FETCH_OBJ);
            return $u->count;
          } 

          public static function notification($user_id){
            $stmt = self::connect()->prepare("SELECT * FROM `notifications`
            WHERE notify_for = :user_id ORDER BY time DESC");
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
          } 
          public static function updateNotifications($user_id){
            $stmt = self::connect()->prepare("UPDATE `notifications` SET count = 1
             WHERE notify_for = :user_id AND count = 0" );
            $stmt->bindParam(":user_id" , $user_id , PDO::PARAM_STR);
             $s =$stmt->execute();
             if($s)
              return true;
            else return false;  
          } 

    }


?>