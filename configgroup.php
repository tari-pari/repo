
<!DOCTYPE html><head><meta charset="UTF-8"><title>Shared Calendar</title>
<link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/frameset.css">
</head>

<body>
        <!-- **** NAVIGATION ******* -->
        <div class = "navbar">
            <section class="top-nav">
                <input id="menu-toggle" type="checkbox" />
                <label class="menu-button-container" for="menu-toggle">
                    <div class="menu-button"></div>
                </label>
                <ul class="menu">
                    <li>
                        <a href = 'main.php'>zu vorhanden Kalender</a>
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
            </section> </div>
            <!-- ***** ENDE NAVBAR -->

            <h1>Shared Calendar</h1>

        <!-- ***** Formular neuen Kalender erstellen ******** -->
        <div class = "container">
            <h3>neuen Kalender erstellen</h3>
        <form action="configgroup.php" method="post">
            <ul><li>
                    <input type="text" name="calender" placeholder= "Name Kalender" required>
                </li>
                <li>
                    <input type="text" name="desc" placeholder="Beschreibung">
                    <input type="submit" value="erstellen">
                </li>
            </ul>
</form> </div>

<?php
session_start();
$userID = $_SESSION["userID"];
//Logindaten Datenbank
$host = "localhost"; 
$user = "root"; 
$pass =""; 
$db="calendar_testing";
$con = mysqli_connect($host,$user,$pass,$db); //verbinden mit Datenbank

if(ISSET($_POST["calender"])){
$calender = $_POST["calender"]; 
$caldesc = $_POST["desc"]; 
//mysql Gruppe in Datenbank erstellen
$sql = "INSERT INTO groups(group_name) VALUES ('".$calender."')";
$result = mysqli_query($con,$sql);

//groupID herausbekommen, um Verbindung zum Kalender aufzubauen
    $sql = "SELECT id From groups WHERE group_name = '".$calender."'";
    $result = mysqli_query($con,$sql);
    $group =mysqli_fetch_assoc($result);
    $groupID = $group["id"];

    //Kalender erstellen mit der groupID
    $sql = "INSERT INTO calender(name, beschreibung, group_id) VALUES ('".$calender."', '".$caldesc."',".$groupID.")";
     $result = mysqli_query($con,$sql);
    
    //Tabelle user_groups erstellen
    $sql = "INSERT INTO user_groups(user_id,group_id) VALUES (".$userID.",".$groupID.")";
    $result = mysqli_query($con,$sql);

}

?>

        <!-- ************ User zu Kalender hinzufügen ***************** -->
        <div class = "container">
            <h3>Jemanden zu ihrem Kalender hinzufügen</h3>
            <form action="configgroup.php.php" method="get">
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

        <!-- ***** Formular vorhandenen Kalender löschen ******** -->
        <br><div class = "container">
            <form action="configgroup.php" method="post">
                <ul>
                    <li><label for="group_ID"><h3>vorhandene Kalender löschen:</h3></label><br>
                        <select id="group_ID" name="group_ID"> <!-- select ausgabe der vorhandenen kalender des users -->
                            <?php $sql = "SELECT groups.id, groups.group_name FROM groups ".
                                        "INNER JOIN user_groups on groups.id = user_groups.group_id ".
                                        "INNER JOIN user on user_groups.user_id = user.id ".
                                        "WHERE user.id = '".$userID."'";
                            $result = mysqli_query($con,$sql);
                            while ($tmp = mysqli_fetch_assoc($result)){
                                print '<option value="'. $tmp['id'] .'">' . $tmp['group_name'] . '</option>';
                            }
                            ?>
                        </select>
                    <input type="submit" value="löschen"></li>
                    <li class="info">Bitte denken Sie daran, der Kalender wird für ALLE User gelöscht</li>
                </ul>
            </form>
        </div>


<?php
if(ISSET($_POST["group_ID"])) {
    $groupID = $_POST["group_ID"];
    $sql = "DELETE FROM user_groups WHERE `user_groups`.`group_id` = '".$groupID."'";
    $result = mysqli_query($con, $sql);
}
