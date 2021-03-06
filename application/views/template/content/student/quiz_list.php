        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Quiz <small></small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div> 
            <!-- /top tiles -->
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Quizzes Result<small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Subject</th>
                          <th>Test Type</th>
                          <th>Test Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                      if(isset($table)){
                        foreach ($table as $k => $val) 
                          {
                            $k=$k+1;
                            $date1=date_create($val->test_date);
                            $test_date=date_format($date1,'l, j F Y');
                        ?>        
                          <tr>
                            <td><?php echo $k; ;?></td>
                            <td><?php echo $val->subject ;?></td>
                            <td><?php echo $val->test_type ;?></td>
                            <td><?php echo $test_date ;?></td>
                            <td>
                              <div class='btn-group' >
                                <button type="button" class='btn btn-xs btn-primary' data-toggle='modal' data-target='#detail_<?php echo $val->id; ?>' ><span class="fa fa-eye"></span> Detail</a>
                              </div>
                            </td>
                          </tr>
                        <?php
                          }
                      }
                      ?>
                      </tbody>
                    </table>
                    <div id="modals">
                    <?php 
                    if (isset($table)) {
                      foreach ($table as $kdetail => $vdetail) {
                        $date1=date_create($vdetail->test_date);
                        $test_date=date_format($date1,'l, j F Y');
                        ?>
                        <div class="modal fade" id="detail_<?php echo $vdetail->id; ?>">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="fa fa-close"></span>
                                </button>
                                <h4 class="modal-title" id="<?php echo $vdetail->subject; ?>" ><?php echo $vdetail->subject.' ('.$vdetail->test_type.')';?></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-sm-2 col-md-2 col-xs-4">
                                    <h5>Subject</h5>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-xs-4">
                                    <h5>: <?php echo $vdetail->subject; ?></h5>
                                  </div>
                                  <div class="col-md-2 col-sm-2 col-xs-4">
                                    <h5>Test Date</h5>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-xs-4">
                                    <h5>: <?php echo $test_date; ?></h5>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-2 col-md-2 col-xs-4">
                                    <h5>Test Type</h5>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-xs-4">
                                    <h5>: <?php echo $vdetail->test_type; ?></h5>
                                  </div>
                                  <div class="col-md-2 col-sm-2 col-xs-4">
                                    <h5>Score</h5>
                                  </div>
                                  <div class="col-md-4 col-sm-4 col-xs-4">
                                    <h5>: <?php echo $vdetail->score; ?></h5>
                                  </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                  <div class="accordion" id="accordion_<?php echo $vdetail->id;?>" aria-multiselectable="true">
                                    <div class="panel">
                                      <a href="#quizAnswer_<?php echo $vdetail->id;?>" class="panel-heading" data-toggle='collapse' parent='accordion_<?php echo $vdetail->id;?>' id='headOne_<?php echo $vdetail->id;?>;?>' aria-expanded="true" aria-controls="quizAnswer_<?php echo $vdetail->id;?>">
                                        <h4 class="panel-title">Quiz and Answer</h4>
                                      </a>
                                      <div id="quizAnswer_<?php echo $vdetail->id;?>" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headOne_<?php echo $vdetail->id;?>">
                                        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap">
                                          <thead>
                                            <tr>
                                              <th>No.</th>
                                              <th>Question</th>
                                              <th>Correct Ans.</th>
                                              <th>Your Ans.</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            $qWA=$quizWithAnswer[$vdetail->id]['quiz'];
                                            foreach ($qWA as $no => $vqWA) {
                                            ?>
                                            <tr>
                                              <td><?php echo $no; ?></td>
                                              <td><?php echo $vqWA['question']; ?></td>
                                              <td><?php echo $vqWA['answer_key']; ?></td>
                                              <td class="<?php echo ($vqWA['answer']!=$vqWA['answer_key'])?"alert alert-danger":null; ?>"><?php echo $vqWA['answer']; ?></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <div class="panel">
                                      <a href="#remedial_<?php echo $vdetail->id;?>" class="panel-heading" data-toggle='collapse' parent='accordion_<?php echo $vdetail->id;?>' id='headTwo_<?php echo $vdetail->id;?>;?>' aria-expanded="true" aria-controls="remedial_<?php echo $vdetail->id;?>">
                                        <h4 class="panel-title">Remedial</h4>
                                      </a>
                                      <div id="remedial_<?php echo $vdetail->id;?>" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headTwo_<?php echo $vdetail->id;?>">
                                        <table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap">
                                          <thead>
                                            <tr>
                                              <th>No.</th>
                                              <th>Remedial</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $totalRemedial=0;
                                          foreach ($qWA as $no2 => $vremedial) {
                                            if ($vremedial['answer_key']!=$vremedial['answer']) {
                                              $totalRemedial++;
                                            ?>
                                            <tr>
                                              <td><?php echo $no2; ?></td>
                                              <td><?php echo $vremedial['measured_capability']; ?></td>
                                            </tr>
                                            <?php
                                            }
                                          }
                                          if ($totalRemedial==0) {
                                            ?>
                                            <tr>
                                              <td colspan="2" align="center" class="alert alert-success"><b>You have no remedial</b></td>
                                            </tr>
                                            <?php
                                          }
                                            ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div> 
                        <?php
                      }
                    }
                    ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
    <!-- FastClick -->
    <script src="<?php echo $_tpath;?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $_tpath;?>/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="<?php echo $_tpath;?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        
        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->