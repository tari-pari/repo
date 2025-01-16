<?php
session_start();
if(!ISSET($_SESSION)){
    header("location:/Projekt/AddUser.php");}
    $userID = $_SESSION["userID"];
    $host = "localhost";
    $user = "root";
    $pass ="";
    $db="calendar_testing";
    $con = mysqli_connect($host,$user,$pass,$db);
    error_reporting(0);
?>
    <!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/frameset.css"></head>
    <div>
<!-- **** NAVIGATION ******* -->
<div class = "navbar">
    <section class="top-nav">
        <input id="menu-toggle" type="checkbox" />
        <label class="menu-button-container" for="menu-toggle">
            <div class="menu-button"></div>
        </label>
        <ul class="menu">
            <li>
                <a href = 'configgroup.php'>Kalender bearbeiten</a>
            </li>
            <li>
                <a href='calender.php'>neuer Kalendereintrag</a>
            </li>
            <li>
                <a href='convert_csv.php'>csv Datei</a>
            </li>
            <li>
                <a href = 'main.php'>Ihre Kalendereinträge</a>
            </li>
        </ul>
    </section></div>
    <!-- ***** ENDE NAVBAR -->

    <h1>Shared Calendar</h1>
<!-- ************ User zu Kalender hinzufügen ***************** -->
<div class = "container">
<h3>Jemanden zu ihrem Kalender hinzufügen</h3>
<form action="AddUser.php" method="get">
    <ul>     <li><label for="CalendarName">Kalender:</label>
            <select id="cal_name" name="cal_name"> <!-- select ausgabe der vorhandenen kalender des users -->
                <?php $sql = "select groups.id, groups.group_name from groups ".
                    "JOIN user_groups on groups.id = user_groups.group_id WHERE user_groups.user_id = '".$userID."'";
                    $result = mysqli_query($con,$sql);
                while ($tmp = mysqli_fetch_assoc($result)){
                    print '<option value="'. $tmp['id'] .'">' . $tmp['group_name'] . '</option>';
                }
                ?>
            </select></li>
        <li>E-Mail des weiteren Nutzers: <br><input type="text" name="email"></li>
        <br><input type="submit" value="verbindlich absenden">
</form> </div>
<?php

if(ISSET($_GET["cal_name"])) {
    $calendarName = $_GET["cal_name"];

    $mail = $_GET["email"];

    $sql = "SELECT user.id FROM user WHERE email = '".$mail."' ";
    $result = mysqli_query($con,$sql);
    $getID = mysqli_fetch_assoc($result);
    $userID2 = $getID["id"];

    $sql = "INSERT INTO user_groups (user_ID, group_id) VALUES ('".$userID2."','".$calendarName."')";
    $result = mysqli_query($con,$sql);
    if($result== 'true'){
        echo "<br>erfolgreich hinzugefügt!<br>";
    }
    else {echo "<br>User mit dieser E-Mail existiert nicht";}
}
?>