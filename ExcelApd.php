<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal = date("d/m/Y");
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=APD_UPDATE_$tanggal.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Id User</th>
            <th class="Nama">Nama</th>
            <th>Job Title</th>
            <th>Tanggal</th>
            <th>Helm</th>
            <th>Kacamata</th>
            <th>Sarung Tangan</th>
            <th>Id Card</th>
            <th>Rompi</th>
            <th>Body Harness</th>
            <th>Sepatu</th>
            <th>Keterangan</th>
            <th>Alasan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "Connection.php";
        $data = mysqli_query($conn, "SELECT * FROM tb_users, tb_apd WHERE tb_users.id_user = tb_apd.id_user");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
            ?>
            <tr>
                <td>
                    <?php echo $no++ ?>
                </td>
                <td>
                    <?php echo $d['id_user']; ?>
                </td>
                <td class="Nama">
                    <?php echo $d['nama']; ?>
                </td>
                <td>
                    <?php echo $d['jabatan']; ?>
                </td>
                <td>
                    <?php echo $d['tanggal']; ?>
                </td>
                <td>
                    <?php echo $d['helm']; ?>
                </td>
                <td>
                    <?php echo $d['kacamata']; ?>
                </td>
                <td>
                    <?php echo $d['sarung_tangan']; ?>
                </td>
                <td>
                    <?php echo $d['id_card']; ?>
                </td>
                <td>
                    <?php echo $d['rompi']; ?>
                </td>
                <td>
                    <?php echo $d['body_harness']; ?>
                </td>
                <td>
                    <?php echo $d['sepatu']; ?>
                </td>
                <td>
                    <?php echo $d['keterangan']; ?>
                </td>
                <td>
                    <?php echo $d['alasan']; ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>