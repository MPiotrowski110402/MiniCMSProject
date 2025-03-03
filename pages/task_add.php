<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

if(isset($_POST['task_add_btn'])){
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $client = (int)$_POST['client'];
    if(!empty($title) &&!empty($description) &&!empty($date) &&!empty($client)){
    $sql = "INSERT INTO tasks (title, description, status, due_date, client_id) 
    VALUES (?, ?,'pending', ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $title, $description, $date, $client);
    $stmt->execute();
    header('Location: index.php?page=tasks');
    exit();
    }
}



function clientList(){
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);
    $clients = [];
    while($row = $result->fetch_assoc()) {
        $clients[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
        ];
    }
    return $clients;
}
$clients = clientList();
echo $twig->render('taskAdd.twig', [
        'clientsList' => $clients,
]);

?>