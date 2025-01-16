<?php
session_start();
if(!ISSET($_SESSION)){
    header("location:/Projekt/login.php");
}
?>
<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
<link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/frameset.css"></head>

<body>
 <!-- **** NAVIGATION ******* -->
 <div class="navbar">
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
                        <a href = 'main.php'>Zu Ihren Kalendereinträgen</a>
                    </li>
                    <li>
                        <a href='convert_csv.php'>csv Datei</a>
                    </li>
                    <li>
                        <a href="./impressum.html">Impressum</a>
                    </li>
                </ul>
            </section></div>
            <!-- ***** ENDE NAVBAR -->
            <h1>Shared Calendar</h1>
            <?php


//einloggen Datenbank
$host = "localhost";
$user = "root";
$pass ="";
$db="calendar_testing";
$con = mysqli_connect($host,$user,$pass,$db);

$userID = $_SESSION["userID"];
$sql = "SELECT anrede, vorname, nachname from user ".
        "WHERE id = '".$userID."'";
$result = mysqli_query($con,$sql); 
echo "<ul><li>Hallo ";
$temp = mysqli_fetch_assoc($result);
foreach($temp as $value){
        if($value != "divers"){
        echo  "<td>$value </td>";} 
    }
            //heutiges Datum:
            echo "<li>heutiges Datum: ";
            $datum=mktime(0,0,0,date("m"),date("d"),date("Y"));
            echo date("d.m.Y", $datum);
            echo "<li>Kalenderwoche: ".date("W");
            ?>

 <div class = "container">
        <br>Neuen Termin anlegen:
            <form action="calender.php" method="post">
                <ul>
                    <li><label for="cal_ID">Kalender:</label><br>
                        <select id="cal_ID" name="cal_ID"> <!-- select ausgabe der vorhandenen kalender des users -->
                            <?php $sql = "SELECT calender.id, name from calender ".
                                    "Inner join groups on calender.group_id=groups.id ".
                                    "INNER JOIN user_groups on groups.id = user_groups.group_id ".
                                    "INNER JOIN user on user_groups.user_id = user.id ".
                                    "where user.id = ".$userID;;
                            $result = mysqli_query($con,$sql);
                            while ($tmp = mysqli_fetch_assoc($result)){
                                print '<option value="'. $tmp['id'] .'">' . $tmp['name'] . '</option>';
                            }
                            ?>
                        </select></li>
                    <li>Datum: <br><input type="date" name="datum" required></li>
                    <li>Uhrzeit beginn: <br><input type="time" name="start_time" required></li>
                    <li>Uhrzeit ende: <br><input type="time" name="end_time"></li>
                    <li> Titel: <br><input type="text" name="titel" required></li>
                    <li>Beschreibung: <br><input type="text" name="desc" required></li>
                    <br><input type="submit" value="anlegen" required></li>
                </ul>
            </form></div>
<?php

if(ISSET($_POST["desc"])) {
    $calID = $_POST["cal_ID"];
    $date = $_POST["datum"]; //datum eintrag
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $title = $_POST["titel"]; //titel eintrag
    $desc = $_POST["desc"];   //Beschreibung eintrag

    $sql = "INSERT INTO entries(cal_id, title, beschreibung, datum, start_time, end_time) VALUES ('".$calID."', '".$title."', '".$desc."', '".$date."', '".$start_time."', '".$end_time."')";
    $result = mysqli_query($con,$sql);
}
?>


</body>