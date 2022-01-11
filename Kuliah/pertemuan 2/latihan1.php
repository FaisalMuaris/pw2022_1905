<?php

// Koneksi ke database dan pilih database
$koneksi = mysqli_connect('localhost', 'root', '', 'pw2022_1905');

// Query isi tabel mahasiswa
$result = mysqli_query($koneksi, "SELECT * FROM mahasiswa");

// ubah data ke dalam array
// $row = mysqli_fetch_row($result); // Ini Array Numerik
// $row = mysqli_fetch_assoc($result); // Ini Array Associative 
// $row = mysqli_fetch_array($result); // Ini Array // kedua nya

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
};

// tampung ke variable mahasiswa

$mahasiswa = $rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <h3>Daftar Mahasiswa</h3>

  <table border="1" cellpadding="10" cellspacing="0">

    <tr>
      <th>#</th>
      <th>Gambar</th>
      <th>NRP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Jurusan</th>
      <th>Aksi</th>
    </tr>

    <?php $i = 1;
    foreach ($mahasiswa as $mhs) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="img/<?= $mhs['gambar']; ?>" width="60"></td>
        <td><?= $mhs['nrp']; ?></td>
        <td><?= $mhs['nama']; ?></td>
        <td><?= $mhs['email']; ?></td>
        <td><?= $mhs['jurusan']; ?></td>
        <td>
          <a href="">ubah</a> | <a href="">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>

  </table>
</body>

</html>