<?php
class Score {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function verifyCommentId($comment_id, &$for_user) {
        $sql = "SELECT id, user_id FROM comments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            die("Invalid Comment ID.");
        }
        $row = $result->fetch_assoc();
        $for_user = $row['user_id']; // Usuario que hizo el comentario
    }

    public function addOrUpdateRating($comment_id, $user_id, $rating) {
        $sql = "SELECT * FROM comment_ratings WHERE comment_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "UPDATE comment_ratings SET rating = ? WHERE comment_id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $rating, $comment_id, $user_id);
        } else {
            $sql = "INSERT INTO comment_ratings (comment_id, user_id, rating) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $comment_id, $user_id, $rating);
        }
        $stmt->execute();
    }

    public function deleteRating($comment_id, $user_id) {
        $sql = "DELETE FROM comment_ratings WHERE comment_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
    }

    public function calculateAverageRating($comment_id) {
        $sql = "SELECT AVG(rating) AS average_rating FROM comment_ratings WHERE comment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $average_rating = $row['average_rating'];
        $average_rating = number_format((float)$average_rating, 2, '.', '');
        echo json_encode(['average_rating' => $average_rating]);
        exit();
    }

    public function getCurrentRating($comment_id, $user_id) {
        $sql = "SELECT rating FROM comment_ratings WHERE comment_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $current_rating = $row['rating'] ?? 0;
        echo json_encode(['current_rating' => $current_rating]);
    }

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
}
?>
