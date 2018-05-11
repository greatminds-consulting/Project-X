<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php get_company_logo('','navbar-brand'); ?>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php do_action('suppliers_navigation_start'); ?>

        <?php if(!is_supplier_logged_in()){ ?>
        <li class="customers-nav-item-login"><a href="<?php echo site_url('suppliers/login'); ?>"><?php echo _l('clients_nav_login'); ?></a></li>
        <?php } else { 
          if(has_supplier_permission('Items')){
            ?>
              <li class="customers-nav-item-tickets"><a href="<?php echo site_url('suppliers/items'); ?>"><?php echo _l('items'); ?></a></li>
          <?php } ?>
        <?php do_action('customers_navigation_end'); ?>
        <li class="dropdown customers-nav-item-profile">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php echo suppliers_image(); ?>
            <span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeIn">
              <li class="customers-nav-item-edit-profile"><a href="<?php echo site_url('suppliers/profile'); ?>"><?php echo _l('clients_nav_profile'); ?></a></li>
             <li class="customers-nav-item-logout"><a href="<?php echo site_url('suppliers/logout'); ?>"><?php echo _l('clients_nav_logout'); ?></a></li>
           </ul>
         </li>
         <?php } ?>
         <?php do_action('suppliers_navigation_after_profile'); ?>
       </ul>
     </div>
     <!-- /.navbar-collapse -->
   </div>
   <!-- /.container-fluid -->
 </nav>
