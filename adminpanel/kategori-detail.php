<?php 

  require "session.php";
  require "../koneksi.php";

  $id = $_GET['p'];
  $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'" );
  $data = mysqli_fetch_array($query);
  

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail-kategori</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">

</head>
<body>

<?php require "navbar.php"; ?>

<div class="container my-5">
    <h2>Detail Kategori</h2>

    <div class="container col-lg-12 col-md-6">
      <form action="" method="POST">
        
        <div>
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori"  class="form-control" value="<?php echo $data['nama']; ?>">
        </div>
        
        <div class="mt-3">
          <button class="btn btn-primary" type="submit" name="editBtn">edit</button>
          <button class="btn btn-danger" type="submit" name="deleteBtn">delete</button>
        </div>
      </form>
        <?php 
          if(isset($_POST['editBtn'])){
            $kategori = htmlspecialchars($_POST['kategori']);
            if($data['nama'] == $kategori){
        ?>
              <meta http-equiv="refresh" content="0; url=kategori.php">
        <?php
            }
            else{
              $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
              $jumlahData = mysqli_num_rows($query);

              if($jumlahData > 0){
        ?>
                <div class="alert alert-warning mt-3" role="alert">
                  Kategori sudah ada
                </div>
        <?php 
              }
              else{
                $querySimpan = mysqli_query($con ,"UPDATE kategori SET nama='$kategori' WHERE id='$id'");

                if($querySimpan){
          ?>
                    <div class="alert alert-primary mt-3" role="alert">kategori berhasil di update </div>
                  
                  <meta http-equiv="refresh" content="1; url=kategori.php">
        
        <?php
                }
              }
            }
          }

          if (isset($_POST['deleteBtn'])) {
            
            $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");

            $dataCount = mysqli_num_rows($queryCheck);

            if ($dataCount > 0){
          ?>
              <div class="alert alert-warning mt-3" role="alert">kategori berhasil tidak bisa di hapus karena sudah digunakan di produk! </div>

              <?php  

              
            }



            $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");

            if($queryDelete){
        ?>
            <div class="alert alert-primary mt-3" role="alert">kategori berhasil di hapus </div>
            <meta http-equiv="refresh" content="2; url=kategori.php">
        <?php   
            }
          }
        ?>
    </div>
</div>



<script src="../bootstrap/js//bootstrap.bundle.min.js"></script>
  <script src="../fontawesome/js//all.min.js"></script>
</body>
</html>