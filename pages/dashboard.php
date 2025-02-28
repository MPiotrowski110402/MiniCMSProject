<?php
require_once 'vendor/autoload.php';
require_once 'public/session.php';
require_once 'public/db_connection.php';

function CustomerCount() {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM clients";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}
function activeTasks() {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM tasks WHERE status = 'in_progress'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}
function completedTasks() {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM tasks WHERE status = 'completed'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}
function newClients() {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM clients WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}
function pendingTasks(){
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM tasks WHERE status = 'pending'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}
function reportsGen(){
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM reports ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result = $row['total'];
    return $result;
}




$activeTasks = activeTasks();
$customerCount = CustomerCount();
$completedTasks = completedTasks();
$newClients = newClients();
$pendingTasks = pendingTasks();
$reportGen = reportsGen();
echo $twig->render('dashboard.twig', [
    'title' => 'Panel Główny',
    'customerCount' => $customerCount,
    'activeTasks' => $activeTasks,
    'completedTasks' => $completedTasks,
    'newClients' => $newClients,
    'pendingTasks' => $pendingTasks,
    'reportGen' => $reportGen,
    
]);
?>