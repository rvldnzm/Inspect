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

$selectMax = mysqli_query($conn, "SELECT MAX(id_user) as maxId_User FROM tb_users");
$resultMax = mysqli_fetch_array($selectMax);
$maxCode = $resultMax['maxId_User'];
$no = (int) substr($maxCode, -3);
$no++;
$newCode = sprintf("141203%03s", $no);

$time = gmdate("H:i", time() + 7 * 3600); // SET TIME FOR GREETING
$t = explode(":", $time);
$hours = $t[0];
$second = $t[1];
if ($hours >= 00 and $hours < 11) {
    if ($second >= 00 and $second < 60) {
        $Greet = "Good<br>Morning";
    }
} else if ($hours >= 11 and $hours < 18) {
    if ($second >= 00 and $second < 60) {
        $Greet = "Good<br>Afternoon";
    }
} else if ($hours >= 18 and $hours <= 24) {
    if ($second >= 00 and $second < 60) {
        $Greet = "Good<br>Night";
    }
} else {
    $Greet = "Error";
}

if (isset($_POST['Register'])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $team = $_POST['team'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $Insert = mysqli_query($conn, "INSERT INTO tb_users VALUES ('$newCode', '$nama', '$jabatan', '$team', 'Petugas', '$username', '$password')");
    header("Location: Dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inspect • Register</title>
    <link rel="icon" href="Image/K3.png" />
    <link rel="stylesheet" href="Register.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");

        input {
            border: solid 1.5px #ECEDEC;
        }
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
    <div class="Logo">
        <p>Inspect</p>
    </div>
    <div class="Register">
        <div class="Register-Left">
            <div class="Content-Login-Left">
                <p>Hi!
                    <?php echo $_SESSION['nama']; ?>
                </p>
                <p>
                    <?php echo $Greet; ?>
                </p>
                <p>Are there any new officers?</p>
            </div>
        </div>
        <div class="Register-Right">
            <div class="Header"></div>
            <div class="Content">
                <div class="Header-Content">
                    <p>Create Account</p>
                    <p>Please fill in the data listed below according to the official verified officer data. Make sure
                        there are no errors in the data entered</p>
                </div>
                <form class="Form" method="POST" autocomplete="off">
                    <div class="Input">
                        <input type="text" id="namaInput" name="nama" required />
                        <label>Full Name</label>
                    </div>
                    <div class="Input">
                        <input type="text" id="jabatanInput" name="jabatan" required />
                        <label>Job Title</label>
                    </div>
                    <div class="Input">
                        <input type="text" id="teamInput" name="team" required />
                        <label>Team</label>
                    </div>
                    <div class="Input">
                        <input type="text" id="usernameInput" name="username" required />
                        <label>Username</label>
                    </div>
                    <div class="Input">
                        <input type="password" name="password" id="Password" required />
                        <label>Password</label>
                    </div>
                    <p class="AlertPassword">
                        <i class="bi bi-exclamation-circle-fill"></i>Minimum 8 character
                    </p>
                    <button class="registerButton" name="Register">REGISTER</button>
                    <p class="BacktoDashboard">Officer already has an account?<a href="Dashboard.php">Back to
                            Dashboard</a></p>
                </form>
            </div>
            <div class="Footer">
                <p>Inspect &copy 2023. All rights reserved</p>
            </div>
        </div>
    </div>
    <script>
        // SCRIPT FOR UPDATE BORDER COLOR
        var namaInput = document.getElementById('namaInput');
        var jabatanInput = document.getElementById('jabatanInput');
        var teamInput = document.getElementById('teamInput');
        var usernameInput = document.getElementById('usernameInput');
        namaInput.addEventListener("input", function () {
            updateBorderColor(namaInput);
        });
        namaInput.addEventListener("focus", function () {
            console.log("Input focused");
            namaInput.style.borderColor = "#252525";
        });
        jabatanInput.addEventListener("input", function () {
            updateBorderColor(jabatanInput);
        });
        teamInput.addEventListener("input", function () {
            updateBorderColor(teamInput);
        });
        usernameInput.addEventListener("input", function () {
            updateBorderColor(usernameInput);
        });
        function updateBorderColor(input) {
            var inputValue = input.value;
            var inputLength = inputValue.length;
            if (inputLength === 0) {
                input.style.borderColor = "#ECEDEC";
            } else if (inputLength > 0) {
                input.style.borderColor = "#656565";
            }
        }

        // SCRIPT FOR VALIDATE PASSWORD
        var inputPassword = document.getElementById("Password");
        var registerButton = document.querySelector('.registerButton');
        var AlertPassword = document.querySelector('.AlertPassword');
        inputPassword.addEventListener("input", function () {
            var inputValue = inputPassword.value;
            var inputLength = inputValue.length;
            if (inputLength === 0) {
                inputPassword.style.borderColor = "#ECEDEC";
                registerButton.disabled = true;
                AlertPassword.style.opacity = "0";
            } else if (inputLength < 8) {
                inputPassword.style.borderColor = "#DA0605";
                registerButton.disabled = true;
                AlertPassword.style.opacity = "1";
            } else {
                inputPassword.style.borderColor = "#27862A";
                registerButton.disabled = false;
                AlertPassword.style.opacity = "0";
            }
        });
    </script>
</body>

</html>