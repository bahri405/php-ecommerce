<?php  
  session_start();
  require "../koneksi.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <title>login</title>
</head>

<style>
  .main{
    height: 100vh;
  }

  .login-box{
    width: 500px;
    height: 300px;
    
    box-sizing: border-box;
    border-radius: 10px;
  }

</style>

<body>
  <div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box p-5 shadow">
      <form action="" method="POST">
        <div>
          <label for="username">username</label>
          <input type="text" class="form-control" name="username" id="username">
        </div>
        <div>
          <label for="password">password</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>
        <div>
          <button type="submit" class="btn btn-success form-control mt-3" name="loginbtn">login</button>
        </div>
      </form>
    </div>
    
    <!-- ketika di submit -->
    <div class="mt-3 text-center" style="width: 500px;">
      <?php 
        if(isset($_POST['loginbtn'])){
          $username = htmlspecialchars($_POST['username']);
          $password = htmlspecialchars($_POST['password']);

          $query = mysqli_query($con , "SELECT * FROM users WHERE username ='$username'");
          $countdata = mysqli_num_rows($query);
          $data = mysqli_fetch_array($query);

          if($countdata>0){
            if(password_verify($password, $data['password'])){
              $_SESSION['username'] = $data['username'];
              $_SESSION['login'] = true;
              header('location: ../adminpanel');
            }
            else{
              ?>
              <div class="alert alert-warning" role="alert">password salah</div>
              <?php
            }

          }
          else{
            ?>
            <div class="alert alert-warning" role="alert">Akun tidak tersedia</div>
            <?php
          }

        }
      ?>
    </div>

  </div>
</body>
</html>