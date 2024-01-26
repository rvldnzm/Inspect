<!-- PROJECT INSPECT -->
<!-- CREATED BY : DINDA DWI SAFITRI, M. HERDIN RIWANTO, RIVALDO NIZAMI -->

<?php
include "Connection.php"; // CONNECT TO DATABASE
session_start(); // START SESSION
$name = $_SESSION['nama'];
$id_user = $_SESSION['id_user'];
$jabatan = $_SESSION['jabatan'];
$team = $_SESSION['team'];
$level = $_SESSION['level'];

$query = mysqli_query($conn, "SELECT * FROM tb_users WHERE nama = '$name'"); // SET FOR ACCESS BUTTON
$q1 = mysqli_fetch_array($query);
if ($q1['level'] == "Admin") {
    $nav = "display: flex;";
} else if ($q1['level'] == "Petugas") {
    $nav = "display: none;";
}

$time = gmdate("H:i", time() + 7 * 3600); // SET TIME FOR GREETING
$t = explode(":", $time);
$hours = $t[0];
$second = $t[1];
if ($hours >= 00 and $hours < 11) {
    if ($second >= 00 and $second < 60) {
        $greet = "Good Morning";
    }
} else if ($hours >= 11 and $hours < 18) {
    if ($second >= 00 and $second < 60) {
        $greet = "Good Afternoon";
    }
} else if ($hours >= 18 and $hours <= 24) {
    if ($second >= 00 and $second < 60) {
        $greet = "Good Night";
    }
} else {
    $greet = "Error";
}

// MATH VARIABLE LOGICAL
$Query1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_users WHERE level = 'Petugas'"));
$Query2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE tanggal = CURDATE() AND status = 'Hadir'"));
$Query3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE tanggal = CURDATE() AND status = 'Sakit'"));
$Query4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE tanggal = CURDATE() AND status = 'Izin'"));
$Query5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE tanggal = CURDATE() AND status = 'Alpa'"));
$Query6 = $Query3 + $Query4 + $Query5;

$QueryHelm = mysqli_num_rows(mysqli_query($conn, "SELECT helm FROM tb_apd"));
$QueryHelmYes = mysqli_num_rows(mysqli_query($conn, "SELECT helm FROM tb_apd WHERE helm = 'Yes'"));
$PercentageHelm = number_format(($QueryHelmYes / $QueryHelm) * 100, 1) . '%';

$QueryEyeglass = mysqli_num_rows(mysqli_query($conn, "SELECT kacamata FROM tb_apd"));
$QueryEyeglassYes = mysqli_num_rows(mysqli_query($conn, "SELECT kacamata FROM tb_apd WHERE kacamata = 'Yes'"));
$PercentageEyeglass = number_format(($QueryEyeglassYes / $QueryEyeglass) * 100, 1) . '%';

$QueryGloves = mysqli_num_rows(mysqli_query($conn, "SELECT sarung_tangan FROM tb_apd"));
$QueryGlovesYes = mysqli_num_rows(mysqli_query($conn, "SELECT sarung_tangan FROM tb_apd WHERE sarung_tangan = 'Yes'"));
$PercentageGloves = number_format(($QueryGlovesYes / $QueryGloves) * 100, 1) . '%';

$QueryCard = mysqli_num_rows(mysqli_query($conn, "SELECT id_card FROM tb_apd"));
$QueryCardYes = mysqli_num_rows(mysqli_query($conn, "SELECT id_card FROM tb_apd WHERE id_card = 'Yes'"));
$PercentageCard = number_format(($QueryCardYes / $QueryCard) * 100, 1) . '%';

$QueryVest = mysqli_num_rows(mysqli_query($conn, "SELECT rompi FROM tb_apd"));
$QueryVestYes = mysqli_num_rows(mysqli_query($conn, "SELECT rompi FROM tb_apd WHERE rompi = 'Yes'"));
$PercentageVest = number_format(($QueryVestYes / $QueryVest) * 100, 1) . '%';

$QueryHarness = mysqli_num_rows(mysqli_query($conn, "SELECT body_harness FROM tb_apd"));
$QueryHarnessYes = mysqli_num_rows(mysqli_query($conn, "SELECT body_harness FROM tb_apd WHERE body_harness = 'Yes'"));
$PercentageHarness = number_format(($QueryHarnessYes / $QueryHarness) * 100, 1) . '%';

$QueryBoots = mysqli_num_rows(mysqli_query($conn, "SELECT sepatu FROM tb_apd"));
$QueryBootsYes = mysqli_num_rows(mysqli_query($conn, "SELECT sepatu FROM tb_apd WHERE sepatu = 'Yes'"));
$PercentageBoots = number_format(($QueryBootsYes / $QueryBoots) * 100, 1) . '%';

