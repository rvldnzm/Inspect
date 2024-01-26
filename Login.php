<!-- PROJECT INSPECT -->
<!-- BY : DINDA DWI SAFITRI, M. HERDIN RIWANTO, RIVALDO NIZAMI -->

<?php
ob_start();
session_start(); // SESSION START
include "Connection.php"; // CONNECT TO DATABASE
$username = '';
$password = '';
if (isset($_POST['Login'])) { // LOGIN PROCESS
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username' AND password = '$password'");
    if (mysqli_num_rows($result) > 0) {
        $qry = mysqli_fetch_array($result);
        $_SESSION['id_user'] = $qry['id_user'];
        $_SESSION['nama'] = $qry['nama'];
        $_SESSION['jabatan'] = $qry['jabatan'];
        $_SESSION['team'] = $qry['team'];
        $_SESSION['level'] = $qry['level'];
        $_SESSION['username'] = $qry['username'];

        header("Location:Dashboard.php");
        exit();
    } else {
        $error = "Please check your Username or Password";
        $pesan = "animation: animate 4s;";
    }
}
?>

<?php
if (isset($_GET["username"])) {
    $username = $_GET["username"];
} else {
    $username = "";
}
if (isset($_GET["password"])) {
    $password = $_GET["password"];
} else {
    $password = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inspect • Login</title>
    <link rel="icon" href="Image/K3.png" />
    <link rel="stylesheet" href="Login.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");
    </style>
    <script>
        // SCRIPT 1
        function preventBack() {
            window.history.forward()
        };
        setTimeout("preventBack()", 0);
        window.onunload = function () { null; }
        // SCRIPT 2
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <div class="Logo">
        <p>Inspect</p>
    </div>
    <div class="Login">
        <div class="Login-Left">
            <div class="Content-Login-Left">
                <p>Welcome to</p>
                <p>INSPECT</p>
                <p>Accidents are not scheduled, but safety can be prepared</p>
            </div>
        </div>
        <div class="Login-Right">
            <div class="Header"></div>
            <div class="Content">
                <div class="Header-Content">
                    <p>Login Account</p>
                    <p>Please Log in using the registered account, if you don't have an account please contact
                        Admin/Helpdesk</p>
                </div>
                <form class="Form" method="POST" autocomplete="off">
                    <div class="Input">
                        <input type="text" name="username" required />
                        <label>Username</label>
                    </div>
                    <div class="Input">
                        <input type="password" name="password" required />
                        <label>Password</label>
                    </div>
                    <p class="Alert" style="<?php echo $pesan; ?>">
                        <i class="bi bi-exclamation-circle-fill"></i>Username atau Password Salah!
                    </p>
                    <button class="Button-Login" name="Login">LOGIN</button>
                </form>
            </div>
            <div class="Footer">
                <p>Inspect &copy 2023. All rights reserved</p>
            </div>
        </div>
    </div>
</body>

</html>