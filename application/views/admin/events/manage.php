<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
              <div class="_buttons">
                  <?php if(has_permission('events','','create')){ ?>
              <a href="<?php echo admin_url('eventmanager/event'); ?>" class="btn btn-info pull-left display-block">
                <?php echo _l('new_eventmanager'); ?>
              </a>
              <?php } ?>
              <div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-filter" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right width300">
                  <li>
                    <a href="#" data-cview="all" onclick="dt_custom_view('','.table-eventmanager',''); return false;">
                      <?php echo _l('expenses_list_all'); ?>
                    </a>
                  </li>
                  <?php
                  // Only show this filter if user has permission for eventmanagers view otherwisde wont need this becuase by default this filter will be applied
                  if(has_permission('events','','view')){ ?>
                  <li>
                    <a href="#" data-cview="my_eventmanager" onclick="dt_custom_view('my_eventmanager','.table-eventmanager','my_eventmanager'); return false;">
                      <?php echo _l('home_my_eventmanager'); ?>
                    </a>
                  </li>
                  <?php } ?>
                  <li class="divider"></li>
                  <?php foreach($statuses as $status){ ?>
                    <li class="<?php if($status['filter_default'] == true && !$this->input->get('status') || $this->input->get('status') == $status['id']){echo 'active';} ?>">
                      <a href="#" data-cview="<?php echo 'eventmanager_status_'.$status['id']; ?>" onclick="dt_custom_view('eventmanager_status_<?php echo $status['id']; ?>','.table-eventmanager','eventmanager_status_<?php echo $status['id']; ?>'); return false;">
                        <?php echo $status['name']; ?>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
                <div class="clearfix"></div>
                <hr class="hr-panel-heading" />
              </div>
               <div class="row mbot15">
                <div class="col-md-12">
                  <h4 class="no-margin"><?php echo _l('eventmanager_summary'); ?></h4>
                  <?php
                  $_where = '(tbleventmanager.is_delete is null or tbleventmanager.is_delete = 0)';
                  if(!has_permission('events','','view')){
                    $_where = ' AND id IN (SELECT event_manager_id FROM tbleventmembers WHERE staff_id='.get_staff_user_id().')';
                  }
                  ?>
                </div>
                <div class="_filters _hidden_inputs">
                  <?php
                  echo form_hidden('my_eventmanager');
                  foreach($statuses as $status){
                   $value = $status['id'];
                     if($status['filter_default'] == false && !$this->input->get('status')){
                        $value = '';
                     } else if($this->input->get('status')) {
                        $value = ($this->input->get('status') == $status['id'] ? $status['id'] : "");
                     }
                     echo form_hidden('eventmanager_status_'.$status['id'],$value);
                    ?>
                   <div class="col-md-2 col-xs-6 border-right">
                    <?php $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id']; ?>
                    <a href="#" onclick="dt_custom_view('eventmanager_status_<?php echo $status['id']; ?>','.table-eventmanager','eventmanager_status_<?php echo $status['id']; ?>',true); return false;">
                     <h3 class="bold"><?php echo total_rows('tbleventmanager',$where); ?></h3>
                     <span style="color:<?php echo $status['color']; ?>" eventmanager-status-<?php echo $status['id']; ?>">
                     <?php echo $status['name']; ?>
                     </span>
                   </a>
                 </div>
                 <?php } ?>
               </div>
             </div>
             <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
             <?php echo form_hidden('custom_view'); ?>
             <?php
             $table_data = array(
              '#',
              _l('eventmanager_name'),
              _l('eventmanager_customer'),
              _l('tags'),
              _l('eventmanager_start_date'),
              _l('eventmanager_deadline'),
              _l('eventmanager_members'),
              );

              if(has_permission('events','','create') || has_permission('events','','edit')){
                   array_push($table_data,_l('eventmanager_billing_type'));
              }

              array_push($table_data,_l('eventmanager_status'));

              $custom_fields = get_custom_fields('eventmanager',array('show_on_table'=>1));
               foreach($custom_fields as $field){
                  array_push($table_data,$field['name']);
              }

              $table_data = do_action('eventmanager_table_columns',$table_data);
              array_push($table_data, _l('options'));

            render_datatable($table_data,'eventmanager'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/events/copy_settings'); ?>
<?php init_tail(); ?>
<script>
$(function(){
     var eventmanagersServerParams = {};
    $.each($('._hidden_inputs._filters input'),function(){
        eventmanagersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
     var eventmanagers_not_sortable = $('.table-eventmanager').find('th').length - 1;
     initDataTable('.table-eventmanager', admin_url+'eventmanager/table', [eventmanagers_not_sortable], [eventmanagers_not_sortable], eventmanagersServerParams, <?php echo do_action('eventmanager_table_default_order',json_encode(array(5,'ASC'))); ?>);
     init_ajax_search('customer', '#clientid_copy_eventmanager.ajax-search');
});
</script>
</body>
</html>
