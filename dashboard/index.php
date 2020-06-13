<?php
  require '../include/config.php';
  session_start();
  if (isset($_SESSION['log_email'])){
    $sender_id = $_SESSION['sender_id'];
    if (isset($_POST['receiver_id'])) {          
        if ( !empty( $_POST['csrf_token'] ) ) {
            if( checkToken( $_POST['csrf_token'], 'protectedForm' ) ) {
                $receiver_id = $_POST['receiver_id'];
                $inviteTitle = $_POST['inviteTitle'];
                $inviteContent = $_POST['inviteContent'];          
                $deadline = $_POST['deadline'];
                $theme = $_POST['theme'];    
                
                switch ($theme) {
                    case "weddingTheme":
                      $background = '../../assets/img/wedding.jpg';
                      break;
                    case "birthdayTheme":
                        $background = '../../assets/img/birthday.jpg';
                      break;
                    case "bigeventTheme":
                        $background = '../../assets/img/event.jpg';
                      break;
                    default:
                        $background = 'beige';
                  }

                  $newcontent = 
                  "<HTML>
                      <meta name='viewport' content='width=device-width, initial-scale=1'>
                      <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
                      <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
                      <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
                      <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>
                      <body  style='background-image: url(".$background."); background-size:cover; min-height:100vh;'>
                          <div class='container text-center' 
                                style ='width: fit-content;
                                margin: auto;
                                background: white;
                                padding: 30px;
                                margin-top: 50px;
                                border-radius: 10px;
                            >
                              <div class='invite_body'>
                                  <div class='form-group mt-5'>
                                      <h3>
                                        Invite  Title 
                                      </h3>
                                      <h4>
                                          ".$inviteTitle."
                                      </h4>
                                   </div>
                                  <div class='form-group'>
                                      <h3>
                                        Invite Content
                                      </h3>
                                      <div>
                                          ".$inviteContent."
                                      </div>
                                  <div> 
                                  <div class='form-group'>
                                      <h3>
                                          Deadline
                                      </h3>
                                      <div>
                                          ".$deadline."
                                      </div>
                                  <div>                                
                              </div>
                          </div>
                      </body>
                  </HTML>";
  
              $inviteFile ="invites/".$today."_".$time."_".$min."_".$sec.".html";
              if (!file_exists($inviteFile)) { 
                  $handle = fopen($inviteFile,'w+'); 
                  fwrite($handle,$newcontent); 
                  fclose($handle); 
              }
  
              $inviteLink = $actual_link."/dashboard"."/".$inviteFile;

              $sql1 = "INSERT INTO invitation (sender_id, receiver_id, title, content, deadline, inviteLink,  created)
              VALUES ('$sender_id', '$receiver_id', '$inviteTitle', '$inviteContent', '$deadline', '$inviteLink', '$currentTime')";
                if ($conn->query($sql1) === TRUE) {
                    echo "<script>
                        alert('Successfully Sent!');
                        history.go(-1);
                        </script>";

                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }
               
            }
            else{
              echo "<script>
              alert('Invalid Access!');
              history.go(-1);
              </script>";
            }

        }
    }
    else{
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
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin</div>
            </a>

            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>User List</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="invitation">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Received Invitation</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="sentInvitation">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Sent Invitation</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="multiInvite">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Multi Invite</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <!-- 
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li> -->

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['log_name'] ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../assets/img/avatar.jpg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="../logout" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4 registerd_card">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Registered Users</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Birthday</th>
                                            <th>Created</th>
                                            <th>Invite</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Birthday</th>
                                            <th>Created</th>
                                            <th>Invite</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM user WHERE id != $sender_id";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "                                                    
                                                        <tr>
                                                            <td>".$row['user_name']."</td>
                                                            <td>".$row['user_email']."</td>
                                                            <td>".$row['user_birthday']."</td>
                                                            <td>".$row['created']."</td>     
                                                            <td>
                                                                <a href='#' class='btn btn-primary btn-icon-split modal-btn1' data-toggle='modal' data-target='#inviteModal' data-id=".$row['id']." >
                                                                    <span class='icon text-white-50'>
                                                                        <i class='fas fa-flag'></i>
                                                                    </span>
                                                                    <span class='text'>Send Invite</span>
                                                                </a>
                                                            </td>                                                       
                                                        </tr>
                                                    ";
                                                }}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content invite_card">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create the Invitation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="invitation_form">
                        <input type="hidden" name="receiver_id" id="receiver_id">
                        <input type="hidden" name="csrf_token" value="<?php echo generateToken('protectedForm'); ?>" />
                        <div class="form-group">
                            <label for="inviteTitle">Title</label>
                            <input type="text" name="inviteTitle" id="inviteTitle" class="form-control"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="inviteContent">Please input your invitation</label>
                            <textarea name="inviteContent" id="inviteContent" class="form-control" cols="30" rows="10"
                                autocomplete="off" required></textarea>
                        </div>
                        <div class="form-group">
                            <h5>Please select the invitation deadline</h5>
                            <label for="deadline"></label>
                            <input type="date" name="deadline" id="deadline" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <h5>Please select your theme</h5>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input theme" name="theme"
                                        value="weddingTheme">
                                    Wedding
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input theme" name="theme"
                                        value="birthdayTheme">
                                    Birthday
                                </label>
                            </div>
                            <div class="form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input theme" name="theme"
                                        value="bigeventTheme">
                                    Big Event
                                </label>
                            </div>
                            <div class="form-check-inline disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input theme" name="theme" value="default"
                                        checked>
                                    Default
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary sendInvite_btn" name="sendInvite">Send</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
}
else {
  echo "<script>
  alert('Invalid Access!');
  history.go(-1);
  </script>";
} ?>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/demo/datatables-demo.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
    $(document).ready(function() {

        var weddingBack = "../assets/img/wedding.jpg";
        var birthdayBack = "../assets/img/birthday.jpg";
        var eventBack = "../assets/img/event.jpg";

        $('.modal-btn1').click(function() {
            var receiver_id = $(this).data('id');
            $('#receiver_id').val(receiver_id);
        })

        $('.sendInvite_btn').click(function() {
            $('.invitation_form').submit();
        })

        tinymce.init({
            selector: 'textarea'
        });

        $('.theme').change(function() {
            if (this.value == 'weddingTheme') {
                $(".invite_card").css("background-image", "url(" + weddingBack + ")");
                $(".invite_card").css("color", "red");
            } else if (this.value == 'birthdayTheme') {
                $(".invite_card").css("background-image", "url(" + birthdayBack + ")");
                $(".invite_card").css("color", "white");
            } else if (this.value == 'bigeventTheme') {
                $(".invite_card").css("background-image", "url(" + eventBack + ")");
                $(".invite_card").css("color", "white");
            } else if (this.value == 'default') {
                $(".invite_card").css("background", "beige");
                $(".invite_card").css("color", "#858796");
            }
        })
    })
    </script>

</body>

</html>