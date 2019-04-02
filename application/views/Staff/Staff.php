<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Consultation Ustp</title>
  <link rel="stylesheet" href="<?= base_url();?>assets/css/jquery.timepicker.min.css">
  <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.css">
  <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.theme.css">
  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.css')?>" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/css/sb-admin.css')?>" rel="stylesheet">
</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1 font-weight-bold" href="<?= base_url('Signin')?>">Staff Faculty</a>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    </form>
    <a class="navbar-brand mr-2 text-white">Hello <a href="" id="yourInfo" class="navbar-brand text-white nounderline text-capitalize" data-target="#accountinfo" data-toggle="modal"><?php echo $name;?></a></a>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdown">
          <a class="dropdown-item " href="#">Settings</a>
          <a class="dropdown-item " href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item " href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
  </nav>

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('Account')?>">
          <div class="row">
              <div class="col-sm-2"><i class="fas fa-fw fa-tachometer-alt"></i></div>
              <span>Dashboard</span>
          </div>
        </a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Account/inbox')?>">
          <div class="row">
              <div class="col-sm-2"><i class="fas fa-envelope"></i></div>
              <span>Inbox</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Account/appointment')?>">
          <div class="row">
              <div class="col-sm-2"><i class="fas fa-calendar-week"></i></div>
              <span>Appointment</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Account/Schedule')?>">
          <div class="row">
              <div class="col-sm-2"><i class="fas fa-calendar-alt"></i></div>
              <span>Schedule</span>
          </div>
        </a>
      </li>
    </ul>

<div id="content-wrapper">
      <?php  
      if(isset($content)){
        $this->load->view($content);
      }  
      ?>
      <!-- /.container-fluid -->      
      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © USTP-Student 2019</span>
          </div>
        </div>
      </footer>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
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
          <a class="btn btn-primary" href="<?= base_url('Account/logout')?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Create Schedule -->
  <div class="modal fade" id="createSched" tabindex="-1" role="dialog"  aria-hidden="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Schedule</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('Account/createSched')?>" method="POST">
            <table class="table table-striped table-white text-left">
              <thead>
                <tr>
                  <th>Date.</th>
                  <th>Time_Start</th>
                  <th>Time_End</th>
                  <th>Add</th>     
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <input type="text" name="Date" id="date" value="" placeholder="YYYY-MM-DD" required="">
                  </td>
                  <td>
                    <input type="text" name="Time_Start" id="time1" value="" placeholder="HH:MM" required="">
                  </td>
                  <td>
                    <input type="text" name="Time_End" id="time2" value="" placeholder="HH:MM" required="">
                  </td>
                  <td>
                    <button class="btn btn-primary" disabled="true"><i class="fas fa-plus-circle"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          <h6 class="text-left">Note. Created Schedule must be a your vacant.</h6>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Create Schedule"></input>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- showAccountinfo -->
  <div class="modal fade" id="accountinfo" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Student Info</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="accountInfo">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
   <!-- Editmodal -->
  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Student Info</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="Edit">
          <form action="<?=base_url('Account/updateAccStaff')?>" method="POST">
        </div>
        <div class="modal-footer">
          <input class="btn btn-success" type="submit" value="Save Changes"></input>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script src="<?= base_url();?>assets/jqueryui/jquery-ui.min.js"></script>
  <script src="<?= base_url('assets/js/jquery.timepicker.min.js')?>"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/js/staffscript.js')?>"></script>

</body>

</html>
