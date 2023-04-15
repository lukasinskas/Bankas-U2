<?php
define('ENTER', true);
session_start();
$users = unserialize(file_get_contents(__DIR__ . '/users.ser'));

$page = (int) ($_GET['page'] ?? 1);

$sort = $_GET['sort'] ?? '';    

if ($sort == 'surname_asc') {
    usort($users, fn($a, $b) => $a['surname'] <=> $b['surname']);
}
elseif ($sort == 'surname_desc') {
    usort($users, fn($a, $b) => $b['surname'] <=> $a['surname']);
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
    <title>Bankas</title>
</head>

<body>
    <?php require __DIR__ . '/menu.php' ?>

    <form action="" method="get">
        <fieldset>
            <select name="sort">
                <option value="surname_asc" <?php if ($sort == 'surname_asc') echo 'selected' ?>>Surname A-Z</option>
                <option value="surname_desc" <?php if ($sort == 'surname_desc') echo 'selected' ?>>Surname Z-A</option>
            </select>
            <button type="submit" class="btn btn btn-secondary btn-sm">sort</button>
        </fieldset>

    </form>
    <ul>
        <?php foreach($users as $user) : ?>
            <table class="table table-sm table-success table-striped table-bordered">
            <thead>
            <tr>
             <th scope="col">Name</th>
             <th scope="col">Surname</th>
             <th scope="col">Account number</th>
             <th scope="col">Personal ID</th>
             <th scope="col">Account`s amount</th>
             <th colspan="2" class="table-active"><form action="http://localhost/bank1/delete.php?id=<?= $user['id'] ?>" method="post">
                <button type="submit" class="btn btn-danger btn">delete account</button>
            </form></th>
            
            </tr>
            </thead>
            <tbody>
                    <tr>
                    <td scope="row"><?= $user['name'] ?></th>
                    <td><?= $user['surname'] ?></td>
                    <td><?= $user['account'] ?></td>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['amount'] ?></td>
                    <th scope="col"><a class="btn btn-success" href="http://localhost/bank1/add.php?id=<?= $user['id'] ?>">Add funds</a></th>
                    <th scope="col"><a class="btn btn-success" href="http://localhost/bank1/deduct.php?id=<?= $user['id'] ?>">Deduct funds</a></th>
                    
                    </tr>
            
            </tbody>
            
             
            
           
            </table>
        <?php endforeach ?>
    </ul>

  
</body>

</html>