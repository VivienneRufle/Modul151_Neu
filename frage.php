<?php
// Verbindung zur Datenbank einbinden
include('db_connector.inc.php');

//Session einbinden
session_start();
session_regenerate_id(true);

$error = '';
$message = '';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}


// Wurden Daten mit "POST" gesendet?
if($_SERVER['REQUEST_METHOD'] == "POST"){

    // Ausgabe des gesamten $_POST Arrays
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";

    // thema ausgefüllt?
    if(isset($_POST['thema'])){
        //trim and sanitize
        $thema = trim(htmlspecialchars($_POST['thema']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if(empty($thema) || strlen($thema) > 30){
            $error .= "Geben Sie bitte ein korrektes Thema ein.<br />";
        }
    } else {
        $error.= "Geben Sie bitte ein Thema ein.<br />";
    }

    // titel ausgefüllt?
    if(isset($_POST['titel'])){
        //trim and sanitize
        $titel = trim(htmlspecialchars($_POST['titel']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if(empty($titel) || strlen($titel) > 30){
            $error .= "Geben Sie bitte einen korrekten Titel ein.<br />";
        }
    } else {
        $error.= "Geben Sie bitte einen Titel ein.<br />";
    }

    // text ausgefüllt?
    if(isset($_POST['text'])){
        //trim
        $text = trim($_POST['text']);

        //mindestens 1 Zeichen und maximal 100 Zeichen lang, gültige Emailadresse
        if(empty($text)){
            $error .= "Geben Sie bitte einen korrekten Text ein.<br />";
        }
    } else {
        $error.= "Geben Sie bitte einen Text ein.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if(empty($error)){
        // Sendet lediglich Query an den Server, welches firstname, lastname, username, password, email als Platzhalter enthält
        $query = "INSERT INTO users (thema, titel, text, id)
        VALUES (?, ?, ?, ?); ";

        // Query vorbereiten mit prepare();
        $stmt = $mysqli->prepare($query);

        $id = 1;

        // Parameter an Query binden mit bind_param() -> Die Parameter werden an Server nachgereicht
        $passwordh = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $thema, $titel, $text, $id);

        // query ausführen mit execute();
        $stmt->execute();

        // Verbindung schliessen
        $stmt->close();

        // Weiterleitung auf login.php
        header("Location: index.php");
    }
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
    <h1>Kommentar</h1>

    <form action="" method="post">
        <!-- vorname -->
        <div class="form-group">
            <label for="thema">Thema *</label>
            <input type="text" name="thema" class="form-control" id="thema"
                   value="<?php echo $thema; ?>"
                   placeholder="Geben Sie Ihr Thema ein."
                   required="true">
        </div>
        <div class="form-group">
            <label for="titel">Titel *</label>
            <input type="text" name="titel" class="form-control" id="titel"
                   value="<?php echo $titel; ?>"
                   placeholder="Geben Sie Ihr Titel ein."
                   required="true">
        </div>
        <div class="form-group">
            <label for="text">Text *</label>
            <input type="text" name="text" class="form-control" id="text"
                   value="<?php echo $text; ?>"
                   placeholder="Geben Sie Ihr Text ein."
                   required="true">
        </div>
            <button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
            <button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
        </div>
    </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>