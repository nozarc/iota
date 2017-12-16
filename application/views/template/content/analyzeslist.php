        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Analyze <small></small></h3>
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
<?php echo empty($lol)?"<!--":null;?>
      <pre>
        <?php
        print_r(!empty($lol)?$lol:null);
        ?>
      </pre>
<?php echo empty($lol)?"-->":null;?> 
            <!-- /top tiles -->
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Analyzes<small></small></h2>
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
                          <th>Score Scale</th>
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
                            <td><?php echo $val->score_scale ;?></td>
                            <td><?php echo $val->test_type ;?></td>
                            <td><?php echo $test_date ;?></td>
                            <td><div class='btn-group' ><?php 
                            echo anchor('teacher/analyze/result/'.$val->id,'Result','class="btn btn-xs btn-primary"');
                            echo anchor('teacher/analyze/edit/'.$val->id,'Edit','class="btn btn-xs btn-success"');
                            echo anchor('teacher/analyze/delete/'.$val->id,'Delete',array('class'=>'btn btn-xs btn-danger','onclick'=>"return confirm('Are you sure to delete it?')"));
                            ?></div>
                            </td>
                          </tr>
                        <?php
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