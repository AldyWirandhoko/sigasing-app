<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    $validateSql = "SELECT * FROM lokasi WHERE nama_lokasi = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['nama_lokasi']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            Nama lokasi sama sudah ada
        </div>
<?php
    } else {
        $insertSql = "INSERT INTO lokasi SET nama_lokasi = ?";
        $stmt = $db->prepare($insertSql);
        $stmt ->bindParam(1, $_POST['nama_lokasi']);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Data Lokasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=lokasiread">Lokasi</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
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
            <h3 class="card-title">Tambah Lokasi</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="text" class="form-control" name="nama_lokasi">
                </div>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /.content -->
<?php include "partials/scripts.php" ?>