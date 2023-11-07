<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "perpustakaan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Can't connect to the database");
}
$id_siswa             = "";
$judul_buku           = "";
$tanggal_peminjaman   = "";
$tanggal_pengembalian = "";
$sukses               = "";
$error                = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']); // Escape input
    $sql1 = "DELETE FROM peminjaman WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Deleted";
    } else {
        $error = "Can't delete";
    }
}
if ($op == 'edit') {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']); // Escape input
    $sql1 = "SELECT * FROM peminjaman WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    if ($r1) { // Periksa apakah data ditemukan
        $id_siswa             = $r1['ID_Siswa']; // Perbaikan: Nama kolom dengan underscore
        $judul_buku           = $r1['Judul_Buku']; // Perbaikan: Nama kolom dengan underscore
        $tanggal_peminjaman   = $r1['Tanggal_Peminjaman']; // Perbaikan: Nama kolom dengan underscore
        $tanggal_pengembalian = $r1['Tanggal_Pengembalian']; // Perbaikan: Nama kolom dengan underscore
    } else {
        $error = "Data not found";
    }
}
if (isset($_POST['simpan'])) {
    $id_siswa             = mysqli_real_escape_string($koneksi, $_POST['ID_Siswa']); // Escape input
    $judul_buku           = mysqli_real_escape_string($koneksi, $_POST['Judul_Buku']); // Escape input
    $tanggal_peminjaman   = mysqli_real_escape_string($koneksi, $_POST['Tanggal_Peminjaman']); // Escape input
    $tanggal_pengembalian = mysqli_real_escape_string($koneksi, $_POST['Tanggal_Pengembalian']); // Escape input

    if ($id_siswa && $judul_buku && $tanggal_peminjaman && $tanggal_pengembalian) {
        if ($op == 'edit') {
            $sql1 = "UPDATE peminjaman SET ID_Siswa = '$id_siswa', Judul_Buku = '$judul_buku', Tanggal_Peminjaman = '$tanggal_peminjaman', Tanggal_Pengembalian = '$tanggal_pengembalian' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data updated successfully";
            } else {
                $error = "Failed to update data";
            }
        } else {
            $sql1 = "INSERT INTO peminjaman (ID_Siswa, Judul_Buku, Tanggal_Peminjaman, Tanggal_Pengembalian) VALUES ('$id_siswa','$judul_buku','$tanggal_peminjaman','$tanggal_pengembalian')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Masukkan data dengan lengkap";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
    .mx-auto {
        width: 900px
    }

    .card {
        margin-top: 25px;
    }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- input data -->
        <div class="card">
            <div class="card-header text-white bg-primary">
                Masukkan Data Peminjaman
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                    header("refresh:5;url=index.php"); //5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-2">
                        <label for="ID_Siswa" class="col-sm-2 col-form-label">ID Siswa</label>
                        <div class="col-sm-15">
                            <input type="text" class="form-control" id="ID_Siswa" name="ID_Siswa"
                                value="<?php echo $id_siswa ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="Judul_Buku" class="col-sm-2 col-form-label">Judul Buku</label>
                        <div class="col-sm-15">
                            <input type="text" class="form-control" id="Judul_Buku" name="Judul_Buku"
                                value="<?php echo $judul_buku ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="Tanggal_Peminjaman" class="col-sm-5 col-form-label">Tanggal Peminjaman</label>
                        <div class="col-sm-15">
                            <input type="text" class="form-control" id="Tanggal_Peminjaman" name="Tanggal_Peminjaman"
                                value="<?php echo $tanggal_peminjaman ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Tanggal_Pengembalian" class="col-sm-5 col-form-label">Tanggal Pengembalian</label>
                        <div class="col-sm-15">
                            <input type="text" class="form-control" id="Tanggal_Pengembalian"
                                name="Tanggal_Pengembalian" value="<?php echo $tanggal_pengembalian ?>">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="submit_foto" class="form-label">Foto ID Card Siswa</label>
                        <div class="col-sm-15">
                            <input type="file" class="form-control" id="submit_foto" name="submit_foto">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-success" />
                    </div>
                </form>
            </div>
        </div>

        <!-- output data -->
        <div class="card">
            <div class="card-header text-white bg-warning">
                Data Peminjaman
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Siswa</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Peminjaman</th>
                            <th scope="col">Tanggal Pengembalian</th>
                            <th scope="col">Foto ID Card Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM peminjaman ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_siswa = $r2['ID_Siswa'];
                            $judul_buku = $r2['Judul_Buku'];
                            $tanggal_peminjaman = $r2['Tanggal_Peminjaman'];
                            $tanggal_pengembalian = $r2['Tanggal_Pengembalian'];

                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $id_siswa ?></td>
                            <td scope="row"><?php echo $judul_buku ?></td>
                            <td scope="row"><?php echo $tanggal_peminjaman ?></td>
                            <td scope="row"><?php echo $tanggal_pengembalian ?></td>
                            <td><img src="data:image/png;base64,<?php echo base64_encode($data['foto']); ?>"
                                    alt="Foto ID Card Siswa" width="100"></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $r2['id'] ?>"><button type="button"
                                        class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $r2['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus data?')"><button type="button"
                                        class="btn btn-danger">Delete</button></a>
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
</body>

</html>