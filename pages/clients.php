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



$action = $_GET['action'] ?? 'list'; // Pobieramy akcję (domyślnie lista klientów)
$id = $_GET['id'] ?? null; // Pobieramy ID klienta (jeśli istnieje)

switch ($action) {
    case 'view':
        require __DIR__ . '/client_edit.php';
        break;

    case 'delete':
        require __DIR__ . '/client_delete.php';
        break;

    case 'update':
        require __DIR__ . '/client_update.php';
        break;

    default:
}




?>