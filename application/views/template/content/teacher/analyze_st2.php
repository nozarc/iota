         <!-- page content -->        <div class="right_col" role="main">          <div class="">            <div class="page-title">              <div class="title_left">                <h3>New Analyze</h3>              </div>            </div>            <div class="clearfix"></div>            <div class="row">              <div class="col-md-12 col-sm-12 col-xs-12">                <div class="x_panel">                  <div class="x_title">                    <h2>Insert Answers Key</i></small></h2>                    <ul class="nav navbar-right panel_toolbox">                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>                      </li>                      <li><a class="close-link"><i class="fa fa-close"></i></a>                      </li>                    </ul>                    <div class="clearfix"></div>                  </div><?php echo empty($lol)?"<!--":null;?>                  <pre>                    <?php                    print_r(!empty($lol)?$lol:null);                    ?>                    <br>                    <?php                    print_r(!empty($lol2)?$lol2:null);                    ?>                  </pre><?php echo empty($lol)?"-->":null;?>                    <div class="x_content" id="content">                  <?php                    switch (true) {                        case isset($newanalyze):                          extract($newanalyze);                          $url='/new';                          break;                        case isset($editanalyze):                          extract($editanalyze);                          $url='/edit/'.$st1_id;                          break;                    }                  ?>                  <form action="<?php echo $base_url; ?>teacher/analyze/<?php echo $url; ?>/step_two" data-parsley-validate="" class="form-horizontal form-label-left" method="post" accept-charset="utf-8" >                                          <?php                         echo validation_errors('<div class="alert alert-warning fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>','</div>');                      ?>                      <div class="form-group">                      <br />                        <div class="row">                          <div class="col-md-10 col-sm-10 col-xs-10">                            <div class="ans">                                                          </div>                          </div>                          <div class="col-md-2 col-sm-2 col-xs-2 btn-group btn-group-vertical">                            <input class="form-control" id="inAdd" type="number" value="5">                            <button class="btn btn-info" id="btnadd" type="button">Add More</button>                          </div>                        </div>                      </div>                      <div class="ln_solid"></div>                  <div class="x_title">                    <h2>Insert Questions and Measured Capabilities</i></small></h2>                    <div class="clearfix"></div>                  </div>                    <div class="quest">                                          </div>                      <div class="ln_solid"></div>                      <div class="form-group">                        <div class="row">                          <div class="col-md-6 col-sm-6 col-xs-12">                            <div class="pull-left">                            </div>                          </div>                          <div class="col-md-10 col-sm-6 col-xs-12">                            <div class="pull-right">                              <?php                                echo anchor('teacher/analyze/'.$url.'/step_one','Back','class="btn btn-success"');                              ?>                              <button type="submit" class="btn btn-primary">Next</button>                            </div>                          </div>                        </div>                      </div>                    </form>                  </div>                </div><!---->              </div>            </div>          </div>        </div>        <!-- /page content -->    <!-- FastClick -->    <script src="<?php echo $_tpath; ?>/vendors/fastclick/lib/fastclick.js"></script>    <!-- NProgress -->    <script src="<?php echo $_tpath; ?>/vendors/nprogress/nprogress.js"></script>    <!-- bootstrap-progressbar -->    <script src="<?php echo $_tpath; ?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>    <!-- iCheck -->    <script src="<?php echo $_tpath; ?>/vendors/iCheck/icheck.min.js"></script>    <!-- bootstrap-daterangepicker -->    <script src="<?php echo $_tpath; ?>/js/moment/moment.min.js"></script>    <script src="<?php echo $_tpath; ?>/js/datepicker/daterangepicker.js"></script>    <!-- bootstrap-wysiwyg -->    <script src="<?php echo $_tpath; ?>/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>    <script src="<?php echo $_tpath; ?>/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>    <script src="<?php echo $_tpath; ?>/vendors/google-code-prettify/src/prettify.js"></script>    <!-- jQuery Tags Input -->    <script src="<?php echo $_tpath; ?>/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>    <!-- Switchery -->    <script src="<?php echo $_tpath; ?>/vendors/switchery/dist/switchery.min.js"></script>    <!-- Select2 -->    <script src="<?php echo $_tpath; ?>/vendors/select2/dist/js/select2.full.min.js"></script>    <!-- Parsley -->    <script src="<?php echo $_tpath; ?>/vendors/parsleyjs/dist/parsley.min.js"></script>    <!-- Autosize -->    <script src="<?php echo $_tpath; ?>/vendors/autosize/dist/autosize.min.js"></script>    <!-- jQuery autocomplete -->    <script src="<?php echo $_tpath; ?>/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>    <!-- starrr -->    <script src="<?php echo $_tpath; ?>/vendors/starrr/dist/starrr.js"></script>   <div id="lol">        </div>   <!--automate add form -->   <script type="text/javascript">      $(document).ready(function()      {        var num = 1;        <?php if(!empty($st2_data))        {          $num=count($st2_data['answer_key']);          $ans=$st2_data['answer_key'];          $qst=$st2_data['question'];          $meas=$st2_data['measured_capability'];          echo "var answer_key=".json_encode($ans).";\n";          echo "var question=".json_encode($qst).";\n";          echo "var measured_capability=".json_encode($meas).";\n";          ?>        function lastData() {          for (var lastdat = 1; lastdat <= <?php echo $num;?>; lastdat++) {              if (lastdat%10==0) {                $(".ans").append( '<div class="col-md-1 col-sm-1 col-xs-2 astu"><input type="text" maxlength="1" name="answer_key['+lastdat+']" value="'+answer_key[lastdat]+'" class="form-control answer_key" placeholder="'+lastdat+'"></div>');                $(".ans").append("<br/><br/><br/>");              }              else{                $(".ans").append( '<div class="col-md-1 col-sm-1 col-xs-2 astu"><input type="text" maxlength="1" name="answer_key['+lastdat+']" value="'+answer_key[lastdat]+'" class="form-control answer_key" placeholder="'+lastdat+'"></div>');              }              $(".quest").append('<div class="form-group"><div class="row"><label class="control-label col-md-1 col-sm-1 col-xs-1">No. '+lastdat+'</label><div class="col-md-5 col-sm-5 col-xs-5 astu"><textarea name="question['+lastdat+']" class="form-control question" style="height: 34px" placeholder="Question No. '+lastdat+'">'+question[lastdat]+'</textarea></div><div class="col-md-5 col-sm-5 col-xs-5"><input type="text" value="'+measured_capability[lastdat]+'" name="measured_capability['+lastdat+']" class="form-control measured_capability" placeholder="Capability No.'+lastdat+'"></div></div></div>');          }          num=num+<?php echo $num;?>;        }        $("#content").onload=lastData();        <?php        }        else{          ?>          function newData() {            var initAdd=$('#inAdd').val();            for (var i = 1; i <= initAdd; i++) {              $(".ans").append( '<div class="col-md-1 col-sm-1 col-xs-2 astu"><input type="text" maxlength="1" name="answer_key['+num+']" class="form-control answer_key" placeholder="'+num+'"></div>');              $(".quest").append('<div class="form-group"><div class="row"><label class="control-label col-md-1 col-sm-1 col-xs-1">No. '+num+'</label><div class="col-md-5 col-sm-5 col-xs-5 astu"><textarea name="question['+num+']" class="form-control question" style="height: 34px" placeholder="Question No. '+num+'"></textarea></div><div class="col-md-5 col-sm-5 col-xs-5"><input type="text" name="measured_capability['+num+']" class="form-control measured_capability" placeholder="Capability No.'+num+'"></div></div></div>');              num++;            }          }          $("#content").onload=newData();          <?php        }        ?>        $("#btnadd").click(function(){          var inAdd = $('#inAdd').val();          for (var i = 1; i <= inAdd; i++) {            if (num%10==0) {              $(".ans").append( '<div class="col-md-1 col-sm-1 col-xs-2 astu"><input type="text" maxlength="1" name="answer_key['+num+']" class="form-control answer_key" placeholder="'+num+'"></div>');              $(".ans").append("<br/><br/><br/>");            }            else{              $(".ans").append( '<div class="col-md-1 col-sm-1 col-xs-2 astu"><input type="text" maxlength="1" name="answer_key['+num+']" class="form-control answer_key" placeholder="'+num+'"></div>');            }            $(".quest").append('<div class="form-group"><div class="row"><label class="control-label col-md-1 col-sm-1 col-xs-1">No. '+num+'</label><div class="col-md-5 col-sm-5 col-xs-5 astu"><textarea name="question['+num+']" class="form-control question" style="height: 34px" placeholder="Question No. '+num+'"></textarea></div><div class="col-md-5 col-sm-5 col-xs-5"><input type="text" name="measured_capability['+num+']" class="form-control measured_capability" placeholder="Capability No.'+num+'"></div></div></div>');            num++;          }                  });      });    </script><!--/automate add form -->        <!-- bootstrap-daterangepicker -->    <script>      $(document).ready(function() {        $('.datex').daterangepicker({          singleDatePicker: true,          calender_style: "picker_4"        }, function(start, end, label) {          console.log(start.toISOString(), end.toISOString(), label);        });      });    </script>    <!-- /bootstrap-daterangepicker -->    <!-- bootstrap-wysiwyg -->    <script>      $(document).ready(function() {        function initToolbarBootstrapBindings() {          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',              'Times New Roman', 'Verdana'            ],            fontTarget = $('[title=Font]').siblings('.dropdown-menu');          $.each(fonts, function(idx, fontName) {            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));          });          $('a[title]').tooltip({            container: 'body'          });          $('.dropdown-menu input').click(function() {              return false;            })            .change(function() {              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');            })            .keydown('esc', function() {              this.value = '';              $(this).change();            });          $('[data-role=magic-overlay]').each(function() {            var overlay = $(this),              target = $(overlay.data('target'));            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());          });          if ("onwebkitspeechchange" in document.createElement("input")) {            var editorOffset = $('#editor').offset();            $('.voiceBtn').css('position', 'absolute').offset({              top: editorOffset.top,              left: editorOffset.left + $('#editor').innerWidth() - 35            });          } else {            $('.voiceBtn').hide();          }        }        function showErrorAlert(reason, detail) {          var msg = '';          if (reason === 'unsupported-file-type') {            msg = "Unsupported format " + detail;          } else {            console.log("error uploading file", reason, detail);          }          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');        }        initToolbarBootstrapBindings();        $('#editor').wysiwyg({          fileUploadError: showErrorAlert        });        window.prettyPrint;        prettyPrint();      });    </script>    <!-- /bootstrap-wysiwyg -->    <!-- Select2 -->    <script>      $(document).ready(function() {        $(".select2_single").select2({          placeholder: "Select a state",          allowClear: true        });        $(".select2_group").select2({});        $(".select2_multiple").select2({          maximumSelectionLength: 4,          placeholder: "With Max Selection limit 4",          allowClear: true        });      });    </script>    <!-- /Select2 -->    <!-- jQuery Tags Input -->    <script>      function onAddTag(tag) {        alert("Added a tag: " + tag);      }      function onRemoveTag(tag) {        alert("Removed a tag: " + tag);      }      function onChangeTag(input, tag) {        alert("Changed a tag: " + tag);      }      $(document).ready(function() {        $('#tags_1').tagsInput({          width: 'auto'        });      });    </script>    <!-- /jQuery Tags Input -->    <!-- Parsley -->    <script>      $(document).ready(function() {        $.listen('parsley:field:validate', function() {          validateFront();        });        $('#demo-form .btn').on('click', function() {          $('#demo-form').parsley().validate();          validateFront();        });        var validateFront = function() {          if (true === $('#demo-form').parsley().isValid()) {            $('.bs-callout-info').removeClass('hidden');            $('.bs-callout-warning').addClass('hidden');          } else {            $('.bs-callout-info').addClass('hidden');            $('.bs-callout-warning').removeClass('hidden');          }        };      });      $(document).ready(function() {        $.listen('parsley:field:validate', function() {          validateFront();        });        $('#demo-form2 .btn').on('click', function() {          $('#demo-form2').parsley().validate();          validateFront();        });        var validateFront = function() {          if (true === $('#demo-form2').parsley().isValid()) {            $('.bs-callout-info').removeClass('hidden');            $('.bs-callout-warning').addClass('hidden');          } else {            $('.bs-callout-info').addClass('hidden');            $('.bs-callout-warning').removeClass('hidden');          }        };      });      try {        hljs.initHighlightingOnLoad();      } catch (err) {}    </script>    <!-- /Parsley -->    <!-- Autosize -->    <script>      $(document).ready(function() {        autosize($('.resizable_textarea'));      });    </script>    <!-- /Autosize -->    <!-- jQuery autocomplete -->    <script>      $(document).ready(function() {        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"�land Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barth�lemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"C�te d�Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"R�union",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"S�o Tom� and Pr�ncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };        var countriesArray = $.map(countries, function(value, key) {          return {            value: value,            data: key          };        });        // initialize autocomplete with custom appendTo        $('#autocomplete-custom-append').autocomplete({          lookup: countriesArray,          appendTo: '#autocomplete-container'        });      });    </script>    <!-- /jQuery autocomplete -->    <!-- Starrr -->    <script>      $(document).ready(function() {        $(".stars").starrr();        $('.stars-existing').starrr({          rating: 4        });        $('.stars').on('starrr:change', function (e, value) {          $('.stars-count').html(value);        });        $('.stars-existing').on('starrr:change', function (e, value) {          $('.stars-count-existing').html(value);        });      });    </script>    <!-- /Starrr -->