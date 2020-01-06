<?php
/**
 * Created by PhpStorm.
 * User: v.rufle
 * Date: 06.01.20
 * Time: 18:36
 */

//Session einbinden
session_start();
session_regenerate_id(true);

include('db_connector.inc.php');

if (!isset($_GET['id'])) {
    // goto home if id is not set
    header('Location: index.php');
    return;
}


set_time_limit(0);

$sql = "SELECT thema, titel, text, id, `timeStamp` FROM frage WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->bind_result($thema, $titel, $text, $id, $timeStamp);
$stmt->fetch();
$stmt->close();

$sql = "SELECT id, text, `timeStamp` FROM kommentar WHERE idF = ?"; // SQL injection here
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);
//var_dump($rows);


 if ($_SERVER["REQUEST_METHOD"] == "POST"){
   header("Location: kommentar.php");                 
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Registrieren</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1><?= $titel ?></h1>
    <p>
        <b><?= $thema ?></b><br>
        <?= $text ?> (<?= $id ?>) - <?= $timeStamp ?>
    </p>


    <table class="table table-striped">
        <thead>
        <tr>
            <td scope="col">ID</td>
            <td scope="col">TXT</td>
            <td scope="col">Titel</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['text']; ?></td>
                <td><?= $row['timeStamp']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if(!isset($_SESSION['username'])) { ?>
        <form action="" method="POST">
            <button type="submit" name="button" value="submit" class="btn btn-info">Kommentar</button>
        </form>

    <?php
    }
    ?>
 
 
 


</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>


