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
          if (isset($_POST['sign_up'])) {            
          
            if ( !empty( $_POST['csrf_token'] ) ) {
              if( checkToken( $_POST['csrf_token'], 'protectedForm' ) ) {
                $user_name = mysqli_real_escape_string($conn,strip_tags(trim($_POST['user_name'])));
                $user_email = mysqli_real_escape_string($conn,strip_tags(trim($_POST['user_email'])));
                $user_birthday = mysqli_real_escape_string($conn,strip_tags(trim($_POST['user_birthday'])));
                $user_pass = mysqli_real_escape_string($conn,strip_tags(trim($_POST['user_pass'])));
                $pass = sha1($user_pass);
                $sql = "SELECT * FROM user WHERE user_email = '$user_email' && user_password = '$pass'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<script>
                    alert('Invalid Email and Password');
                    history.go(-1);
                    </script>";
                   
                }
                else{
                    $sql1 = "INSERT INTO user (user_name, user_email, user_birthday, user_password, created)
                    VALUES ('$user_name', '$user_email', '$user_birthday', '$pass', '$today')";
                    if ($conn->query($sql1) === TRUE) {
                        echo "<script>
                            alert('Successfully registered!');
                            window.location = 'index.php';
                            </script>";

                      } else {
                        echo "Error: " . $sql1 . "<br>" . $conn->error;
                      }
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
        <div class="card o-hidden border-0 shadow-lg my-5 login_window mx-auto">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="pt-3" action="" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo generateToken('protectedForm'); ?>" />
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username" name="user_name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" name="user_email" required>
                                </div>

                                <div class="form-group">
                                    <input type="date" class="form-control form-control-lg" id="exampleBirthday" placeholder="Birthday" name="user_birthday" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="user_pass" required>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="sign_up">SIGN UP</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="/" class="text-primary">Login</a>
                                </div>
                            </form>
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