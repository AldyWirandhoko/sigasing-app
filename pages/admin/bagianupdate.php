<?php
if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM bagian WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        if (isset($_POST['button_update'])) {

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM bagian WHERE nama_bagian = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nama_bagian']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Nama bagian sama sudah ada
                </div>
        <?php
            } else {
                $updateSql = "UPDATE bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ? WHERE id = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['nama_bagian']);
                $stmt->bindParam(2, $_POST['karyawan_id']);
                $stmt->bindParam(3, $_POST['lokasi_id']);
                $stmt->bindParam(4, $_POST['id']);
                if ($stmt->execute()) {
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
            }
        }
        ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ubah Data Bagian</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                            <li class="breadcrumb-item active">Ubah Data</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubah Bagian</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nama_jabatan">Nama Bagian</label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                            <input type="text" class="form-control" name="nama_bagian" value="<?php echo $row['nama_bagian'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="karyawan_id">Kepala Bagian</label>
                            <select class="form-control" name="karyawan_id">
                                <option value="">-- Pilih Kepala Bagian --</option>
                                <?php 
                                $database = new Database();
                                $db = $database->getConnection();

                                $selectSQL = "SELECT * FROM karyawan";
                                $stmt_karyawan = $db->prepare($selectSQL);
                                $stmt_karyawan->execute();

                                while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row_karyawan["id"] == $row["karyawan_id"] ? " selected" : "";
                                    echo "<option value=\"" . $row_karyawan["id"] . "\" ". $selected. ">" . $row_karyawan["nama_lengkap"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lokasi_id">Lokasi Bagian</label>
                            <select class="form-control" name="lokasi_id">
                                <option value="">--Pilih Lokasi Bagian --</option>
                                <?php 
                                $database = new Database();
                                $db = $database->getConnection();

                                $selectSQL = "SELECT * FROM lokasi";
                                $stmt_lokasi = $db->prepare($selectSQL);
                                $stmt_lokasi->execute();

                                while ($row_lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row_lokasi["id"] == $row["lokasi_id"] ? " selected" : "";
                                    echo "<option value=\"" . $row_lokasi["id"] . "\" ". $selected. ">" . $row_lokasi["nama_lokasi"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
                            <i class="fa fa-times"></i> Batal
                        </a>
                        <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
}
