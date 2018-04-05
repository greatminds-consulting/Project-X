<?php
$total_qa_removed = 0;
$quickActions = $this->app->get_quick_actions_links();
foreach($quickActions as $key => $item){
    if(isset($item['permission'])){
        if(!has_permission($item['permission'],'','create')){
            $total_qa_removed++;
        }
    }
}
?>
<nav class="page-sidebar" data-pages="sidebar">
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="/uploads/company/logo.png" alt="logo" class="brand" data-src="/uploads/company/logo.png" data-src-retina="/uploads/company/logo.png" width="78" height="22">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-link hidden-md-down" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->

    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items" id="side-menu">
            <?php
            do_action('before_render_aside_menu');
            $menu_active = get_option('aside_menu_active');
            $menu_active = json_decode($menu_active);
            $m = 0;
            foreach($menu_active->aside_menu_active as $item){
                if($item->id == 'tickets' && (get_option('access_tickets_to_none_staff_members') == 0 && !is_staff_member())){
                    continue;
                } elseif($item->id == 'customers'){
                    if(!has_permission('customers','','view') && (have_assigned_customers() || (!have_assigned_customers() && has_permission('customers','','create')))){
                        $item->permission = '';
                    }
                } elseif($item->id == 'child-proposals'){
                    if((total_rows('tblproposals',array('assigned'=>get_staff_user_id())) > 0
                            && get_option('allow_staff_view_proposals_assigned') == 1)
                        && (!has_permission('proposals','','view')
                            && !has_permission('proposals','','view_own'))){
                        $item->permission = '';
                    }
                }
                if(!empty($item->permission)
                    && !has_permission($item->permission,'','view')
                    && !has_permission($item->permission,'','view_own')){
                    continue;
                }
                $submenu = false;
                $remove_main_menu = false;
                $url = '';
                if(isset($item->children)){
                    $submenu = true;
                    $total_sub_items_removed = 0;
                    foreach($item->children as $_sub_menu_check){
                        if(!empty($_sub_menu_check->permission)
                            && ($_sub_menu_check->permission != 'payments'
                                && $_sub_menu_check->permission != 'tickets'
                                && $_sub_menu_check->permission != 'customers'
                                && $_sub_menu_check->permission != 'proposals')
                        ){
                            if(!has_permission($_sub_menu_check->permission,'','view')
                                && !has_permission($_sub_menu_check->permission, '', 'view_own')){
                                $total_sub_items_removed++;
                            }
                        } elseif($_sub_menu_check->permission == 'payments' && (!has_permission('payments','','view') && !has_permission('invoices','','view_own'))){
                            $total_sub_items_removed++;
                        } elseif($_sub_menu_check->id == 'tickets' && (get_option('access_tickets_to_none_staff_members') == 0 && !is_staff_member())){
                            $total_sub_items_removed++;
                        } elseif($_sub_menu_check->id == 'customers'){
                            if(!has_permission('customers','','view') && !have_assigned_customers() && !has_permission('customers','','create')){
                                $total_sub_items_removed++;
                            }
                        } elseif($_sub_menu_check->id == 'child-proposals'){
                            if((get_option('allow_staff_view_proposals_assigned') == 0
                                    || (get_option('allow_staff_view_proposals_assigned') == 1 && total_rows('tblproposals',array('assigned'=>get_staff_user_id())) == 0))
                                && !has_permission('proposals','','view')
                                && !has_permission('proposals','','view_own')){
                                $total_sub_items_removed++;
                            }
                        }
                    }
                    if($total_sub_items_removed == count($item->children)){
                        $submenu = false;
                        $remove_main_menu = true;
                    }
                } else {
                    if($item->url == '#'){continue;}
                    $url = $item->url;
                }
                if($remove_main_menu == true){
                    continue;
                }
                $url = $item->url;
                if(!_startsWith($url,'http://') && !_startsWith($url,'https://') && $url != '#'){
                    $url = admin_url($url);
                }
                ?>
                <li class="menu-item-<?php echo $item->id; ?>">
                    <a href="<?php echo $url; ?>" >
                        <span class="title"><?php echo _l($item->name); ?></span> <?php if($submenu == true){ ?><span class=" arrow"></span><?php }?>
                    </a>
                    <span class="icon-thumbnail"><i class="<?php echo $item->icon; ?>"></i></span>
                    <?php if(isset($item->children)){ ?>
                        <ul class="sub-menu">
                            <?php foreach($item->children as $submenu){
                                if(
                                    !empty($submenu->permission)
                                    && ($submenu->permission != 'payments'
                                        && $submenu->permission != 'tickets'
                                        && $submenu->permission != 'proposals'
                                        && $submenu->permission != 'customers')
                                    && (!has_permission($submenu->permission,'','view') && !has_permission($submenu->permission, '', 'view_own'))
                                ){
                                    continue;
                                } elseif(
                                    $submenu->permission == 'payments'
                                    && (!has_permission('payments','','view') && !has_permission('invoices','','view_own'))
                                ){
                                    continue;
                                } elseif($submenu->id == 'tickets' && (get_option('access_tickets_to_none_staff_members') == 0 && !is_staff_member())){
                                    continue;
                                } elseif($submenu->id == 'customers'){
                                    if(!has_permission('customers','','view') && !have_assigned_customers() && !has_permission('customers','','create')){
                                        continue;
                                    }
                                } elseif($submenu->id == 'child-proposals'){
                                    if((get_option('allow_staff_view_proposals_assigned') == 0
                                            || (get_option('allow_staff_view_proposals_assigned') == 1 && total_rows('tblproposals',array('assigned'=>get_staff_user_id())) == 0))
                                        && !has_permission('proposals','','view')
                                        && !has_permission('proposals','','view_own')){
                                        continue;
                                    }
                                }
                                $url = $submenu->url;
                                if(!_startsWith($url,'http://') && !_startsWith($url,'https://')){
                                    $url = admin_url($url);
                                }
                                ?>
                                <li class="sub-menu-item-<?php echo $submenu->id; ?>">
                                    <a href="<?php echo $url; ?>"><?php echo _l($submenu->name); ?></a>
                                    <?php if(!empty($submenu->icon)){ ?>
                                        <span class="icon-thumbnail"><i class="<?php echo $submenu->icon; ?>"></i></span>
                                    <?php } ?>
                                </li>
                            <?php }?>
                        </ul>
                    <?php }
                    ?>
                </li>

            <?php } ?>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
