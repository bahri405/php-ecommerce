<?php 

  require "session.php";
  require "../koneksi.php";

  $id = $_GET['p'];
  $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'" );
  $data = mysqli_fetch_array($query);
  
  $queryKategori = mysqli_query($con , "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");


   // funtion renanme file gambar jadi random
  function generateRandomString($length = 10){
    $characters = '0123456789abcdfghijklmnopqrstuvwxyz';
    $characterslength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $characterslength - 1)];
    }
    return $randomString;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>produk-detail</title>

  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

  <style>
    .no-decoration{
      text-decoration: none;
    }

    form div{
      margin-bottom: 10px;
    }
  </style>
<body>

<?php require "navbar.php"; ?>

<div class="container my-5">
    <h2>Detail Produk</h2> 

  <div class="container col-lg-12 col-md-6 mb-5">
    <form action="" method="POST" enctype="multipart/form-data">

        <div>
            <label for="kategori">Nama</label>
            <input type="text" name="nama" id="nama"  class="form-control" value="<?php echo $data['nama']; ?>" autocomplete="off" required>
        </div>

        <div>
          <label for="kategori" id="kategori">Kategori</label>
          <select name="kategori" id="kategori" class="form-control" required>
            <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
            <?php  
              while($dataKategori=mysqli_fetch_array($queryKategori)){
            ?>
              <option value=" <?php echo $data['id']; ?> "> <?php echo $dataKategori['nama']; ?></option>

            <?php     
              }
            ?>
          </select>
        </div>
        <div>
          <label for="harga">Harga</label>
          <input type="number" name="harga" class="form-control" value="<?php echo $data['harga']; ?>" required>
        </div>
        <div>
          <label for="currentFoto">Foto Produk Sekarang</label>
          <img src="../image/<?php echo $data['foto'] ?>" alt="" width="200px">
        </div>
        <div>
          <label for="foto">Foto</label>
          <input type="file" id="foto" name="foto" class="form-control">
        </div>
        <div>
          <label for="detail">Detail</label>
          <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
            <?php echo $data['detail'];  ?>
          </textarea>
        </div>
        <div>
          <label for="ketersediaan_stok">Ketersediaan Stok</label>
          <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
              <option value="<?php echo $data['ketersediaan_stok'];  ?>"><?php echo $data['ketersediaan_stok'];  ?></option>
              <?php 
                if($data['ketersediaan_stok']== 'tersedia'){
              ?>
                <option value="habis">Habis</option>
              <?php 
                }
                else{
              ?>
                <option value="tersedia">Tersedia</option>
              <?php 
                }
              ?>
          </select>
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
        </div>
    </form>
    
    <?php 
      if(isset($_POST['simpan'])){
        $nama = htmlspecialchars($_POST['nama']);
        $kategori = htmlspecialchars($_POST['kategori']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
        
        $target_dir = "../image/";
        $nama_file = basename($_FILES['foto']['name']);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = $_FILES['foto']['size'];
        $random_name = generateRandomString(20);
        $new_name = $random_name . "." . $imageFileType;

        if($nama == '' || $kategori == '' || $harga == ''){
      ?>
          <div class="alert alert-warning mt-3" role="alert">
              Nama, kategori dan harga wajib diisi !
            </div>
      <?php 
          }
          else{
              $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori',nama='$nama',harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id=$id ");

              if($nama_file !=''){
                if($image_size > 500000){
      ?>
                  <div class="alert alert-warning mt-3" role="alert">
                      File gambar tidak boleh lebih 500 kb !
                  </div>
      <?php
                }
                else{
                  if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType!= 'gif' && $imageFileType != 'jpeg') {
      ?>
                      <div class="alert alert-warning mt-3" role="alert">
                        Format Gambar harus jpg / png !
                      </div>
      <?php               
                  }
                  else{
                    move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_name );

                    $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id' ");

                    if($queryUpdate){
      ?>
                        <div class="alert alert-primary mt-3" role="alert">
                          Produk berhasil disimpan .
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php" >
      <?php
                    }
                  }
                }
            }
          }
      }

      if(isset($_POST['hapus'])){
        $queryHapus = mysqli_query($con, "DELETE FROM produk WHERE id='$id' ");

        if($queryHapus){
    ?>
          <div class="alert alert-primary mt-3" role="alert">
                Produk berhasil di hapus! .
          </div>

          <meta http-equiv="refresh" content="2; url=produk.php" >
    <?Php 
        }
      }
    ?>
  </div>
</div>


  <script src="../bootstrap/js//bootstrap.bundle.min.js"></script>
  <script src="../fontawesome/js//all.min.js"></script>
</body>
</html>