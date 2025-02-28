<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/public/db_connection.php';
require_once __DIR__ . '/public/session.php';
if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true) {
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$page = $_GET['page'] ?? 'dashboard';

// Obsługa dynamicznych ścieżek
if (preg_match('/^client\/(\d+)$/', $page, $matches)) {
    $_GET['client_id'] = $matches[1]; // Pobieramy ID klienta
    $page = 'client'; // Przekierowujemy na klienta
}

$allowed_pages = ['dashboard','login', 'clients','report_view', 'export_report','tasks', 'reports','task_edit', 'login','task_add','report_add', 'client_edit','client_add','task'];

if (!in_array($page, $allowed_pages)) {
    $page = 'dashboard';
}

$file = __DIR__ . "/pages/{$page}.php";

if (file_exists($file)) {
    require $file;
} else {
    echo $twig->render('layout.twig', ['content' => '<h2>Strona nie istnieje</h2>']);
}
}else{
    header('Location: pages/login.php');
    exit();
}