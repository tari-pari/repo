
    <!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
    <link rel="stylesheet" href="./css/styles.css">
        <link rel="stylesheet" href="./css/frameset.css"></head>
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
            <a href='login.php'>Login</a>
        </li>
        <li>
            <a href="./impressum.html">Impressum</a>
        </li>
    </ul>
</div>




<div class = "container">
    <h3>Registrieren:</h3>
    <form action="register.php" method="post">
        <ul>
        <li><label for="anrede">Anrede:</label>
            <select id="anrede" name="anrede">
            <option value="Frau">Frau</option>
            <option value="Herr">Herr</option>
            <option value="divers">Divers</option>
        </select></li>
            <li>Vorname: <br><input type="text" name="vorname" placeholder= "Vorname" required></li>
             <li> Name: <br><input type="text" name="name" placeholder= "Nachname" required></li>
            <li>E-Mail: <br><input type="text" name="mail" placeholder= "E-Mail" required></li>
            <li>Username: <br><input type="text" name="username" placeholder= "Username" required></li>
            <li>Passwort: <br><input type="password" name="passwort" placeholder= "Passwort" required minlength="4"></li>
        <br><input type="submit" value="Registrieren" required></li>
    </ul>
    </form>
</div>

<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "calendar_testing";

if(ISSET($_POST["passwort"])) {
    $anrede = $_POST["anrede"];
    $username = $_POST["username"];
    $pw = $_POST["passwort"];
    $hash_pw = password_hash($pw, PASSWORD_DEFAULT);
    $name = $_POST["name"];
    $vorname = $_POST["vorname"];
    $mail = $_POST["mail"];
    /* verbinden mysql in php */
    $con = mysqli_connect($host, $user, $pass, $db);
    //eingabe in mysql
    $sql = "INSERT INTO `user` (anrede, vorname, nachname, passwort, username, email)".
           "VALUES ('".$anrede."','".$vorname."', '".$name."', '".$hash_pw."', '".$username."', '".$mail."')" ;
    $result = mysqli_query($con,$sql);

    header("location:/Projekt/login.php");

}
    ?>