<div class="page-container">
    <div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar hidden-lg-up pg pg-menu" data-toggle="sidebar"></a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
            <div class="brand inline  m-l-10 "><?php get_company_logo(get_admin_uri().'/', 'header-logo') ?></div>
            <!-- START NOTIFICATION LIST -->
            <ul class="hidden-md-down notification-list no-margin hidden-sm-down b-grey b-l b-r no-style p-l-30 p-r-20">
                <li class="p-r-10 inline">
                    <div class="dropdown">
                        <ul>
                        <li class="dropdown notifications-wrapper header-notifications" data-toggle="tooltip" title="<?php echo _l('nav_notifications'); ?>" data-placement="bottom">
                            <?php $this->load->view('admin/includes/notifications'); ?>
                        </li></ul>
                    </div>
                </li>
                <li class="p-r-10 inline">
                    <a href="#" id="top-timers" class="dropdown-toggle top-timers" data-toggle="dropdown">
                        <i class="fa fa-clock-o fa-fw fa-lg" aria-hidden="true"></i>
            <span class="label bg-success icon-total-indicator icon-started-timers<?php if ($totalTimers = count($startedTimers) == 0){ echo ' hide'; }?>">
            <?php echo count($startedTimers); ?>
            </span>
                    </a>
                    <ul class="dropdown-menu animated fadeIn started-timers-top width350" id="started-timers-top">
                        <?php $this->load->view('admin/tasks/started_timers',array('startedTimers'=>$startedTimers)); ?>
                    </ul>
                    <?php if(is_staff_member()){ ?>
                <li class="p-r-10 inline">
                    <a href="#" class="open_newsfeed"><i class="fa fa-share fa-fw fa-lg" aria-hidden="true"></i></a>
                </li>
                <?php } ?>



                </li>
                <li class="p-r-10 inline icon header-todo">
                    <a href="<?php echo admin_url('todo'); ?>" data-toggle="tooltip" title="<?php echo _l('nav_todo_items'); ?>" data-placement="bottom"><i class="fa fa-check-square-o fa-fw fa-lg"></i>
                        <span class="label bg-warning icon-total-indicator nav-total-todos<?php if($current_user->total_unfinished_todos == 0){echo ' hide';} ?>"><?php echo $current_user->total_unfinished_todos; ?></span>
                    </a>
                </li>
