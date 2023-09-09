<?php
$host = "localhost"; //--- Koneksi ke Database ---->
$user = "root";
$pass = "";
$db   = "db_mahasiswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak Terkoneksi");
}
$nim            = "";
$nama           = "";
$mata_kuliah    = "";
$grade          = "";
$nilai_ratarata = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])){
    $op = $_GET['op'];
} else {
    $op     = "";
}
if($op == 'delete'){ //------Delete data -->
    $id     = $_GET['id'];
    $sql1   = "DELETE FROM db_nilai where id = '$id' ";
    $q1    = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses     = "Data berhasil dihapus";
    }else{
        $error      = "Gagal hapus data";
    }
}

if ($op == 'edit') { //---edit data -->
    $id                = $_GET['id'];
    $sql1              = "SELECT * FROM db_nilai where id = '$id' ";
    $q1                = mysqli_query($koneksi, $sql1);
    $r1                = mysqli_fetch_array($q1);
    $nim               = $r1['nim'];
    $nama              = $r1['nama'];
    $mata_kuliah       = $r1['mata_kuliah'];
    $grade             = $r1['grade'];
    $nilai_ratarata    = $r1['nilai_ratarata'];

    if ($nim == '') {
        $error = "Data Failed";
    }
}

if (isset($_POST['submit'])) { //-----create data -->
    $nim            = $_POST['nim'];
    $nama           = $_POST['nama'];
    $mata_kuliah    = $_POST['mata_kuliah'];
    $grade          = $_POST['grade'];
    $nilai_ratarata = $_POST['nilai_ratarata'];

    if ($nim && $nama && $mata_kuliah && $grade && $nilai_ratarata) {
        if ($op == 'edit') { //------update data
            $sql1 = "UPDATE db_nilai SET nim = '$nim',nama= '$nama',mata_kuliah='$mata_kuliah',grade= '$grade',nilai_ratarata= '$nilai_ratarata' where id = '$id' ";
            $q1   = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { // ----insert data
            $sql1 = "INSERT into db_nilai(nim,nama,mata_kuliah,grade,nilai_ratarata)values ('$nim','$nama', '$mata_kuliah', '$grade', '$nilai_ratarata')";
            $q1 = mysqli_query($koneksi, $sql1);
            
            if ($q1) {
                $sukses     = "Berhasil input data baru";
            } else {
                $error       = "Gagal input data!";
            }
        }
    } else {
        $error = "Silahkan masukkan data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD database mysql</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!--.......... untuk memasukkan data... -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                <b>Create / Edit Data / Tambah Data</b>
            </div>
            <div class="card-body">
                <!-- tampilan peringatan/warning -->
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
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
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label"> NIM </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label"> Nama </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mata_kuliah" class="col-sm-2 col-form-label"> Mata Kuliah </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="mata_kuliah" value="<?php echo $mata_kuliah ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="grade" class="col-sm-2 col-form-label"> Grade </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="grade" id="grade">
                                <option value=""> -Pilih grade-</option>
                                <option value="A"> A </option>
                                <option value="B"> B </option>
                                <option value="C"> C </option>
                                <option value="D"> D </option>
                                <option value="E"> E </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nilai_ratarata" class="col-sm-2 col-form-label"> Nilai Rata Rata </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="nilai_ratarata" id="nilai_ratarata">
                                <option value=""> -Pilih Nilai rata-rata-</option>
                                <option value="4.00"> 4,00 </option>
                                <option value="3.00"> 3,00 </option>
                                <option value="2.00"> 2,00 </option>
                                <option value="1.00"> 1,00 </option>
                                <option value="0.00"> 0,00 </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- untuk mengeluarkan/tampilan  data -->
        <div class="card">
            <div class="card-header text-white bg-success">
                <b>Data Nilai Mahasiswa</b>
            </div>
            <div class="card-body">
                <table class="table" cellpadding="5px">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Mata Kuliah</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Nilai Rata-rata</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM db_nilai order by id asc ";
                        $q2   = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id              = $r2['id'];
                            $nim             = $r2['nim'];
                            $nama            = $r2['nama'];
                            $mata_kuliah     = $r2['mata_kuliah'];
                            $grade           = $r2['grade'];
                            $nilai_ratarata  = $r2['nilai_ratarata'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $mata_kuliah ?></td>
                                <td scope="row"><?php echo $grade ?></td>
                                <td scope="row"><?php echo $nilai_ratarata ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Deleta data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                            </tr>
        
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>