$Equipment = $QueryHelm + $QueryEyeglass + $QueryGloves + $QueryCard + $QueryVest + $QueryHarness + $QueryBoots;
$EquipmentYes = $QueryHelmYes + $QueryEyeglassYes + $QueryGlovesYes + $QueryCardYes + $QueryVestYes + $QueryHarnessYes + $QueryBootsYes;
$PercentageEquipment = number_format(($EquipmentYes / $Equipment) * 100, 1) . '%';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inspect • Dashboard</title>
    <link rel="icon" href="Image/K3.png" />
    <link rel="stylesheet" href="Dashboard.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");
    </style>
    <script>
        function preventBack() {
            window.history.forward()
        };
        setTimeout("preventBack()", 0);
        window.onunload = function () { null; }
    </script>
</head>

<body>
    <div class="Header">
        <div class="Navbar">
            <div class="Navbar-Left">
                <p>Inspect</p>
            </div>
            <div class="Navbar-Right">
                <a href="Dashboard.php" class="Active">
                    <div class="Line" id="Active"></div>Dashboard
                </a>
                <a href="Attendance.php">
                    <div class="Line"></div>Attendance
                </a>
                <a href="Equipment.php">
                    <div class="Line"></div>Equipment
                </a>
                <a href="Request.php" style="<?php echo $nav; ?>">
                    <div class="Line"></div>Request
                </a>
                <a href="Logout.php">Logout</a>
            </div>
            <div class="Dropdown">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>

    <div class="Dashboard">
        <div class="Courses">
            <div class="Header-Courses">
                <div class="Greet">
                    <p>Hello,
                        <?php echo $_SESSION['nama']; ?>
                    </p>
                    <p>
                        <?php echo $greet; ?>
                    </p>
                </div>
                <div class="Register">
                    <a href="Register.php" style="<?php echo $nav; ?>">+&nbsp Add Employee</a>
                </div>
            </div>
            <div class="Content-Courses">
                <div class="Card-Courses">
                    <div class="Content-Card">
                        <p>
                            <?php echo $Query1; ?>
                        </p>
                        <p>Total Employee</p>
                    </div>
                    <div class="Icon-Card">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="Card-Courses">
                    <div class="Content-Card">
                        <p>
                            <?php echo $Query2; ?>
                        </p>
                        <p>Attendance Today</p>
                    </div>
                    <div class="Icon-Card">
                        <i class="bi bi-clipboard2-check-fill"></i>
                    </div>
                </div>
                <div class="Card-Courses">
                    <div class="Content-Card">
                        <p>
                            <?php echo $Query6; ?>
                        </p>
                        <p>Absent Today</p>
                    </div>
                    <div class="Icon-Card">
                        <i class="bi bi-clipboard2-x-fill"></i>
                    </div>
                </div>
                <div class="Card-Courses">
                    <div class="Content-Card">
                        <p>
                            <?php echo $PercentageEquipment; ?>
                        </p>
                        <p>Equipment Completeness</p>
                    </div>
                    <div class="Icon-Card">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="Statistic">
            <div class="Barchart">
                <div class="Header-Barchart">
                    <p>Equipment Overview</p>
                    <a href="ExcelApd.php">
                        <i class="bi bi-printer-fill"></i>
                        <p>Export</p>
                    </a>
                </div>
                <div class="Line1"></div>
                <div class="Content-Barchart">
                    <div class="Content-Barchart-Left">
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageHelm; ?>"></div>
                            </div>
                            <p>HELMET</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageEyeglass; ?>"></div>
                            </div>
                            <p>EYEGLASS</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageGloves; ?>"></div>
                            </div>
                            <p>GLOVES</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageCard; ?>"></div>
                            </div>
                            <p>CARD</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageVest; ?>"></div>
                            </div>
                            <p>VEST</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageHarness; ?>"></div>
                            </div>
                            <p>HARNESS</p>
                        </div>
                        <div class="Wrapper-Bar">
                            <div class="Background-Bar">
                                <div class="Bar" style="height: <?php echo $PercentageBoots; ?>"></div>
                            </div>
                            <p>BOOTS</p>
                        </div>
                    </div>
                    <div class="Content-Barchart-Right">
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Helmet</p>
                            </div>
                            <p>
                                <?php echo $PercentageHelm; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Eyeglass</p>
                            </div>
                            <p>
                                <?php echo $PercentageEyeglass; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Gloves</p>
                            </div>
                            <p>
                                <?php echo $PercentageGloves; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Id Card</p>
                            </div>
                            <p>
                                <?php echo $PercentageCard; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Vest</p>
                            </div>
                            <p>
                                <?php echo $PercentageVest; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Body Harness</p>
                            </div>
                            <p>
                                <?php echo $PercentageHarness; ?>
                            </p>
                        </div>
                        <div class="Box-Info">
                            <div class="Mark">
                                <div class="Line"></div>
                                <p>Boots</p>
                            </div>
                            <p>
                                <?php echo $PercentageBoots; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Recent">
                <div class="Header-Recent">
                    <p>Today Activity</p>
                </div>
                <div class="Line1"></div>
                <div class="Content-Recent">
                    <?php
                    include "Connection.php";
                    $currentTime = date("H:i:s");
                    $startTime = "00:00:00";
                    $endTime = "23:59:00";

                    $Recent1 = mysqli_query($conn, "SELECT tb_users.nama, tb_users.jabatan, tb_absen.jam, tb_absen.keterangan 
                        FROM tb_users 
                        INNER JOIN tb_absen ON tb_users.id_user = tb_absen.id_user 
                        WHERE tb_absen.tanggal = CURDATE() AND tb_absen.jam BETWEEN '$startTime' AND '$endTime'
                        ORDER BY tb_absen.jam DESC");

                    $Recent2 = mysqli_query($conn, "SELECT tb_users.nama, tb_users.jabatan, tb_apd.jam, tb_apd.keterangan 
                        FROM tb_users 
                        INNER JOIN tb_apd ON tb_users.id_user = tb_apd.id_user 
                        WHERE tb_apd.tanggal = CURDATE() AND tb_apd.jam BETWEEN '$startTime' AND '$endTime'
                        ORDER BY tb_apd.jam DESC");

                    $result = array();

                    while ($Print = mysqli_fetch_assoc($Recent1)) {
                        $Print['activity'] = "Attendance";
                        if ($Print > 0) {
                            $Display = "display: none;";
                        } else {
                            $Display = "display: flex;";
                        }

                        if ($Print['keterangan'] == 'Belum Validasi') {
                            $Print['color'] = "color: #A26840; background-color: #F9C7A4;";
                            $Print['status'] = "Pending";
                        } else if ($Print['keterangan'] == 'Sudah Validasi') {
                            $Print['color'] = "color: #60A578; background-color: #D4EADE;";
                            $Print['status'] = "Valid";
                        } else if ($Print['keterangan'] == 'Tidak Validasi') {
                            $Print['color'] = "color: #92344C; background-color: #FFC3CF;";
                            $Print['status'] = "Invalid";
                        }

                        $result[] = $Print;
                    }

                    while ($Print = mysqli_fetch_assoc($Recent2)) {
                        $Print['activity'] = "Equipment";
                        if ($Print > 0) {
                            $Display = "display: none;";
                        } else {
                            $Display = "display: flex;";
                        }
                        if ($Print['keterangan'] == 'Belum Validasi') {
                            $Print['color'] = "color: #A26840; background-color: #F9C7A4;";
                            $Print['status'] = "Pending";
                        } else if ($Print['keterangan'] == 'Sudah Validasi') {
                            $Print['color'] = "color: #60A578; background-color: #D4EADE;";
                            $Print['status'] = "Valid";
                        } else if ($Print['keterangan'] == 'Tidak Validasi') {
                            $Print['color'] = "color: #92344C; background-color: #FFC3CF;";
                            $Print['status'] = "Invalid";
                        }
                        $result[] = $Print;
                    }

                    usort($result, function ($a, $b) {
                        return strtotime($b['jam']) - strtotime($a['jam']);
                    });

                    foreach ($result as $Print) {
                        ?>
                        <div class="Box-Recent">
                            <div class="Info-User">
                                <p>
                                    <?php echo $Print['nama']; ?>
                                </p>
                                <p>
                                    <?php echo $Print['jabatan']; ?>
                                </p>
                            </div>
                            <div class="Activity">
                                <p>
                                    <?php echo $Print['activity']; ?>
                                </p>
                                <p>
                                    <?php echo date("H.i A", strtotime($Print['jam'])); ?>
                                </p>
                                <p style="<?php echo $Print['color']; ?>">
                                    <?php echo $Print['status']; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <p class="Nothing" style="<?php echo $Display; ?>">There is no activity today</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        Dropdown = document.querySelector(".Dropdown");
        NavbarRight = document.querySelector(".Navbar-Right");
        Dropdown.onclick = function () {
            NavbarRight.classList.toggle("Active");
            Dropdown.classList.toggle("Active");
        };
    </script>
</body>

</html>