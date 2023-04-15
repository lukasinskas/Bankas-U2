<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $users = unserialize(file_get_contents(__DIR__ . '/users.ser'));

   

    foreach($users as $user) {
        if (strlen($_POST['name']) < 3 || strlen($_POST['surname']) < 3) {
            $_SESSION['msg'] = ['type' => 'error', 'text' => 'Name or surname is too short'];
            header('Location: http://localhost/bank1/create.php');
            die;
        }
        if(!preg_match ("/^[a-zA-z]*$/", $_POST['name'] )) {  
            $_SESSION['msg'] = ['type' => 'error', 'text' =>"Only letters are allowed in name."];  
            header('Location: http://localhost/bank1/create.php');
             die;
             } 
             if(!preg_match ("/^[a-zA-z]*$/", $_POST['surname'] )) {  
                $_SESSION['msg'] = ['type' => 'error', 'text' =>"Only letters are allowed in surname."];  
                header('Location: http://localhost/bank1/create.php');
                 die;
                 } 

        if (strlen($_POST['id']) < 11) {
                $_SESSION['msg'] = ['type' => 'error', 'text' => 'Personal ID should have 11 digits'];
                header('Location: http://localhost/bank1/create.php');
                die;
            }  
        if ($user['id'] == (int) $_POST['id']) {
                $_SESSION['msg'] = ['type' => 'error', 'text' => 'Such personal ID already exist'];
                header('Location: http://localhost/bank1/create.php?id='.$id);
                die;
            }   
        }  
    

    
    $id = json_decode(file_get_contents(__DIR__ . '/id.json'));
    $id++;
    file_put_contents(__DIR__ . '/id.json', json_encode($id));



    $user = [
        'id' => (int) $_POST['id'],
        'account' => $_POST['account'],
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'amount' => $_POST['amount'],   
       
    ];

    
    $users[] = $user;

   

    $users = serialize($users);
    file_put_contents(__DIR__ . '/users.ser', $users);

    $_SESSION['msg'] = ['type' => 'ok', 'text' => 'New account was created'];
    header('Location: http://localhost/bank1/users.php'); 
    die;

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
    <title>Create</title>
</head>
<body>
<?php require __DIR__ . '/menu.php' ?>
    <div class="container">
        <form action="" class="form-create" method="post">
            <h2>Create new account</h2>
            <input type="text" name="name" class="form-control" placeholder="Name (from 3 characters)" required>
            <input type="text" name="surname" class="form-control" placeholder="Surname" required>
            <input type="text" name="account" class="form-control" readonly placeholder="Account number" 
            value="<?= 'LT' . '60' . rand(1000000000000000, 9999999999999999) ?>">
            <input type="text" name="id" class="form-control" placeholder="Personal identification number" required>
            <input type="text" name="amount" class="form-control" readonly placeholder="Amount" value="0">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Add new account</button>
        </form>
    </div>
</body>

</html>