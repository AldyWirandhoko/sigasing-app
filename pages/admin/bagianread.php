<?php include_once "partials/cssdatatables.php" ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <?php
        if (isset($_SESSION["hasil"])) {
            if ($_SESSION["hasil"]) {
        ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
        <?php
            }
            unset($_SESSION['hasil']);
            unset($_SESSION['pesan']);
        }
        ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bagian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Bagian</li>
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
            <h3 class="card-title">Data Bagian</h3>
            <a href="?page=bagiancreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah data</a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Nama Kepala Bagian</th>
                        <th>Lokasi Bagian</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Nama Kepala Bagian</th>
                        <th>Lokasi Bagian</th>
                        <th>Opsi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $database = new Database();
                    $db = $database->getConnection();

                    $selectSql = "SELECT B.*, K.nama_lengkap nama_kepala_bagian, L.nama_lokasi nama_lokasi_bagian FROM bagian B 
                    LEFT JOIN karyawan K ON B.karyawan_id = K.id
                    LEFT JOIN lokasi L ON B.lokasi_id = L.id";
                    $stmt = $db->prepare($selectSql);
                    $stmt->execute();
                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_bagian'] ?></td>
                            <td><?php echo $row['nama_kepala_bagian'] ?></td>
                            <td><?php echo $row['nama_lokasi_bagian'] ?></td>
                            <td>
                                <form action method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                </form>
                                <a href="?page=bagianupdate&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=bagiandelete&id=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onClick="javascript: return confirm('Konfirmasi data akan dihapus?');">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.content -->
<?php include "partials/scripts.php" ?>
<?php include "partials/scriptsdatatables.php" ?>
<script>
    $(function() {
        $('#mytable').DataTable()
    });
</script>