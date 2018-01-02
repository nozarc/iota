    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>School Classes</h3>
              </div>
            </div>
             
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add School Class</h2>
                    <div class="clearfix"></div>
                  </div>
<!--                  <pre>
                    <?php
                   // print_r($user);
                    echo "<br>";
                    print_r(isset($lol)?$lol:null);
                    print_r(isset($done)=='done'?'<br>done':'<br>nothing done');
                   ?>
                  </pre>
--> 
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <div class="x_content">
                          <?php
                          echo form_open($sess_level.'/schoolclasses/add','id="school-data" class="form-horizontal form-label-left"');
                          ?>
                          <div class="form-group">
                            <?php 
                              echo validation_errors('<div class="alert alert-warning fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>','</div>');
                            ?>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Class Name
                            </label>
                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <?php
                                $classnameform=array
                                (
                                  'id'    =>'classname',
                                  'class' =>'form-control col-md-7 col-xs-12',
                                  'required'  =>'required',
                                  'name'  =>'classname',
                                  'placeholder' =>'Class Name',
                                  'value' =>''
                                );
                                echo form_input($classnameform);
                                ?>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                  <?php
                                  //  echo anchor($sess_level,'Back','class="btn btn-success"');
                                  ?>
                                  <button type="submit" class="btn btn-primary">Add Class</button>
                              </div>
                            </div>                    
                      </div>
                    </div>
                          </form>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View School Classes</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                      <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Class</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($classes as $key => $val) {
                        ?>
                          <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo $val->classname;?></td>
                            <td>
                              <div class='btn-group' ><?php 
                              echo anchor('admin/schoolclasses/edit/'.$val->class_id,'Edit','class="btn btn-xs btn-primary"');
                              echo anchor('admin/schoolclasses/delete/'.$val->class_id,'Delete',array('class'=>'btn btn-xs btn-danger','onclick'=>"return confirm('Are you sure to delete it?')"));
                            ?></div>
                            </td>
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
          </div>
        </div>
      </div>
    </div>
  
        <!-- /page content -->

    <!-- FastClick -->
    <script src="<?php echo $_tpath;?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo $_tpath;?>/vendors/nprogress/nprogress.js"></script>
    <!-- morris.js -->
    <script src="<?php echo $_tpath;?>/vendors/raphael/raphael.min.js"></script>
    <script src="<?php echo $_tpath;?>/vendors/morris.js/morris.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo $_tpath;?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo $_tpath;?>/js/moment/moment.min.js"></script>
    <script src="<?php echo $_tpath;?>js/datepicker/daterangepicker.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $_tpath; ?>/vendors/iCheck/icheck.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $_tpath;?>/build/js/custom.min.js"></script>
<!-- Datatables -->
    <script src="<?php echo $_tpath;?>/vendors/datatables.net/js/jquery.dataTables.js"></script>
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

    <script>
      $(function() {
        Morris.Bar({
          element: 'graph_bar',
          data: [
            { "period": "Jan", "Hours worked": 80 }, 
            { "period": "Feb", "Hours worked": 125 }, 
            { "period": "Mar", "Hours worked": 176 }, 
            { "period": "Apr", "Hours worked": 224 }, 
            { "period": "May", "Hours worked": 265 }, 
            { "period": "Jun", "Hours worked": 314 }, 
            { "period": "Jul", "Hours worked": 347 }, 
            { "period": "Aug", "Hours worked": 287 }, 
            { "period": "Sep", "Hours worked": 240 }, 
            { "period": "Oct", "Hours worked": 211 }
          ],
          xkey: 'period',
          hideHover: 'auto',
          barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          ykeys: ['Hours worked', 'sorned'],
          labels: ['Hours worked', 'SORN'],
          xLabelAngle: 60,
          resize: true
        });

        $MENU_TOGGLE.on('click', function() {
          $(window).resize();
        });
      });
    </script>

    <!-- datepicker -->
    <script type="text/javascript">
      $(document).ready(function() {

        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
        }

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>
    <!-- /datepicker -->