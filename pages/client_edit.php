<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';


if(isset($_POST['edit_client'])){
    global $conn;
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact_phone = preg_replace('/\D/', '', $_POST['contact_phone']);
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if(empty($first_name)){
            $first_name = $row['first_name'];
        }
        if(empty($last_name)){
            $last_name = $row['last_name'];
        }
        if(empty($email)){
            $email = $row['contact_email'];
        }
        if(empty($contact_phone)){
            $contact_phone = $row['contact_phone'];
        }
        $sql = "UPDATE clients SET first_name = ?, last_name = ?, contact_email = ?, contact_phone = ? 
        WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii', $first_name, $last_name, $email, $contact_phone, $user_id);
        $stmt->execute();
        header('Location: index.php?page=clients');
        exit();
    }
}

if(isset($_GET['delete']) && $_GET['delete'] == 'true'){
    global $conn;
    $user_id = isset($_GET['id']) ? (int)$_GET['id'] :0;
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    header('Location: index.php?page=clients');
    exit();
}

echo $twig->render('editClient.twig', []);


?>