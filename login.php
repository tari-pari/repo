<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
            <link rel="stylesheet" href="./css/styles.css">
            <link rel="stylesheet" href="./css/frameset.css">
    </head>
<body>
    <header>
        <div class = "header"><h1>Shared Calendar</h1></div>
    </header>
    <!-- Navigationsbar-->
    <div class="navbar">
        <input id="menu-toggle" type="checkbox" />
        <label class="menu-button-container" for="menu-toggle">
            <div class="menu-button"></div>
        </label>
        <ul class="menu">
            <li>
                <a href = register.php>Registrieren</a>
            </li>
            <li>
                <a href="./impressum.html">Impressum</a>
            </li>
        </ul>
    </div>


    <div class = "container">
        <h3>Login:</h3>
        <form action="login.php" method="post">
        <ul>
            <li><input type="text" name="username" placeholder="Username"></li>
            <li><input type="password" name="passwort" placeholder="Password">
                <input type="submit" value="einloggen"></li></ul>
        </form>
        Sie sind noch nicht registriert? Dann klicken Sie bitte <a href = register.php>hier</a>
    </div>


<?php
$host = "localhost"; 
$user = "root"; 
$pass =""; 
$db="calendar_testing";
/* Verbinden mit Datenbank */
$con = mysqli_connect($host,$user,$pass,$db);
// Verbindung prüfen
if (!$con) {
    die("Datenbankverbindung fehlgeschlagen: " . mysqli_connect_error());
}
if(ISSET($_POST["passwort"])){
    session_start();
    $username = $_POST["username"];
    $pw = $_POST["passwort"];


    //Abfrage Username und passwort vergleich in mysqli
$sql = "SELECT username, passwort FROM user ";
$sql .= "WHERE username = '";
$sql .= $username."';";

    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $existingHashFromDb= $row["passwort"];
        if ($row["username"] == $username && password_verify($pw, $existingHashFromDb)){
            //Login erfolgreich
             header("location:main.php");
        }
        else echo "Falscher username oder Passwort";

    //mit Session User ID abfangen
    $sql =  "Select id, username FROM user ".
            "WHERE username = '".$username."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_row($result);
    $_SESSION["userID"]= $row[0];
    $_SESSION["username"]= $row[1];

}
//session_start();
//session_destroy();
?>
