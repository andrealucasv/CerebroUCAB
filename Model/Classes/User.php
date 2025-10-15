<?php 


class User extends Connect {
    
        protected static $pdo;
         
      public static function checkInput ($input) {
        $input = htmlspecialchars($input);
        $input = trim($input);
        $input = stripslashes($input);
        return $input;
      }  

      function extraerUsuario($correo) {
        // Buscar la posición del "@" en el correo
        $posicion_arroba = strpos($correo, '@');
        // Extraer la parte antes del "@"
        $nombre_usuario = substr($correo, 0, $posicion_arroba);
        // Eliminar todos los puntos del nombre de usuario
        $nombre_usuario = str_replace('.', '', $nombre_usuario);
        return $nombre_usuario;
      }

      public static  function login ($email , $password) {
        $stmt = self::connect()->prepare("SELECT `id` from `users` WHERE `email` = :email AND `password` = :password");
        $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
        $password =md5($password);
        $stmt->bindParam(":password" , $password , PDO::PARAM_STR);    
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
         
        if ($stmt->rowCount() > 0) {
            $_SESSION['user_id'] = $user->id;
            header('location: ../../home.php');
        } else {return false; }
      }

    

      public static function create($table, $fields = array()) {
        $colms = implode(',', array_keys($fields));
        $values = ':' . implode(', :', array_keys($fields));
        $sql = "INSERT INTO {$table} ({$colms}) VALUES ({$values})";
        $pdo = self::connect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            foreach ($fields as $key => $data) {
                $stmt->bindValue(':' . $key, $data);
            }
            if ($stmt->execute() === FALSE) {
                $pdo->rollback();
                return false;
            } else {
                $user_id = $pdo->lastInsertId();
                $pdo->commit();
                return $user_id;
            }
        } catch (PDOException $e) {
            $pdo->rollback();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
      public static function register($email , $password , $name , $username) {
    
        $pdo = self::connect();
        $pdo->beginTransaction();      
        $stmt = $pdo->prepare("INSERT INTO `users` (`email` , `password` , `name` , `username`) Values (:email , :password , :name , :username)");

        $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
        $password =md5($password);
        $stmt->bindParam(":password" , $password , PDO::PARAM_STR); 
        $stmt->bindParam(":name" , $name , PDO::PARAM_STR);
        $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
    
        if ($stmt->execute() === FALSE) {
          $pdo->rollback();
          echo 'Unable to insert data';
        } else {
          $user_id = $pdo->lastInsertId();
          $pdo->commit();
        }
          $_SESSION['user_id'] = $user_id;
          
          // make user follow the owner by default and notofications also
          date_default_timezone_set("America/Caracas");
          $data = [
              'follower_id' => $user_id , 
              'following_id' => 2 , 
              'time' => date("Y-m-d H:i:s") 
          ];
          User::create('follow' , $data);
          $data_notify = [
            'notify_for' => 2,
            'notify_from' => $user_id ,
            'target' => 0, 
            'type' => 'follow' ,
            'time' => date("Y-m-d H:i:s") ,
            'count' => '0' , 
            'status' => '0'
            ];
            Question::create('notifications' , $data_notify);

          $_SESSION['welcome'] = 'welcome';
          header('location: ../../home.php')  ;

      } 

      public static function registerVerification($email, $code) {
        $pdo = self::connect(); // Obtener una conexión a la base de datos
        $stmt = $pdo->prepare("INSERT INTO `verificacion` (`correo`, `codigo`) VALUES (:email, :code)");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":code", $code, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar
        }
    }

     //comparar el codigo de la base de datos
     public static function compararCodigo($email, $user_code) {
      $pdo = self::connect(); // Obtener una conexión a la base de datos
      $stmt = $pdo->prepare("SELECT `codigo` FROM `verificacion` WHERE `correo` = :email");
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row) {
          $db_code = $row['codigo'];
          return ($user_code === $db_code); // Devuelve true si los códigos coinciden, de lo contrario, devuelve false
      } else {
          return false; // No se encontró ningún código para el correo electrónico dado
      }
  }

      public static function update($table , $user_id , $fields = array()){
          $colms = '';
          $loopCount = 1;
          foreach ($fields as $name => $value) {
            $colms .= "`{$name}` = :{$name}";
            if($loopCount < count($fields)) {
                $colms .= ', ' ; }

              $loopCount++;  
          }
          $sql = "UPDATE {$table} SET {$colms} WHERE id = {$user_id}";
          $pdo = self::connect(); 
            if($stmt = $pdo->prepare($sql)) {
                  foreach($fields as $key => $data) {
                    $stmt->bindValue(':'. $key , $data );
                  }
                  $stmt->execute();
                  return true;
            }

      } 

      public static function delete($table, $array){
        $sql   = "DELETE FROM " . $table;
        $where = " WHERE ";
    
        foreach($array as $key => $value){
          $sql .= $where . $key . " = " . $value . "";
          $where = " AND ";
        }
        $sql .= ";";
       
        $stmt = self::connect()->prepare($sql);
        $stmt->execute();
      }

      public static function getData($id) {
        $stmt = self::connect()->prepare("SELECT * from `users` WHERE `id` = :id");
        $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
        $stmt->execute();
       return $stmt->fetch(PDO::FETCH_OBJ);
      }
        public static function logout () {
            $_SESSION = array();
            session_destroy();
            header('location: ../../index.php');
        }

       public static function checkEmail($email) {
        $stmt = self::connect()->prepare("SELECT `email` from `users` WHERE `email` = :email");
        $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else return false;
        } 
        
        public static function checkUserName($username) {
          $stmt = self::connect()->prepare("SELECT `username` from `users` WHERE `username` = :username");
          $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
          $stmt->execute();
  
          if ($stmt->rowCount() > 0) {
              return true;
          } else return false;
          } 

          public static function checkLogIn () {
              if (isset($_SESSION['user_id']))
                    return true;
              else return false;      
          }

          public static function getIdByUsername($username) {
            $stmt = self::connect()->prepare("SELECT `id` from `users` where `username` = :username");
            $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->id;
          }

          public static function getUserNameById($id) {
            $stmt = self::connect()->prepare("SELECT `username` from `users` where `id` = :id");
            $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->username;
          }

          public static function search($search){
            $stmt = self::connect()->prepare("SELECT `id`,`username`,`name`,`img`,`imgCover` FROM `users`
            WHERE `username` LIKE ? OR `name` LIKE ?");
            $stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
            $stmt->bindValue(2, $search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
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

