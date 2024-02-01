<?php 

  $con = mysqli_connect("localhost" , "root" , "" , "toko_online");


  // cek koneksi
  if(mysqli_connect_errno()){
    echo "failed to connect to MySQL : " . mysqli_connect_error();
    exit;
  }

?>