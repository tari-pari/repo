<?php
session_start();
if(!ISSET($_SESSION)){
    header("location:/Projekt/main.php");
}
?>
<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./css/frameset.css">
</head>
<body>
<!-- **** NAVIGATION ******* -->
<div class = "wrapper">
    <section class="top-nav">
        <input id="menu-toggle" type="checkbox" />
        <label class="menu-button-container" for="menu-toggle">
            <div class="menu-button"></div>
        </label>
        <ul class="menu">
            <li>
                <a href = 'configgroup.php'>neuen Kalender erstellen</a>
            </li>
            <li>
                <a href='calender.php'>neuer Kalendereintrag</a>
            </li>
            <li>
                <a href='convert_csv.php'>csv Datei</a>
            </li>
            <li>
                <a href="./impressum.html">Impressum</a>
            </li>
        </ul>
    </section>
    <!-- ***** ENDE NAVBAR -->
    <h1>Shared Calendar</h1>
    <h3>Jemanden zu ihrem Kalender hinzufügen</h3>
<form action="group.php" method="post">
    <ul><li>E-Mail des weiteren Nutzers: <br><input type="text" name="email" required></li>
                    <br><input type="submit" value="verbindlich absenden">
</form>
<?php

?>