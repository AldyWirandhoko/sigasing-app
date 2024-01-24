
<style type="text/css">
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    td.angka {
        text-align: right;
    }
</style>
<span style="font-size: 20px; font-weight: bold">Rekapitulasi Penggajian PerTahun<br></span>
<br>
<br>
<table>
    <colgroup>
        <col style="width: 5%" class="angka">
        <col style="width: 15%" class="angka">
        <col style="width: 20%" class="angka">
        <col style="width: 20%" class="angka">
        <col style="width: 20%" class="angka">
        <col style="width: 20%" class="angka">
    </colgroup>
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Uang Makan</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    include "../database/database.php";
    $database = new Database();
    $db = $database->getConnection();
    $selectSql = "SELECT bulan,
                        SUM(P.gapok) jumlah_gapok,
                        SUM(P.tunjangan) jumlah_tunjangan,
                        SUM(P.uang_makan) jumlah_uang_makan,
                        SUM(P.gapok) + SUM(P.tunjangan) + SUM(P.uang_makan) total
                        FROM penggajian P
                        GROUP BY bulan;";
    $stmt = $db->prepare($selectSql);
    $stmt->execute();
    $no = 1;
    $total_jumlah_gapok = 0;
    $total_jumlah_tunjangan = 0;
    $total_jumlah_uang_makan = 0;
    $total_total = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $total_jumlah_gapok += $row['jumlah_gapok'];
        $total_jumlah_tunjangan += $row['jumlah_tunjangan'];
        $total_jumlah_uang_makan += $row['jumlah_uang_makan'];
        $total_total += $row['total'];
    ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row['bulan'] ?></td>
            <td><?php echo number_format($row['jumlah_gapok']) ?></td>
            <td><?php echo number_format($row['jumlah_tunjangan']) ?></td>
            <td><?php echo number_format($row['jumlah_uang_makan']) ?></td>
            <td><?php echo number_format($row['total']) ?></td>
        </tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="2">Grand Total</td>
        <td><?php echo number_format($total_jumlah_gapok) ?></td>
        <td><?php echo number_format($total_jumlah_tunjangan) ?></td>
        <td><?php echo number_format($total_jumlah_uang_makan) ?></td>
        <td><?php echo number_format($total_total) ?></td>
    </tr>
</table>