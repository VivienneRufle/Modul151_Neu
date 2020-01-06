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


if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['kommi'])) {
        //trim and sanitize
        $kommi = trim(htmlspecialchars($_POST['kommi']));

        //mindestens 1 Zeichen lang
        if (empty($kommi)) {
            $error .= "Geben Sie bitte ein korrektes Kommentar ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte ein Kommentar ein.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {
       // $sql = "SELECT id FROM users WHERE username=";
       // $stmt = $mysqli->prepare($sql);
       // $stmt->bind_param('i', $_SESSION['username']);
       // $stmt->execute();
       // $userid = $stmt->get_result();
        $userid = 1;
        $frageid = 1;
        // Sendet lediglich Query an den Server, welches Platzhalter enthält
        $query = "INSERT INTO kommentar (id, idF, text) VALUES (?); ";

        // Query vorbereiten mit prepare();
        $stmt = $mysqli->prepare($query);

        // Parameter an Query binden mit bind_param() -> Die Parameter werden an Server nachgereicht
        $stmt->bind_param("s", $userid, $frageid, $kommi);

        // query ausführen mit execute();
        $stmt->execute();

        // Verbindung schliessen
        $stmt->close();

        // Weiterleitung
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
            <label for="kommi">Kommentar *</label>
            <input type="text" name="kommi" class="form-control" id="kommi"
                   value="<?php echo $kommi; ?>"
                   placeholder="Geben Sie Ihr Kommentar ein."
                   required="true">
        </div>
        <div>
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