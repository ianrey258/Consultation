<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Consultation Ustp</title>

    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/jqueryui/jquery-ui.theme.css"
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.css')?>" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin.css')?>" rel="stylesheet">
    <style type="text/css">
    .th
    </style>
  </head>
  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <font class="navbar-brand mr-1" href="<?= base_url('Signin')?>">Student</font>
      
      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      </form>
      <a class="navbar-brand mr-2 text-white text-capitalize">Hello <?php  $str = strtoupper($name); echo $str;?> </a>
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?= base_url('Account/SDash')?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Account/Sappointment')?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Appointment</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Account/Sinbox')?>">
              <i class="fas fa-fw fa-table"></i>
              <span>Faculty Schedule</span></a>
            </li>
          </ul>
          <!-- /.container-fluid -->
          <div id="content-wrapper">
            <?php
            if(isset($content)){
            $this->load->view($content);
            }
            ?>
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
          
          <!-- /#wrapper -->
          <!-- Scroll to Top Button-->
          <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
          </a>
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
                  <form action="<?= base_url('Account/requesting')?>" method="POST">
                    <table class="table table-striped table-white text-left">
                      <thead>
                        <tr>
                          <th>Date.</th>
                          <th>Time_Start</th>
                          <th>Reason</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input class="btn btn-secondary" type="button" name="reqDate" id="reqdate" value="  <?php echo(date('Y-m-d'))?>  " placeholder="YYYY-MM-DD" required=""></input>
                          </td>
                          <td>
                            <select required="" class="form-control" name="reqtime" id="reqtime"></select>
                          </td>
                          <td>
                            <textarea name="Reason" id="Reason" value="" placeholder="Reasons" required=""></textarea> 
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Create Schedule"></input>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- Logout Modal-->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <!-- Bootstrap core JavaScript-->
          <script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
          <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
          <!-- Core plugin JavaScript-->
          <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>
          <!-- Page level plugin JavaScript-->
          <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js')?>"></script>
          <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.js')?>"></script>
          <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.js')?>"></script>
          <!-- Custom scripts for all pages-->
          <script src="<?= base_url('assets/js/sb-admin.min.js')?>"></script>
          <!-- Demo scripts for this page-->
          <script src="<?= base_url();?>assets/js/script.js"></script>
           <script src="<?= base_url();?>assets/jqueryui/jquery-ui.min.js"></script>
        </body>
      </html>