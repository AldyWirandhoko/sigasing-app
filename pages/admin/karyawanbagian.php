<?php
if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        if (isset($_POST['button_update'])) {

            $updateSql = "INSERT INTO bagian_karyawan SET karyawan_id = ?, bagian_id = ?, tanggal_mulai = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1, $_POST['karyawan_id']);
            $stmt->bindParam(2, $_POST['bagian_id']);
            $stmt->bindParam(3, $_POST['tanggal_mulai']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
            } else {
                $_SESSION['hasil'] = false;
            }
            echo "<meta http-equiv='refresh' content='1;url=?page=karyawanbagian&id=" . $_POST['karyawan_id'] . "'>";
        }

        if (isset($_POST['button_delete'])) {
            $updateSql = "DELETE FROM bagian_karyawan WHERE id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1, $_POST['bk_id']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
            } else {
                $_SESSION['hasil'] = false;
            }
            echo "<meta http-equiv='refresh' content='1;url=?page=karyawanbagian&id=" . $_POST['karyawan_id'] . "'>";
        }
?>
        <section class="content-header">
            <div class="container-fluid">
                <?php
                if (isset($_SESSION["hasil"])) {
                    if ($_SESSION["hasil"]) {
                ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                        </div>
                <?php
                    }
                    unset($_SESSION['hasil']);
                }
                ?>
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Karyawan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                            <li class="breadcrumb-item active">Riwayat Bagian</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Bagian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nik">Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" name="nik" value="<?php echo $row['nik'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="handphone">Handphone</label>
                                <input type="text" class="form-control" name="handphone" value="<?php echo $row['handphone'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap'] ?>" disabled>
                    </div>
                    <form action=""  method="post">
                        <input type="hidden" value="<?php echo $id ?>" name="karyawan_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bagian_id">Bagian</label>
                                    <select class="form-control" name="bagian_id">
                                        <option value="">-- Pilih Bagian --</option>
                                        <?php
                                        
                                        $selectSQL = "SELECT * FROM bagian";
                                        $stmt_bagian = $db->prepare($selectSQL);
                                        $stmt_bagian->execute();

                                        while ($row_bagian = $stmt_bagian->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value=\"" . $row_bagian["id"] . "\">" . $row_bagian["nama_bagian"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="button_update" class="btn btn-success btn-block float-right mb-3">
                                <i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                    <table id="mytable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bagian</th>
                                <th>Tanggal Mulai</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $database = new Database();
                            $db = $database->getConnection();

                            $selectSql = "SELECT BK.*, B.nama_bagian FROM bagian_karyawan BK
                                        LEFT JOIN bagian B ON BK.bagian_id = B.id
                                        WHERE BK.karyawan_id = ?
                                        ORDER BY tanggal_mulai DESC";
                            $stmt = $db->prepare($selectSql);
                            $stmt->bindParam(1, $id);
                            $stmt->execute();

                            $no = 1;
                            while ($rowbagian = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowbagian['nama_bagian'] ?></td>
                                    <td><?php echo $rowbagian['tanggal_mulai'] ?></td>
                                    <td>
                                        <form action method="POST">
                                            <input type="hidden" name="bk_id" value="<?php echo $rowbagian['id'] ?>">
                                            <input type="hidden" value="<?php echo $id ?>" name="karyawan_id">
                                            <button type="submit" name="button_delete" class="btn btn-danger btn-sm mr-1" onClick="javascript: return confirm('Konfirmasi data akan dihapus?');"><i class="fa fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}