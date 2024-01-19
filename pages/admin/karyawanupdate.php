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

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM karyawan WHERE nik = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nik']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    NIK sama sudah ada
                </div>
<?php
            } else {
                $validateSql = "SELECT * FROM pengguna WHERE username = ? AND id != ?";
                $stmt = $db->prepare($validateSql);
                $stmt->bindParam(1, $_POST['username']);
                $stmt->bindParam(2, $_POST['id']);
                $stmt->execute();
                if($stmt->rowCount() > 0){
            ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                        Username sama sudah ada
                    </div>
<?php
            } else {
                if ($_POST['password'] != $_POST['password_ulangi']) {
                    ?> 
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                            Password tidak sama
                        </div>
<?php
                } else {
                    $md5Password = md5($_POST['password']);
        
                    $updateSql = "UPDATE pengguna SET username = ?, password = ?, peran = ? WHERE id = ?";
                    $stmt = $db->prepare($updateSql);
                    $stmt->bindParam(1, $_POST['username']);
                    $stmt->bindParam(2, $md5Password);
                    $stmt->bindParam(3, $_POST['peran']);
                    $stmt->bindParam(4, $_POST['id']);
        
                    if ($stmt->execute()) {
        
                        $pengguna_id = $db->lastInsertId();
                        $updateKaryawanSql = "UPDATE karyawan SET nik = ?, nama_lengkap = ?, handphone = ?, email = ?, tanggal_masuk = ?, pengguna_id = ? WHERE id = ?";
                        $stmtKaryawan = $db->prepare($updateKaryawanSql);
                        $stmtKaryawan->bindParam(1, $_POST['nik']);
                        $stmtKaryawan->bindParam(2, $_POST['nama_lengkap']);
                        $stmtKaryawan->bindParam(3, $_POST['handphone']);
                        $stmtKaryawan->bindParam(4, $_POST['email']);
                        $stmtKaryawan->bindParam(5, $_POST['tanggal_masuk']);
                        $stmtKaryawan->bindParam(6, $pengguna_id);
                        $stmtKaryawan->bindParam(7, $_POST['id']);
        
                        if ($stmtKaryawan->execute()) {
                            $_SESSION['hasil'] = true;
                            $_SESSION['pesan'] = "Berhasil ubah data";
                        } else {
                            $_SESSION['hasil'] = false;
                            $_SESSION['pesan'] = "Gagal ubah data";
                        }
                    } else {
                        $_SESSION['hasil'] = false;
                        $_SESSION['pesan'] = "Gagal ubah data";
                    }
                    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
                }
        }
    }
}
        ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ubah Data Karyawan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
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
                    <h3 class="card-title">Ubah Karyawan</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nik">Nomor Induk Karyawan</label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                            <input type="text" class="form-control" name="nik" value="<?php echo $row['nik'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap">
                        </div>
                        <div class="form-group">
                            <label for="handphone">Handphone</label>
                            <input type="text" class="form-control" name="handphone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_ulangi">Password (Ulangi)</label>
                            <input type="password" class="form-control" name="password_ulangi">
                        </div>
                        <div class="form-group">
                            <label for="peran">Peran</label>
                            <select class="form-control" name="peran">
                                <option value="">-- Pilih Peran --</option>
                                <option value="ADMIN">ADMIN</option>
                                <option value="USER">USER</option>
                            </select>
                        </div>
                        <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
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
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}