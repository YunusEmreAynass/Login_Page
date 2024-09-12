<?php
include("connection.php");
$generel_err = $password_err = $sameaccount_err = $email = $phone_err = "";

if (isset($_POST['button'])) { //kaydet butonumuza basılmışsa isset() true döner bize 

  $uppercase = preg_match('@[A-Z]@', $_POST["password"]);
  $lowercase = preg_match('@[a-z]@', $_POST["password"]);
  $number    = preg_match('@[0-9]@', $_POST["password"]);
  $phone_number_validation_regex = "/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/";

  if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["namsur"]) || empty($_POST["phone"])) {
    $generel_err = "you can not leave an empty field";
  } else {
    $email = $_POST["email"];
    $fullname = $_POST["namsur"];
  }
  if ((!$uppercase || !$lowercase || !$number || (strlen($_POST["password"]) < 8)) && !empty($_POST["password"])) {
    $password_err = "A password of at least 8 characters in length, consisting of a combination of uppercase, lowercase letters and numbers, is required.";
  } else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  }
  if (!preg_match($phone_number_validation_regex, $_POST["phone"])) {
    $phone_err = "Invalid phone number";
  } else {
    $phone = $_POST["phone"];
  }




  if (isset($email) && isset($password) && empty($generel_err) && empty($password_err) && empty($sameaccount_err && empty($phone_err))) {
    $selectQuery = "SELECT * FROM userinfo WHERE email='$email'";

    $select = mysqli_query($conn, $selectQuery);
    $counter = mysqli_num_rows($select);
    if ($counter > 0) {
      $sameaccount_err = "Such a user already exists";
    } else if (empty($password_err) && empty($phone_err) && empty($sameaccount_err) && empty($generel_err)) {

      $addQuery = "insert into userinfo(fullname,phone,email,password) values('$fullname','$phone','$email','$password')";
      $add = mysqli_query($conn, $addQuery);
      if ($add) {
        session_start();
        header("location:verifying.php");
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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Hello, world!</title>
</head>

<body>

  <div class="container mt-5">
    <form action="register.php" method="POST">
      <div data-mdb-input-init class="form-outline mb-4">
        <input type="text" id="form2Example1" class="form-control 
    <?php
    if (!empty($generel_err)) {
      echo "is-invalid";
    }
    ?>
    
    " name="namsur" />
        <label class="form-label" for="form2Example1">Name Surname</label>



        <input type="tel" id="form2Example2" class="form-control <?php if (!empty($phone_err)) {
                                                                    echo "is-invalid";
                                                                  } ?>" name="phone" />
        <label class="form-label" for="form2Example2">Phone number</label>
        <div id="validationServer03Feedback" class="invalid-feedback">
          <?php
          echo $phone_err;
          ?>
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="email" id="form2Example3" class="form-control 
    <?php
    if (!empty($generel_err) || !empty($sameaccount_err)) {
      echo "is-invalid";
    }
    ?>
    
    " name="email" />
          <label class="form-label" for="form2Example3">Email address</label>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form2Example4" class="form-control 
      <?php
      if (!empty($password_err) || !empty($sameaccount_err) || !empty($generel_err)) {
        echo "is-invalid";
      }
      ?>
    
  
    " name="password" />
            <label class="form-label" for="form2Example4">Password</label>
            <div id="validationServer03Feedback" class="invalid-feedback">
              <?php
              echo $generel_err;
              ?>
            </div>
            <div id="validationServer03Feedback" class="invalid-feedback">
              <?php
              echo $password_err;
              ?>
            </div>
            <div id="validationServer03Feedback" class="invalid-feedback">
              <?php
              echo $sameaccount_err;
              ?>
            </div>

          </div>
        </div>





        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4" name="button">Sign in</button>

        <center><a class="small text-muted" href="index.php">Turn back to login page</a></center>

    </form>
  </div>

















  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>