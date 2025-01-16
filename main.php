<?php
        session_start();
        if(!ISSET($_SESSION)){
            header("location:/Projekt/login.php");
        }
//einloggen Datenbank
$host = "localhost";
$user = "root";
$pass ="";
$db="calendar_testing";
$con = mysqli_connect($host,$user,$pass,$db);
$userID = $_SESSION["userID"];
$username = $_SESSION["username"];
        ?>
<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
                <link rel="stylesheet" href="./css/styles.css">
                <link rel="stylesheet" href="./css/frameset.css">
            </head>

<body>
    <header>
       <div class = "header"><h1>Ihr Kalender</h1></div>
    </header>

    <!-- Navigationsbar-->
    <div class="navbar">
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
                <a href="./impressum.html">Impressum</a>
            </li>
            <li>
                <a href='logOut.php'>Log Out</a>
            </li>
        </ul>
    </div>


    <h2>Willkommen</h2>

    <div class = "flexbox welcome">
        <ul>
            <li>Willkommen</li>
            <li> <?php //über session User ID Anrede und Name raussuchen
                $sql = "SELECT anrede, vorname, nachname from user " .
                    "WHERE id = '" . $userID . "'";
                $result = mysqli_query($con, $sql);
                $temp = mysqli_fetch_assoc($result);
                foreach($temp as $value){
                    if($value != "divers"){
                        echo "$value ";} }?>
            </li>
            <?php
            //heutiges Datum und Kalenderwoche
            echo "<li>heutiges Datum: ";
            $datum=mktime(0,0,0,date("m"),date("d"),date("Y"));
            echo date("d.m.Y", $datum);
            echo "<li>aktuelle Kalenderwoche: ".date("W")." KW </li>";
            ?>
        </ul>
    </div>

        <table class = "cal">
            <tr>
                <th colspan="6">Ihre Termine</th>
            </tr>
    <tr>
    <th>Titel</th>
    <th>Beschreibung</th>
    <th>Datum</th>
    <th>Uhrzeit</th>
    <th>Name Kalender</th>
        <th></th>
    </tr>
    <!-- Alle Termine des Kalenders anzeigen lassen -->
    <?php
        //sql Befehl um die kalender zum user und die dazugehörigen einträge zu finden:
    $sql = "SELECT entries.id, title, entries.beschreibung, datum, start_time, end_time, `groups`.group_name, date_created_at FROM entries ".
    "INNER JOIN calender on entries.cal_id = calender.id ".
    "INNER JOIN groups on calender.group_id = groups.id ".
    "INNER JOIN user_groups on groups.id = user_groups.group_id ".
    "INNER JOIN user on user.id=user_groups.user_id ".
    "WHERE user.id = '".$userID."' ORDER BY datum; ";
    $result = mysqli_query($con,$sql);

    while($zeile = mysqli_fetch_assoc($result)) {
         $datum = date("d.m.Y", strtotime($zeile['datum']));

         ?>
         <tr>
             <td><?= $zeile['title'] ?></td>
             <td><?= $zeile['beschreibung'] ?></td>
             <td><?= $datum ?></td>
             <td><?= substr($zeile['start_time'], 0, 5) ?> - <?= substr($zeile['end_time'], 0, 5) ?> </td>
             <td><?= $zeile['group_name'] ?></td>
             <td>
                 <span style="font-size: 18px; color: #1a1717">
                    <a href="http://localhost/php/Sources/Projekt/main.php?cal_delete=<?= $zeile['id'] ?>">
                         <?="\u{1F5D1}" ?>
                    </a>
                </span>
             </td>
         </tr>
<?php
     } ?>
</table>
</div>


<?php
//sql Befehl um Kalendereintrag zu löschen, anhand Titel
if(ISSET($_GET["cal_delete"])) {
    $entry_ID = $_GET["cal_delete"];
    $sql = "DELETE from entries WHERE entries.id = '".$entry_ID."'";
    $result = mysqli_query($con,$sql);
    header("Refresh:1; main.php");
} ?>

</body>