<?php
    require 'include/config.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Invitation</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body class="bg-gradient-primary">
    <?php
          if (isset($_POST['login'])) {
          
            if ( !empty( $_POST['csrf_token'] ) ) {
              if( checkToken( $_POST['csrf_token'], 'protectedForm' ) ) {
                $log_email = mysqli_real_escape_string($conn,strip_tags(trim($_POST['log_email'])));
                $log_pass = mysqli_real_escape_string($conn,strip_tags(trim($_POST['log_pass'])));
                $pass = sha1($log_pass);
                $sql = "SELECT * FROM user WHERE user_email = '$log_email' && user_password = '$pass'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    $_SESSION['log_email'] = $log_email;
                    $_SESSION['password'] = $pass;
                    $_SESSION['log_name'] =$row['user_name'];
                    $_SESSION['sender_id'] = $row['id'];
                      echo"
                      <script>
                          window.location = 'dashboard.php';
                      </script>
                      ";
                  }
                }
                else{
                    echo "<script>
                    alert('Invalid Email and Password');
                    history.go(-1);
                    </script>";
               }
              }
          }
          else{
            echo "<script>
            alert('Invalid Access!');
            history.go(-1);
            </script>";
          }

        }
        else{
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5 login_window mx-auto">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Invitation!</h1>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <input type="hidden" name="csrf_token"
                                            value="<?php echo generateToken('protectedForm'); ?>" />
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="log_email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="log_pass">
                                        </div>

                                        <button href="index.html" class="btn btn-primary btn-user btn-block"
                                            name="login">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        }
    ?>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>