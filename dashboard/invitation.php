<?php
  require '../include/config.php';
  session_start();
  if (isset($_SESSION['log_email'])){
    $sender_id = $_SESSION['sender_id'];

    if (isset($_POST['accept_id'])) {          
        if ( !empty( $_POST['csrf_token'] ) ) {
            if( checkToken( $_POST['csrf_token'], 'protectedForm' ) ) {
                $accept_id = $_POST['accept_id'];   
                $accept_text = $_POST['acceptText'];                     

                $sql1 = "UPDATE invitation SET decide = 1, rejectText = '".$accept_text."', checktime = '$currentTime' WHERE id = '$accept_id'";
                if ($conn->query($sql1) === TRUE) {
                    echo "<script>
                        alert('Invitation Accepted!');
                        history.go(-1);
                        </script>";

                  } else {
                    echo "Error: " . $sql1 . "<br>" . $conn->error;
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
    else if(isset($_POST['reject_id']))
    {      
        if ( !empty( $_POST['csrf_token'] ) ) {
            if( checkToken( $_POST['csrf_token'], 'protectedForm' ) ) {
                $reject_id = $_POST['reject_id'];
                $rejectText = $_POST['rejectText'];

                $sql3 = "UPDATE invitation SET decide = 2, rejectText = '".$rejectText."', checktime = '$currentTime' WHERE id = '$reject_id'";
                if ($conn->query($sql3) === TRUE) {
                    echo "<script>
                        alert('Invitation Rejected!');
                        history.go(-1);
                        </script>";

                  } else {
                    echo "Error: " . $sql3 . "<br>" . $conn->error;
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
                <a class="nav-link" href="index">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="index">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>User List</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Received Invitation</span>
                </a>
            </li>

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

            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
            </li>

            <hr class="sidebar-divider">

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
                    <div class="card shadow mb-4 pending_card">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Pending Invitation List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Accept/Reject</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Accept/Reject</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM invitation WHERE receiver_id = $sender_id && decide = 0";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $sender = $row['sender_id'];
                                                    $sql2 = "SELECT * FROM user WHERE id = $sender";
                                                    $result2 = $conn->query($sql2);
                                                    if ($result2->num_rows > 0) {
                                                        while($row2 = $result2->fetch_assoc()) {
                                                            $sender_name = $row2['user_name'];
                                                            $sender_email = $row2['user_email'];
                                                        }
                                                    }
                                                    echo "                                                    
                                                        <tr>
                                                            <td>".$sender_name."</td>
                                                            <td>".$sender_email."</td>
                                                            <td>".$row['title']."</td>
                                                            <td>".$row['content']."</td>   
                                                            <td>".$row['deadline']."</td>
                                                            <td>
                                                                <a href='".$row['inviteLink']."' target='_blank'>
                                                                    ".$row['inviteLink']."
                                                                </a>
                                                            </td>  
                                                            <td style = 'display: inline-flex'> 

                                                                <a class='btn btn-success btn-circle btn-sm accept_btn mx-2 text-white' data-toggle='modal' data-target='#acceptModal' data-id=".$row['id']." >
                                                                    <i class='fas fa-check'></i>
                                                                </a>
                                                               
                                                                <a href='' class='btn btn-danger btn-circle btn-sm reject_btn' data-toggle='modal' data-target='#rejectModal' data-id=".$row['id']." >
                                                                    <i class='fas fa-trash'></i>
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

                <div class="container-fluid">                
                    <div class="card shadow mb-4 accepte_card">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Accepted Invitation List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable1" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Comment</th>
                                            <th>Accepted</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Comment</th>
                                            <th>Accepted</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM invitation WHERE receiver_id = $sender_id && decide = 1";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $sender = $row['sender_id'];
                                                    $sql2 = "SELECT * FROM user WHERE id = $sender";
                                                    $result2 = $conn->query($sql2);
                                                    if ($result2->num_rows > 0) {
                                                        while($row2 = $result2->fetch_assoc()) {
                                                            $sender_name = $row2['user_name'];
                                                            $sender_email = $row2['user_email'];
                                                        }
                                                    }
                                                    echo "                                                    
                                                        <tr>
                                                            <td>".$sender_name."</td>
                                                            <td>".$sender_email."</td>
                                                            <td>".$row['title']."</td>
                                                            <td>".$row['content']."</td>
                                                            <td>".$row['deadline']."</td>
                                                            <td>
                                                                <a href='".$row['inviteLink']."' target='_blank'>
                                                                    ".$row['inviteLink']."
                                                                </a>
                                                            </td>       
                                                            <td>".$row['rejectText']." </td>
                                                            <td> 
                                                                    <button class='btn btn-success btn-circle btn-sm'>
                                                                        <i class='fas fa-check'></i>
                                                                    </button>
                                                            </td>                                                       
                                                        </tr>
                                                    ";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="card shadow mb-4 rejected_card">
                        <div class="card-header py-3">
                            <h3 class="m-0 font-weight-bold text-primary">Rejected Invitation List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable2" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Comment</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Deadline</th>
                                            <th>Link</th>
                                            <th>Comment</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM invitation WHERE receiver_id = $sender_id && decide = 2";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $sender = $row['sender_id'];
                                                    $sql2 = "SELECT * FROM user WHERE id = $sender";
                                                    $result2 = $conn->query($sql2);
                                                    if ($result2->num_rows > 0) {
                                                        while($row2 = $result2->fetch_assoc()) {
                                                            $sender_name = $row2['user_name'];
                                                            $sender_email = $row2['user_email'];
                                                        }
                                                    }
                                                    echo "                                                    
                                                        <tr>
                                                            <td>".$sender_name."</td>
                                                            <td>".$sender_email."</td>
                                                            <td>".$row['title']."</td>
                                                            <td>".$row['content']."</td> 
                                                            <td>".$row['deadline']."</td>
                                                            <td>
                                                                <a href='".$row['inviteLink']."' target='_blank'>
                                                                    ".$row['inviteLink']."
                                                                </a>
                                                            </td>      
                                                            <td>".$row['rejectText']." </td>
                                                            <td> 
                                                                    <button class='btn btn-danger btn-circle btn-sm'>
                                                                        <i class='fas fa-trash'></i>
                                                                    </button>
                                                            </td>  
                                                        </tr>
                                                    ";
                                                }
                                            }
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

    <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave the Opinion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="accept_form">
                        <input type="hidden" name="accept_id" id="accept_id">
                        <input type="hidden" name="csrf_token" value="<?php echo generateToken('protectedForm'); ?>" />
                        
                        <div class="form-group">
                            <label for="acceptText">Please leave your Opinion</label>
                            <textarea name="acceptText" id="acceptText" class="form-control" cols="30"
                                rows="10" autocomplete="off" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary accept_invite" name="accept_invite">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave the Reason</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="reject_form">
                        <input type="hidden" name="reject_id" id="reject_id">
                        <input type="hidden" name="csrf_token" value="<?php echo generateToken('protectedForm'); ?>" />
                        
                        <div class="form-group">
                            <label for="rejectText">Please leave your reason</label>
                            <textarea name="rejectText" id="rejectText" class="form-control" cols="30"
                                rows="10" autocomplete="off" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary reject_invite" name="reject_invite">Reject</button>
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
        $('.reject_btn').click(function() {
            var reject_id = $(this).data('id');
            $('#reject_id').val(reject_id);
        })

        $('.reject_invite').click(function() {           
            $('.reject_form').submit();
        })

        $('.accept_btn').click(function() {
            var accept_id = $(this).data('id');
            $('#accept_id').val(accept_id);
        })

        $('.accept_invite').click(function() {           
            $('.accept_form').submit();
        })

        $('#dataTable1').DataTable();
        $('#dataTable2').DataTable();

        // tinymce.init({
        //     selector: 'textarea'
        // });
    })
    </script>

</body>

</html>