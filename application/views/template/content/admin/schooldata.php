    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>School Information</h3>
              </div>
            </div>
             
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit School Data</h2>
                    <div class="clearfix"></div>
                  </div>
<!--                  <pre>
                    <?php
                   // print_r($user);
                    echo "<br>";
                    print_r(isset($lol)?$lol:null);
                    print_r($done=='done'?'<br>done':'<br>nothing done');
                   ?>
                  </pre>
 --> 
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <div class="x_content">
                          <?php
                          echo form_open($sess_level.'/schooldata/data','id="school-data" class="form-horizontal form-label-left"');
                          ?>
                          <div class="form-group">
                            <?php 
                              echo validation_errors('<div class="alert alert-warning fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>','</div>');
                            ?>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> School Name
                            </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $schoolnameform=array
                                (
                                  'id'    =>'schoolname',
                                  'class' =>'form-control col-md-7 col-xs-12',
                                  'required'  =>'required',
                                  'name'  =>'schoolname',
                                  'placeholder' =>'School Name',
                                  'value' =>isset($school['schoolname'])?$school['schoolname']:''
                                );
                                echo form_input($schoolnameform);
                                
                                ?>
                              </div>
                            </div>

                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                  $addressform=array
                                  (
                                    'id'  =>'schooladdress',
                                    'name'  =>'schooladdress',
                                    'rows'  =>'5',
                                    'class' =>'form-control',
                                    'placeholder' =>'School Address',
                                    'value' =>isset($school['schooladdress'])?$school['schooladdress']:''
                                  );
                                  echo form_textarea($addressform);
                                ?>
                              </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">School Email
                            </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $emailx=array
                                (
                                  'id'    =>'schoolemail',
                                  'class' =>'form-control col-md-7 col-xs-12',
                                  'name'  =>'schoolemail',
                                  'placeholder' =>'School Email',
                                  'value' =>isset($school['schoolemail'])?$school['schoolemail']:''
                                );
                                echo form_input($emailx);
                                ?>
                              </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">School Phone Number
                            </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $phone=array
                                (
                                  'id'    =>'schoolphone',
                                  'class' =>'form-control col-md-7 col-xs-12',
                                  'name'  =>'schoolphone',
                                  'placeholder' =>'School\'s Phone Number',
                                  'value' =>isset($school['schoolphone'])?$school['schoolphone']:''
                                );
                                echo form_input($phone);
                                ?>
                              </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">School Website
                            </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $web=array
                                (
                                  'id'    =>'schoolwebsite',
                                  'class' =>'form-control col-md-7 col-xs-12',
                                  'name'  =>'schoolwebsite',
                                  'placeholder' =>'School\'s Website',
                                  'value' =>isset($school['schoolwebsite'])?$school['schoolwebsite']:''
                                );
                                echo form_input($web);
                                ?>
                              </div>
                            </div>                    
                           <!--   <div class="ln_solid"></div>-->
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?php
                                  //  echo anchor($sess_level,'Back','class="btn btn-success"');
                                  ?>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit School Logo</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="x_content">
                      <!--user photo-->
                      <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                        <div class="profile_img">
                          <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class=" avatar-view img-rounded" src="
                            <?php 
                              echo isset($school['schoollogo'])?$school['schoollogo']:'school_logo.png'; // ganti logo defaultnya
                            ?>
                            " alt="School Logo" title="Change School Logo" style='height:200px; width:200px'>
                          </div>
                        </div>
                      </div>
                      <!--/user photo-->
                      <?php
                      echo form_open_multipart($sess_level.'/schooldata/logo','id="school-logo" class="form-horizontal form-label-left"');
                      ?>
                      <div class="form-group">
                        <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3 well well-sm">
                          <?php
                          if(isset($error))
                          {
                            echo '<div class="alert alert-warning fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$error.'</div>';
                          }
                          $attphoto=array
                            (
                              'name'    =>'school_logo',
                              'accept'  => 'image/*',
                            );
                          echo form_upload($attphoto);
                          ?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <?php
                          //  echo anchor($sess_level.'/schooldata/','Back','class="btn btn-success"');
                            $submit=array
                            (
                              'name'  =>'submit',
                              'class' =>'btn btn-primary',
                              'value' =>'Upload',
                            );
                            echo form_submit($submit);
                          ?>
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