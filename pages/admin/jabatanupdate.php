<?php
if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM jabatan WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        if (isset($_POST['button_update'])) {

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM jabatan WHERE nama_jabatan = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nama_jabatan']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Nama jabatan sama sudah ada
                </div>
        <?php
            } else {
                $updateSql = "UPDATE jabatan SET nama_jabatan = ?, gapok_jabatan = ?, tunjangan_jabatan = ?, uang_makan_perhari = ? WHERE id = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['nama_jabatan']);
                $stmt->bindParam(2, $_POST['gapok_jabatan']);
                $stmt->bindParam(3, $_POST['tunjangan_jabatan']);
                $stmt->bindParam(4, $_POST['uang_makan_perhari']);
                $stmt->bindParam(5, $_POST['id']);
                if ($stmt->execute()) {
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
            }
        }
        ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ubah Data Jabatan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
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
                    <h3 class="card-title">Ubah Jabatan</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nama_jabatan">Nama jabatan</label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                            <input type="text" class="form-control" name="nama_jabatan" value="<?php echo $row['nama_jabatan'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="gapok_jabatan">Gaji Pokok</label>
                            <input type="number" class="form-control" name="gapok_jabatan" value="<?php echo $row['gapok_jabatan'] ?>""
                            onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'  
                            >
                        </div>
                        <div class="form-group">
                            <label for="tunjangan_jabatan">Tunjangan</label>
                            <input type="number" class="form-control" name="tunjangan_jabatan" value="<?php echo $row['tunjangan_jabatan'] ?>""
                            onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'  
                            >
                        </div>
                        <div class="form-group">
                            <label for="uang_makan_perhari">Uang Makan Perhari</label>
                            <input type="number" class="form-control" name="uang_makan_perhari" value="<?php echo $row['uang_makan_perhari'] ?>""
                            onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'  
                            >
                        </div>
                        <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
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
