<?php

// KONEKSI
function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'pw2022_1905');
}

// MENGAMBL DATA DENGAN QUERYY
function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // Jika hasilnya hanya satu saja
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {

    $rows[] = $row;
  };

  return $rows;
}


// TAMBAHH
function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = " INSERT INTO
                  mahasiswa
            VALUES
            (null, '$nama','$nrp','$email', '$jurusan', '$gambar');
            ";
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

// ============= HAPUS =============
function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

// Ubah
function ubah($data)
{
  $conn = koneksi();

  $id = $data['id'];
  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = " UPDATE mahasiswa SET
              nama = '$nama',
              nrp  = '$nrp',
              email = '$email',
              jurusan = '$jurusan',
              gambar = '$gambar'
              WHERE id = $id";
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}
// Pencarian
function cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa
              WHERE 
              nama LIKE '%$keyword%' OR
              nrp LIKE '%$keyword%'
              ";

  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {

    $rows[] = $row;
  }

  return $rows;
}
/// LOGINN
function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // Cek dulu username
  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    //cek password
    if (password_verify($password, $user['password'])) {

      // set session
      $_SESSION['login'] = true;
      header(("Location: index.php"));
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username / Password Salah!'
  ];
}

//=====================REGISTRASI============

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // Jika Username / Password Kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
            alert('Username / Password tidak boleh Kosong!');
            document.location.href = 'registrasi.php;
            </script>";
    return false;
  }

  // Jika username sudah ada di database
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script>
        alert('Username Sudah Terdaftar');
        document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  //JIKA KONFIRMASI PASSWORD TIDAK SESUAI
  if ($password1 !== $password2) {
    echo "<script>
        alert('Konfirmasi Password Tidak Sesuai');
        document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  // Jika Password < 5
  if (strlen($password1) < 5) {
    echo "<script>
        alert('Password Terlalu Pendek!');
        document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  //Jika Username dan Password sesuai
  // enkripsi Password
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);
  // Insert ke tabel user
  $query = "INSERT INTO user
              VALUES
              (null, '$username', '$password_baru')
              ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
