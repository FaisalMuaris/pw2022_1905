<?php


function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'pw2022_1905');
}

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
