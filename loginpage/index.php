<?php
include("connection.php");
$login_err = $password_err = "";
$confirmed = true; //onaylı bir hesap olup olmadığına göre html sayfamızda bir alert vericez
if (isset($_POST['button_login'])) { //kaydet butonumuza basılmışsa isset() true döner bize //SORUN ŞU BUTONA TIKLANINCA BU BLOĞA GİRMİYO VE VERİTABANINA DEĞER EKLENMEMİŞ OLUYO BİDE PHPSTORM UDA ÇÖZ

  $password = $_POST["password"];
  $email = $_POST["email"];
  if (isset($email) && isset($password)) {
    $selectQuery = "SELECT * FROM userinfo WHERE email='$email'";
    $select = mysqli_query($conn, $selectQuery);
    $counter = mysqli_num_rows($select); //seçtiğimiz tablodaki satır sayısını döner bize

    if (!$counter > 0) {
      $login_err = "No such user found";
    } else {
      $user = mysqli_fetch_assoc($select); //veri tabanından veriyi çekmemizi sağlar her satır arrayin bir indexi olarak döner 
      $securedPassword = $user["password"];
      if (password_verify($password, $securedPassword)) //girilen parola ile şifrelenmiş parola birbiri ile eşleşiyomu
      {
        if ($user["confirm"]) { //kullanıcının hesabı onaylıysa 
          session_start(); //yeni bir oturum başlatıyoruz
          header("location:index.html");
        } else {
          $confirmed = false;
        }
      } else {
        $password_err = "wrong password";
      }
    }

    mysqli_close($conn);
  }
}
?>

<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>World of furniture</title>

</head>

<body>

  <section class="vh-100" style="background-color: #9A616D;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="/loginpage/images/img1.jpg"
                  alt="login form" class="img-fluid m-4" style="border-radius:1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form action="index.php" method="POST">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0"><i>Furniture</i></span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="email" id="form2Example17 " class="form-control form-control-lg
                    <?php
                    if (!empty($login_err))
                      echo "is-invalid"
                    ?>
                    " name="email" />
                      <label class="form-label" for="form2Example17">Email address</label>

                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="password" id="form2Example27" class="form-control form-control-lg
                     <?php
                      if (!empty($password_err) || !empty($login_err))
                        echo "is-invalid"
                      ?>
                      
                    " name="password" />
                      <label class="form-label" for="form2Example27">Password</label>
                      <div id="validationServer03Feedback" class="invalid-feedback">
                        <?php
                        echo $password_err;
                        ?>
                      </div>
                      <div id="validationServer03Feedback" class="invalid-feedback">
                        <?php
                        echo $login_err;
                        ?>
                      </div>

                    </div>
                    <div id="validationServer03Feedback" class="invalid-feedback">
                      <?php
                      echo $login_err;
                      ?>
                    </div>

                    <div class="pt-1 mb-4">
                      <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit" name="button_login" href>Login</button>
                    </div>
                    <?php
                    if (!$confirmed) {
                      echo '<div class="alert alert-danger" role="alert" style="display:inline">
                    Your account is not verified, please verify.
                  </div> ';
                      echo '<a href="verifying.php"> for verifying </a><br><br>';
                    }
                    ?>


                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="register.php"
                        style="color: #393f81;">Register here</a></p>
                    <a href="termofuse.html" class="small text-muted">Terms of use.</a>
                    <a href="privacy.html" class="small text-muted">Privacy policy</a>
                  </form>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>