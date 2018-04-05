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
            <?php if((is_staff_member() || is_admin()) && $this->app->show_setup_menu() == true){ ?>
            <li<?php if(get_option('show_setup_menu_item_only_on_hover') == 1) { echo ' style="display:none;"'; } ?> id="setup-menu-item" class="setup-menu-item">
                <a href="#" class="open-customizer">
                    <?php echo _l('setting_bar_heading'); ?><span class=" arrow"></span></a>
                <span class="icon-thumbnail"><i class="fa fa-cog menu-icon"></i></span>
                <ul class="sub-menu">
                    <?php
                    $menu_active       = get_option('setup_menu_active');
                    $menu_active       = json_decode($menu_active);
                    $total_setup_items = count($menu_active->setup_menu_active);
                    $m                 = 0;
                    foreach ($menu_active->setup_menu_active as $item) {
                        if (isset($item->permission) && !empty($item->permission)) {
                            if (!has_permission($item->permission, '', 'view')) {
                                $total_setup_items--;
                                continue;
                            }
                        }
                        $submenu          = false;
                        $remove_main_menu = false;
                        $url              = '';
                        if (isset($item->children)) {
                            $submenu                 = true;
                            $total_sub_items_removed = 0;
                            foreach ($item->children as $_sub_menu_check) {
                                if (isset($_sub_menu_check->permission) && !empty($_sub_menu_check->permission)) {
                                    if (!has_permission($_sub_menu_check->permission, '', 'view')) {
                                        $total_sub_items_removed++;
                                    }
                                }
                            }

                            if ($total_sub_items_removed == count($item->children)) {
                                $submenu          = false;
                                $remove_main_menu = true;
                                $total_setup_items--;
                            }
                        } else {
                            // child items removed
                            if ($item->url == '#') {
                                continue;
                            }
                            $url = $item->url;
                        }
                        if ($remove_main_menu == true) {
                            continue;
                        }
                        $url = $item->url;
                        if (!_startsWith($url, 'http://') && $url != '#') {
                            $url = admin_url($url);
                        }
                        ?>
                        <li class="sub-menu-item-<?php echo $item->id; ?>">
                            <a href="<?php echo $url; ?>"><?php echo _l($item->name); ?><?php if($submenu == true){ ?><span class=" arrow"></span><?php }?></a>
                            <?php if(!empty($item->icon)){ ?>
                                <span class="icon-thumbnail"><i class="<?php echo $item->icon; ?>"></i></span>
                            <?php } ?>
                            <?php if(isset($item->children)){ ?>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php foreach($item->children as $submenu){
                                        if(isset($submenu->permission) && !empty($submenu->permission)){
                                            if(!has_permission($submenu->permission,'','view')){
                                                continue;
                                            }
                                        }
                                        $url = $submenu->url;
                                        if(!_startsWith($url,'http://')){
                                            $url = admin_url($url);
                                        }
                                        ?>
                                        <li class="sub-menu-item-<?php echo $submenu->id; ?>">
                                            <a href="<?php echo $url; ?>"><?php echo _l($submenu->name); ?></a>
                                            <?php if(!empty($submenu->icon)){ ?>
                                                <span class="icon-thumbnail"><i class="<?php echo $submenu->icon; ?>"></i></span>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php
                        $m++;
                        do_action('after_render_single_setup_menu',$m);
                    }
                    ?>
                </ul>
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
                        <a href="javascript:;" id="notification-center" class="header-icon pg pg-world" data-toggle="dropdown"><span class="bubble"></span></a>
                        <!-- START Notification Dropdown -->
                        <div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
                            <!-- START Notification -->
                            <div class="notification-panel">
                                <!-- START Notification Body-->
                                <div class="scroll-wrapper notification-body scrollable" style="position: relative;"><div class="notification-body scrollable scroll-content" style="height: auto; margin-bottom: -10px; margin-right: -10px; max-height: 10px;">
                                        <!-- START Notification Item-->
                                        <div class="notification-item unread clearfix">
                                            <!-- START Notification Item-->
                                            <div class="heading open">
                                                <a href="#" class="text-complete pull-left">
                                                    <i class="pg-map fs-16 m-r-10"></i>
                                                    <span class="bold">Carrot Design</span>
                                                    <span class="fs-12 m-l-10">David Nester</span>
                                                </a>
                                                <div class="pull-right">
                                                    <div class="thumbnail-wrapper d16 circular inline m-t-15 m-r-10 toggle-more-details">
                                                        <div><i class="fa fa-angle-left"></i>
                                                        </div>
                                                    </div>
                                                    <span class=" time">few sec ago</span>
                                                </div>
                                                <div class="more-details">
                                                    <div class="more-details-inner">
                                                        <h5 class="semi-bold fs-16">“Apple’s Motivation - Innovation <br>distinguishes between <br>A leader and a follower.”</h5>
                                                        <p class="small hint-text">Commented on john Smiths wall.<br> via pages framework.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Notification Item-->
                                            <!-- START Notification Item Right Side-->
                                            <div class="option" data-toggle="tooltip" data-placement="left" title="" data-original-title="mark as read">
                                                <a href="#" class="mark"></a>
                                            </div>
                                            <!-- END Notification Item Right Side-->
                                        </div>
                                        <!-- START Notification Body-->
                                        <!-- START Notification Item-->
                                        <div class="notification-item  clearfix">
                                            <div class="heading">
                                                <a href="#" class="text-danger pull-left">
                                                    <i class="fa fa-exclamation-triangle m-r-10"></i>
                                                    <span class="bold">98% Server Load</span>
                                                    <span class="fs-12 m-l-10">Take Action</span>
                                                </a>
                                                <span class="pull-right time">2 mins ago</span>
                                            </div>
                                            <!-- START Notification Item Right Side-->
                                            <div class="option"><a href="#" class="mark"></a></div>
                                            <!-- END Notification Item Right Side-->
                                        </div>
                                        <!-- END Notification Item-->
                                        <!-- START Notification Item-->
                                        <div class="notification-item  clearfix">
                                            <div class="heading">
                                                <a href="#" class="text-warning-dark pull-left">
                                                    <i class="fa fa-exclamation-triangle m-r-10"></i>
                                                    <span class="bold">Warning Notification</span>
                                                    <span class="fs-12 m-l-10">Buy Now</span>
                                                </a>
                                                <span class="pull-right time">yesterday</span>
                                            </div>
                                            <!-- START Notification Item Right Side-->
                                            <div class="option"><a href="#" class="mark"></a></div>
                                            <!-- END Notification Item Right Side-->
                                        </div>
                                        <!-- END Notification Item-->
                                        <!-- START Notification Item-->
                                        <div class="notification-item unread clearfix">
                                            <div class="heading">
                                                <div class="thumbnail-wrapper d24 circular b-white m-r-5 b-a b-white m-t-10 m-r-10">
                                                    <?php echo staff_profile_image($current_user->staffid,array('img','img-responsive','staff-profile-image-small','pull-left')); ?>
                                                </div>
                                                <a href="#" class="text-complete pull-left">
                                                    <span class="bold">Revox Design Labs</span>
                                                    <span class="fs-12 m-l-10">Owners</span>
                                                </a>
                                                <span class="pull-right time">11:00pm</span>
                                            </div>
                                            <!-- START Notification Item Right Side-->
                                            <div class="option" data-toggle="tooltip" data-placement="left" title="" data-original-title="mark as read"><a href="#" class="mark"></a></div>
                                            <!-- END Notification Item Right Side-->
                                        </div>
                                        <!-- END Notification Item-->
                                    </div><div class="scroll-element scroll-x" style=""><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style=""></div></div></div><div class="scroll-element scroll-y" style=""><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style=""></div></div></div></div>
                                <!-- END Notification Body-->
                                <!-- START Notification Footer-->
                                <div class="notification-footer text-center">
                                    <a href="#" class="">Read all notifications</a>
                                    <a data-toggle="refresh" class="portlet-refresh text-black pull-right" href="#">
                                        <i class="pg-refresh_new"></i>
                                    </a>
                                </div>
                                <!-- START Notification Footer-->
                            </div>
                            <!-- END Notification -->
                        </div>
                        <!-- END Notification Dropdown -->
                    </div>
                </li>
                <li class="p-r-10 inline"><a href="#" class="header-icon pg pg-link"></a></li>
                <li class="p-r-10 inline"><a href="#" class="header-icon pg pg-thumbs"></a></li>
            </ul>
            <!-- END NOTIFICATIONS LIST -->
            <a href="#" class="search-link hidden-md-down" data-toggle="search"><i class="pg-search"></i>Type anywhere to <span class="bold">search</span></a>
        </div>
        <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
                <span class="semi-bold">David</span> <span class="text-master">Nest</span>
            </div>
            <div class="dropdown pull-right hidden-md-down">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="thumbnail-wrapper d32 circular inline">
								<?php echo staff_profile_image($current_user->staffid,array('img','img-responsive','staff-profile-image-small','pull-left')); ?>
							</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                    <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
                    <a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
                    <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
                    <a href="index.php" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">Logout</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                </div>
            </div>
            <!-- END User Info-->
            <a href="#" class="pull-right header-icon pg pg-alt_menu btn-link m-l-10 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview"></a>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="content">