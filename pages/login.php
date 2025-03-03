<?php
require_once '../vendor/autoload.php';
require_once '../public/session.php';
require_once '../public/db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $password = ($_POST['password']);// hasło do zabezpieczenia
        if(!empty($username) && !empty($password)){
            $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['zalogowany'] = true;
                $_SESSION['user'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                    header('Location: ../index.php');
                    exit();
            }else {
                header('Location: login.php');
                exit();
            }
        }
    }
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '../../templates');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('login.twig', ['error' => $error ?? '']);

?>