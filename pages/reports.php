<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';
function reportsList(){
    global $conn;
    $my_id = 1;
    //$my_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM reports WHERE user_id = " .$my_id."";
    $result = $conn->query($sql);
    $reports = [];
    while($row = $result->fetch_assoc()) {
        $reports[] = [
            'id' => $row['id'],
            'user_id' => $row['user_id'],
            'client_id' => $row['clients_id'],
            'title' => $row['title'],
            'content' => $row['content'],
            'created_at' => $row['created_at'],
        ];
    }
    return $reports;
 
}


$reports = reportsList();
echo $twig->render('reports.twig', [
            'reports' => $reports,
]);

?>