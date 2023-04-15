<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_GET['id'])) {
    http_response_code(400);
    die;
}

$id = (int) $_GET['id'];

$users = unserialize(file_get_contents(__DIR__ . '/users.ser'));


foreach($users as $user) {
    if ($user['id'] === $id) {
    if ($user['amount'] > 0) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'An account with funds cannot be deleted.'];
        header('Location: http://localhost/bank1/users.php');
        die;
    } else {
        break;
    }
}
}
$users = array_filter($users, fn($users) => $users['id'] != $id);
$users = serialize($users);
file_put_contents(__DIR__ . '/users.ser', $users);

$_SESSION['msg'] = ['type' => 'ok', 'text' => 'User was deleted'];
header('Location: http://localhost/bank1/users.php');


