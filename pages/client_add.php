<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

$result = '';
if(isset($_POST['add_client'])){
    global $conn;
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $user_id = isset($_SESSION['id'])? (int)$_SESSION['id'] :0;
    $contact_phone = preg_replace('/\D/', '', $_POST['contact_phone']);
    if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($contact_phone)){
        $sql = "SELECT * FROM clients WHERE contact_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $result = "Klient znajduje się już w bazie danych."; 
        }else{
            $sql = "INSERT INTO clients (user_id ,first_name, last_name, contact_email, contact_phone) 
            VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('issss', $user_id, $first_name, $last_name, $email, $contact_phone);
            $result = $stmt->execute();
            if ($result) {
                $result = "Klient został dodany do bazy danych.";
                header('Location: index.php?page=clients');
                exit();
            } else {
                $result = "Wystąpił błąd: ". $conn->error;
            }
        }
    }
}
echo $twig->render('addClients.twig', ['result' => $result]);
?>