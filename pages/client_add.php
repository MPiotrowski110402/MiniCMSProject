<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

$result = '';
if(isset($_POST['add_client'])){
    global $conn;
    $user_id = $_GET['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_id = $_SESSION['id'];
    $contact_phone = $_POST['contact_phone'];
    if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($contact_phone)){
        $sql = "SELECT * FROM clients WHERE contact_email = '$email'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0) {
            $result = "Klient znajduje się już w bazie danych.";
            
        }else{
            $sql = "INSERT INTO clients (user_id ,first_name, last_name, contact_email, contact_phone) VALUES ($user_id,'$first_name', '$last_name', '$email', '$contact_phone')";
            if ($conn->query($sql) === TRUE) {
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