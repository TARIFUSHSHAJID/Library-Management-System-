<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$dirName = dirname($scriptName);
if (strpos($dirName, '/public') !== false || strpos($dirName, '\\public') !== false) {
    $dirName = dirname($dirName);
}
if ($dirName === '/' || $dirName === '\\' || $dirName === '.') {
    $dirName = '';
}
define('BASE_URL', $dirName);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_db');

require_once __DIR__ . '/Database.php';

$conn = db_connect();

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    $token = generate_csrf_token();
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function validate_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF Validation Failed. Please refresh the page and try again.");
        }
    }
}

function set_flash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function get_flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

function redirect($url) {
    header('Location: ' . BASE_URL . '/' . $url);
    exit();
}

function view($viewPath, $data = []) {
    $fullPath = BASE_PATH . '/view/' . $viewPath . '.php';
    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        die("View $viewPath not found");
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect('auth/login');
    }
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        die("Access Denied");
    }
}

function json_read_file($filename) {
    $path = BASE_PATH . '/model/data/' . $filename . '.json';
    if (!file_exists($path)) {
        return [];
    }
    $content = file_get_contents($path);
    return json_decode($content, true) ?? [];
}

function json_write_file($filename, $data) {
    $path = BASE_PATH . '/model/data/' . $filename . '.json';
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}
