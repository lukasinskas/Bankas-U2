<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $id = (int) $_GET['id'];
    $users = unserialize(file_get_contents(__DIR__ . '/users.ser'));
    
    foreach($users as &$user) {
        if ($user['id'] == $id) {
            if($user['amount'] < $_POST['deduct']) {
                $_SESSION['msg'] = ['type' => 'error', 'text' => 'Not enough funds in the account'];
                header('Location: http://localhost/bank1/users.php?id=');
                die;
            }
            $user['amount'] -= $_POST['deduct'];
            file_put_contents(__DIR__ . '/users.ser', serialize($users));


        }
    }
    $_SESSION['msg'] = ['type' => 'ok', 'text' => 'You have deducted funds'];
    header('Location: http://localhost/bank1/users.php?id='.$id);
    die;
}


$users = unserialize(file_get_contents(__DIR__ . '/users.ser'));
$id = (int) $_GET['id'];

$find = false;
foreach($users as $user) {
    if ($user['id'] == $id) {
        $find = true;
        break;
    }
}

if (!$find) {
    die('User not found');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Deduct funds</title>
</head>
<body>
<?php require __DIR__ . '/menu.php' ?>
    <div class="container">
        <form class="form-create" action="?id=<?= $user['id'] ?>" method="post">
            <h2>Deduct funds</h2>
            <label>User`s name: </label>
            <input type="text" name="name" class="form-control" readonly value="<?= $user['name'] ?>">
            <label>User`s surname: </label>
            <input type="text" name="name" class="form-control" readonly value="<?= $user['surname'] ?>">
            <label>User`s amount: </label>
            <input type="text" name="amount" class="form-control" readonly value="<?= $user['amount'] ?>">
            <label>Deduct funds, EUR: </label>
            <input type="text" name="deduct" class="form-control">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Deduct</button>
        </form>
    </div>
</body>

</html>