<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';


function clientsList(){
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);
    $clients = [];
    while($row = $result->fetch_assoc()) {
        $clients[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'contact' => $row['contact_email'],
            'phone' => $row['contact_phone'],
        ];
    }
    return $clients;
    
}

$clients = clientsList();
echo $twig->render('clients.twig', ['clientsList' => $clients]);




?>