<?php include_once(APPPATH . 'views/admin/invoices/invoices_top_stats.php'); ?>
<div class="eventmanager_invoices">
    <?php include_once(APPPATH.'views/admin/invoices/filter_params.php'); ?>
    <?php $this->load->view('admin/invoices/list_template'); ?>
</div>