<!--                <li class="p-r-10 inline icon header-newsfeed">-->
<!--                <a href="#" class="open_newsfeed" data-toggle="tooltip" title="--><?php //echo _l('whats_on_your_mind'); ?><!--" data-placement="bottom"><i class="fa fa-share fa-fw fa-lg" aria-hidden="true"></i></a>-->
<!--                </li>-->
            </ul>
            <!-- END NOTIFICATIONS LIST -->
        <a href="#" class="search-link hidden-md-down" data-toggle="search"><i class="pg-search"></i>Type anywhere to <span class="bold">search</span></a>
        </div>
         <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
                <span class="semi-bold"><?php echo $current_user->firstname;?></span> <span class="text-master"><?php echo $current_user->lastname;?></span>
            </div>
            <div class="dropdown pull-right hidden-md-down">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="thumbnail-wrapper d32 circular inline">
								<?php echo staff_profile_image($current_user->staffid,array('img','img-responsive','staff-profile-image-small','pull-left')); ?>
							</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                    <a href="<?php echo admin_url('profile'); ?>" class="dropdown-item"><i class="pg-settings_small"></i><?php echo _l('nav_my_profile'); ?></a>
                    <a href="<?php echo admin_url('staff/timesheets'); ?>" class="dropdown-item"><i class="pg-outdent"></i> <?php echo _l('my_timesheets'); ?></a>
                    <a href="<?php echo admin_url('staff/edit_profile'); ?>" class="dropdown-item"><i class="pg-signals"></i> <?php echo _l('nav_edit_profile'); ?></a>
                    <a href="#" onclick="logout(); return false;" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left"><?php echo _l('nav_logout'); ?></span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                </div>
            </div>
            <!-- END User Info-->

        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="content">

            <div class="overlay hide" data-pages="search">
                <!-- BEGIN Overlay Content !-->
                <div class="overlay-content has-results m-t-20">
                    <!-- BEGIN Overlay Header !-->
                    <div class="container-fluid">
                        <!-- BEGIN Overlay Logo !-->

                        <!-- END Overlay Logo !-->
                        <!-- BEGIN Overlay Close !-->
                        <a href="#" class="close-icon-light overlay-close text-black fs-16">
                            <i class="pg-close"></i>
                        </a>
                        <!-- END Overlay Close !-->
                    </div>
                    <!-- END Overlay Header !-->
                    <div class="container-fluid">
                        <!-- BEGIN Overlay Controls !-->
                        <input  type="search" id="search_input"  class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
                        <br>
                        <div class="inline-block">
                            <div class="checkbox right">
                                <input id="checkboxn" type="checkbox" value="1" checked="checked">
                                <label for="checkboxn"><i class="fa fa-search"></i> Search within page</label>
                            </div>
                        </div>
                        <div class="inline-block m-l-10">
                            <p class="fs-13">Press enter to search</p>
                        </div>
                        <!-- END Overlay Controls !-->
                    </div>
                    <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
                    <div class="container-fluid">
          <span>
                <strong>suggestions :</strong>
            </span>
                        <span id="overlay-suggestions"></span>
                        <br>
                        <div class="search-results m-t-40">
                            <p class="bold">Pages Search Results</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- BEGIN Search Result Item !-->
                                    <div class="" id="search_results">

                                    </div>
                                    <!-- END Search Result Item !-->


                                </div>
                                <div class="col-md-6">
                                    <!-- BEGIN Search Result Item !-->
                                    <div class="">
                                        <!-- BEGIN Search Result Item Thumbnail !-->
                                        <div class="thumbnail-wrapper d48 circular bg-info text-white inline m-t-10">
                                            <div><i class="fa fa-facebook large-text "></i>
                                            </div>
                                        </div>
                                        <!-- END Search Result Item Thumbnail !-->
                                        <div class="p-l-10 inline p-t-5">
                                            <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on facebook</h5>
                                            <p class="hint-text">via facebook</p>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item !-->
                                    <!-- BEGIN Search Result Item !-->
                                    <div class="">
                                        <!-- BEGIN Search Result Item Thumbnail !-->
                                        <div class="thumbnail-wrapper d48 circular bg-complete text-white inline m-t-10">
                                            <div><i class="fa fa-twitter large-text "></i>
                                            </div>
                                        </div>
                                        <!-- END Search Result Item Thumbnail !-->
                                        <div class="p-l-10 inline p-t-5">
                                            <h5 class="m-b-5">Tweats on<span class="semi-bold result-name"> ice cream</span></h5>
                                            <p class="hint-text">via twitter</p>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item !-->
                                    <!-- BEGIN Search Result Item !-->
                                    <div class="">
                                        <!-- BEGIN Search Result Item Thumbnail !-->
                                        <div class="thumbnail-wrapper d48 circular text-white bg-danger inline m-t-10">
                                            <div><i class="fa fa-google-plus large-text "></i>
                                            </div>
                                        </div>
                                        <!-- END Search Result Item Thumbnail !-->
                                        <div class="p-l-10 inline p-t-5">
                                            <h5 class="m-b-5">Circles on<span class="semi-bold result-name"> ice cream</span></h5>
                                            <p class="hint-text">via google plus</p>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item !-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Overlay Search Results !-->
                </div>
                <!-- END Overlay Content !-->
            </div>
