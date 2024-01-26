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

$search_level1 = mysqli_query($conn, "SELECT * FROM tb_users WHERE nama = '$name'"); // SET FOR ACCESS BUTTON
$q1 = mysqli_fetch_array($search_level1);
if ($q1['level'] == "Admin") {
    $nav = "display: flex;";
    $Form = "display: none;";
    $Width = "width: 100%;";
} else if ($q1['level'] == "Petugas") {
    $nav = "display: none;";
    $Form = "display: block;";
    $Width = "width: 75%;";
}

$search_attendance = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE id_user = '$id_user' AND tanggal = CURDATE()"));
if ($search_attendance > 0) {
    $Limit = "display: none;";
} else {
    $Limit = "display: flex;";
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

$Query1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE tanggal = CURDATE() AND status = 'Hadir' AND keterangan = 'Sudah Validasi'"));
$Query2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE keterangan = 'Sudah Validasi'"));
$Query3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE keterangan = 'Tidak Validasi'"));
$Query4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen WHERE keterangan = 'Belum Validasi'"));
$Query5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_users WHERE level = 'Petugas'"));
$Query6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_absen"));

$PercentageHadir = number_format(($Query1 / $Query5) * 100, 1);
$PercentageValid = number_format(($Query2 / $Query6) * 100, 1);
$PercentageInvalid = number_format(($Query3 / $Query6) * 100, 1);
$PercentagePending = number_format(($Query4 / $Query6) * 100, 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inspect • Attendance</title>
    <link rel="icon" href="Image/K3.png" />
    <link rel="stylesheet" href="Attendance.css?v=<?php echo time(); ?>" />
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
                <a href="Dashboard.php">
                    <div class="Line"></div>Dashboard
                </a>
                <a href="Attendance.php" class="Active">
                    <div class="Line" id="Active"></div>Attendance
                </a>
                <a href="Equipment.php">
                    <div class="Line"></div>Equipment
                </a>
                <a href="Request.php" style="<?php echo $nav; ?>">
                    <div class="Line"></div>Request
                </a>
                <a href="Logout.php" class="Logout">Logout</a>
            </div>
            <div class="Dropdown">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>

    <div class="Attendance">
        <div class="Courses">
            <div class="Header-Courses">
                <div class="Greet">
                    <p>How are you?</p>
                    <p>
                        <?php echo $_SESSION['nama']; ?>
                    </p>
                </div>
            </div>
            <div id="jam"></div>
            <div class="Content-Courses">
                <div class="Card-Courses">
                    <div class="Header-Card">
                        <p>Present Today</p>
                        <p>
                            <?php echo $PercentageHadir; ?>%
                        </p>
                    </div>
                    <p>
                        <?php echo $Query1; ?>
                    </p>
                </div>
                <div class="Card-Courses">
                    <div class="Header-Card">
                        <p>Attendance Valid</p>
                        <p>
                            <?php echo $PercentageValid; ?>%
                        </p>
                    </div>
                    <p>
                        <?php echo $Query2; ?>
                    </p>
                </div>
                <div class="Card-Courses">
                    <div class="Header-Card">
                        <p>Attendance Invalid</p>
                        <p>
                            <?php echo $PercentageInvalid; ?>%
                        </p>
                    </div>
                    <p>
                        <?php echo $Query3; ?>
                    </p>
                </div>
                <div class="Card-Courses">
                    <div class="Header-Card">
                        <p>Attendance Pending</p>
                        <p>
                            <?php echo $PercentagePending; ?>%
                        </p>
                    </div>
                    <p>
                        <?php echo $Query4; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="Attendance-List">
            <form method="POST" class="Form" style="<?php echo $Form; ?>">
                <div class="Header-Form">
                    <p>Attendance</p>
                </div>
                <div class="Line-Form"></div>
                <div class="Content-Form">
                    <div class="Input">
                        <input type="text" name="nama" value="<?php echo $name; ?>" disabled />
                        <label>Full Name</label>
                    </div>
                    <div class="Input">
                        <input type="text" name="jabatan" value="<?php echo $jabatan; ?>" disabled />
                        <label>Job Title</label>
                    </div>
                    <div class="Input">
                        <input type="text" name="team" value="<?php echo $team; ?>" disabled />
                        <label>Team</label>
                    </div>
                    <div class="Choice-Chips-Group" style="<?php echo $Limit; ?>">
                        <div class="Choice-Chip">
                            <input type="radio" id="Present" name="Choice" value="Hadir">
                            <label for="Present">
                                <p>Present</p>
                            </label>
                        </div>
                        <div class="Choice-Chip">
                            <input type="radio" id="Sick" name="Choice" value="Sakit">
                            <label for="Sick">
                                <p>Sick</p>
                            </label>
                        </div>
                        <div class="Choice-Chip">
                            <input type="radio" id="Permission" name="Choice" value="Izin">
                            <label for="Permission">
                                <p>Permission</p>
                            </label>
                        </div>
                    </div>
                    <p class="Alert" style="display: none;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Please select your attendance status
                    </p>
                    <button class="ButtonAttendance" type="submit" name="Attendance">SUBMIT</button>
                </div>
            </form>
            <?php
            include "Connection.php";
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y/m/d");
            $jam = date("H:i:s");
            $id_user = $_SESSION['id_user'];
            $selectMax = mysqli_query($conn, "SELECT MAX(id_absen) as maxId_Absen FROM tb_absen");
            $resultMax = mysqli_fetch_array($selectMax);
            $maxCode = $resultMax['maxId_Absen'];
            $no = (int) substr($maxCode, -3);
            $no++;
            $newCode = sprintf("215%03s", $no);
            if (isset($_POST['Attendance'])) {
                $Status = $_POST['Choice'];
                $Insert = mysqli_query($conn, "INSERT INTO tb_absen (id_absen, id_user, tanggal, jam, status, keterangan) 
            VALUES ('$newCode', '$id_user', '$tanggal', '$jam', '$Status', 'Belum Validasi')");
            }
            ?>
            <div class="Table-Attendance" style="<?php echo $Width; ?>">
                <div class="Header-Table-Attendance">
                    <p>Weekkly Attendance</p>
                    <a href=" ExcelAbsen.php">
                        <i class="bi bi-printer-fill"></i>
                        <p>Export</p>
                    </a>
                </div>
                <div class="Line-Table-Attendance"></div>
                <div class="Content-Table-Attendance">
                    <?php
                    include "Connection.php";
                    date_default_timezone_set('Asia/Jakarta');
                    $Today = date('Y-m-d');
                    $LastWeek = date('Y-m-d', strtotime('-1 week', strtotime($Today)));
                    $SQL = mysqli_query($conn, "SELECT * FROM tb_users, tb_absen WHERE tb_users.id_user = tb_absen.id_user AND tb_absen.tanggal BETWEEN '" . $LastWeek . "' AND '" . $Today . "' ORDER BY tanggal DESC, jam DESC");
                    $No = 1;
                    while ($Print = mysqli_fetch_array($SQL)) {
                        if ($Print['keterangan'] == 'Belum Validasi') {
                            $Color = "color: #A26840; background-color: #F9C7A4;";
                            $Status = "Pending";
                        } else if ($Print['keterangan'] == 'Sudah Validasi') {
                            $Color = "color: #60A578; background-color: #D4EADE;";
                            $Status = "Valid";
                        } else if ($Print['keterangan'] == 'Tidak Validasi') {
                            $Color = "color: #92344C; background-color: #FFC3CF;";
                            $Status = "Invalid";
                        }
                        ?>
                        <div class="Box-Attendance">
                            <div class="Left">
                                <p class="No">
                                    <?php echo $No; ?>
                                </p>
                                <p class="Lines">|</p>
                                <div class="Info-User">
                                    <p>
                                        <?php echo $Print['nama']; ?>
                                    </p>
                                    <p>
                                        <?php echo $Print['jabatan']; ?> |
                                        <?php echo $Print['team']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="Right">
                                <p>
                                    <?php echo date("M, d", strtotime($Print['tanggal'])); ?>
                                </p>
                                <p class="Lines">|</p>
                                <p>
                                    <?php echo date("H.i A", strtotime($Print['jam'])); ?>
                                </p>
                                <p class="Lines">|</p>
                                <p>
                                    <?php echo $Print['status']; ?>
                                </p>
                                <p class="Lines">|</p>
                                <p style="<?php echo $Color; ?>">
                                    <?php echo $Status; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                        $No++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // SCRIPT FOR RESPONSIVE
        Dropdown = document.querySelector(".Dropdown");
        NavbarRight = document.querySelector(".Navbar-Right");
        Dropdown.onclick = function () {
            NavbarRight.classList.toggle("Active");
            Dropdown.classList.toggle("Active");
        };

        // SCRIPT FOR BUTTON ATTENDANCE
        const radioButtons = document.querySelectorAll('input[name="Choice"]');
        const submitButton = document.querySelector('.ButtonAttendance');
        const alertMessage = document.querySelector('.Alert');

        submitButton.addEventListener('click', function (event) {
            let isSelected = false;
            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    isSelected = true;
                }
            });
            if (!isSelected) {
                event.preventDefault();
                alertMessage.style.display = "flex";
            } else {
                alertMessage.style.display = "none";
            }
        });
        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('change', function () {
                alertMessage.style.display = "none";
            });
        });
    </script>
</body>

</html>