<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';
function reportsList(){
    global $conn;
    $my_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] :0;
    $sql = "SELECT * FROM reports WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $result = $stmt->get_result();
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