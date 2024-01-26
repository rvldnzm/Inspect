<?php
date_default_timezone_set('Asia/Jakarta');
$Today = date('Y/m/d');
$LastWeek = date('Y/m/d', strtotime('-1 week', strtotime($Today)));
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Absensi_$LastWeek - $Today.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th class="Nama">Nama</th>
            <th>Job Title</th>
            <th>Team</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "Connection.php";
        $data = mysqli_query($conn, "SELECT * FROM tb_users, tb_absen WHERE tb_users.id_user = tb_absen.id_user AND tb_absen.tanggal BETWEEN '" . $LastWeek . "' AND '" . $Today . "' ORDER BY tanggal DESC, jam DESC");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
            ?>
            <tr>
                <td>
                    <?php echo $no++ ?>
                </td>
                <td class="Nama">
                    <?php echo $d['nama']; ?>
                </td>
                <td>
                    <?php echo $d['jabatan']; ?>
                </td>
                <td>
                    <?php echo $d['team']; ?>
                </td>
                <td>
                    <?php echo $d['tanggal']; ?>
                </td>
                <td>
                    <?php echo $d['jam']; ?>
                </td>
                <td>
                    <?php echo $d['status']; ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>