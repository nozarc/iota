        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>" class="site_title"><i class="fa fa-pie-chart"></i> <span>IoTA | <?php echo ucfirst($sess_level);?></span></a><br>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo $me->userphoto;?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo ucfirst($sess_username);?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                <?php
                $parent=$sysdb->sidebar('parent',$sess_level);
                foreach ($parent as $key => $val)
                {
                  ?>
                  <li>
                  <?php
                  $child=$sysdb->sidebar('children',$val->parent);
                  foreach ($child as $k => $v) 
                  {
                      if ($v->id==$v->parent) 
                      {
                      ?>
                        <a href="<?php echo empty($v->href)?'#':base_url($v->href);?>">
                          <i class="<?php echo $v->class;?>"></i><?php echo $v->name;?><span class="<?php echo $v->class_2; ?>"></span>
                        </a>
                        <ul class='nav child_menu'>
                      <?php
                      }
                      else
                      {
                        ?>
                        <li><a href="<?php echo base_url($v->href);?>"><?php echo $v->name;?></a></li>
                        <?php
                      }
                      ?>
                      
                      <?php
                  }
                  ?>
                    </ul>
                  </li>
                  <?php
                } 
                ?>
<!--
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
-->
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small"> <!--
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a> -->
              <a href="<?php echo base_url().'index/logout' ;?>" data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>