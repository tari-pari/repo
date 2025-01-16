<?php
session_start();
if(!ISSET($_SESSION)){
    header("location:/Projekt/convert_csv.php");
}
?>
<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
    <link rel="stylesheet" href="./css/styles.css"></head>

<body>
<header></header>
        CSV Datei sollte in Downloads sein

    <?php
$userID = $_SESSION["userID"];
$username = $_SESSION["username"];
$host = "localhost";
$user = "root";
$pass ="";
$db="calendar_testing";
$con = mysqli_connect($host,$user,$pass,$db);

//sql Befehl um die kalender zum user und die dazugehörigen einträge zu finden:
$sql = "SELECT entries.id, title, entries.beschreibung, datum, start_time, end_time, `groups`.group_name, date_created_at FROM entries ".
    "INNER JOIN calender on entries.cal_id = calender.id ".
    "INNER JOIN groups on calender.group_id = groups.id ".
    "INNER JOIN user_groups on groups.id = user_groups.group_id ".
    "INNER JOIN user on user.id=user_groups.user_id ".
    "WHERE user.id = '".$userID."' ORDER BY datum; ";
$result = mysqli_query($con,$sql);

$fh = fopen("C:/Users/IT/Downloads/".$username."-calendar.csv", 'w+');
fwrite($fh, 'title;beschreibung;datum;beginn;ende;name;' . "\n");

while($zeile = mysqli_fetch_assoc($result)) {

    fwrite($fh, $zeile['title'] . ';');
    fwrite($fh, $zeile['beschreibung'] . ';');
    fwrite($fh, $zeile['datum'] . ';');
    fwrite($fh, $zeile['start_time'] . ';');
    fwrite($fh, $zeile['end_time'] . ';');
    fwrite($fh, $zeile['group_name'] . ';');
    fwrite($fh, "\n");
}
    fclose($fh);
header("location:location:/php/Sources/Projekt/main.php");
    ?>