<div class="row">
   <div class="col-md-6 border-right eventmanager-overview-left">
      <div class="row">
       <div class="col-md-12">
         <p class="eventmanager-info bold font-size-14">
            <?php echo _l('overview'); ?>
         </p>
      </div>
      <?php if(count($eventmanager->shared_vault_entries) > 0){ ?>
      <?php $this->load->view('admin/clients/vault_confirm_password'); ?>
      <div class="col-md-12">
         <p class="bold">
           <a href="#" onclick="slideToggle('#eventmanager_vault_entries'); return false;">
             <i class="fa fa-cloud"></i> <?php echo _l('eventmanager_shared_vault_entry_login_details'); ?>
          </a>
       </p>
       <div id="eventmanager_vault_entries" class="hide">
         <?php foreach($eventmanager->shared_vault_entries as $vault_entry){ ?>
         <div class="row" id="<?php echo 'vaultEntry-'.$vault_entry['id']; ?>">
            <div class="col-md-6">
               <p class="mtop5">
                  <b><?php echo _l('server_address'); ?>: </b><?php echo $vault_entry['server_address']; ?>
               </p>
               <p>
                  <b><?php echo _l('port'); ?>: </b><?php echo !empty($vault_entry['port']) ? $vault_entry['port'] : _l('no_port_provided'); ?>
               </p>
               <p>
                  <b><?php echo _l('vault_username'); ?>: </b><?php echo $vault_entry['username']; ?>
               </p>
               <p class="no-margin">
                  <b><?php echo _l('vault_password'); ?>: </b><span class="vault-password-fake">
                     <?php echo str_repeat('&bull;',10);?>  </span><span class="vault-password-encrypted"></span> <a href="#" class="vault-view-password mleft10" data-toggle="tooltip" data-title="<?php echo _l('view_password'); ?>" onclick="vault_re_enter_password(<?php echo $vault_entry['id']; ?>,this); return false;"><i class="fa fa-lock" aria-hidden="true"></i></a>
                  </p>
               </div>
               <div class="col-md-6">
                  <?php if(!empty($vault_entry['description'])){ ?>
                  <p>
                     <b><?php echo _l('vault_description'); ?>: </b><br /><?php echo $vault_entry['description']; ?>
                  </p>
                  <?php } ?>
               </div>
            </div>
            <hr class="hr-10" />
            <?php } ?>
         </div>
         <hr class="hr-panel-heading eventmanager-area-separation" />
      </div>
      <?php } ?>
      <div class="col-md-7">
         <table class="table no-margin eventmanager-overview-table">
            <tbody>
               <?php if(has_permission('customers','','view') || is_customer_admin($eventmanager->clientid)){ ?>
               <tr class="eventmanager-overview-customer">
                  <td class="bold"><?php echo _l('eventmanager_customer'); ?></td>
                  <td><a href="<?php echo admin_url(); ?>clients/client/<?php echo $eventmanager->clientid; ?>"><?php echo $eventmanager->client_data->company; ?></a>
                  </td>
               </tr>
               <?php } ?>
               <?php if(has_permission('events','','create') || has_permission('events','','edit')){ ?>
               <tr class="eventmanager-overview-billing">
                  <td class="bold"><?php echo _l('eventmanager_billing_type'); ?></td>
                  <td>
                     <?php
                     if($eventmanager->billing_type == 1){
                       $type_name = 'eventmanager_billing_type_fixed_cost';
                    } else if($eventmanager->billing_type == 2){
                       $type_name = 'eventmanager_billing_type_eventmanager_hours';
                    } else {
                       $type_name = 'eventmanager_billing_type_eventmanager_task_hours';
                    }
                    echo _l($type_name);
                    ?>
                 </td>
                 <?php if($eventmanager->billing_type == 1 || $eventmanager->billing_type == 2){
                  echo '<tr>';
                  if($eventmanager->billing_type == 1){
                    echo '<td class="bold">'._l('eventmanager_total_cost').'</td>';
                    echo '<td>'.format_money($eventmanager->eventmanager_cost,$currency->symbol).'</td>';
                 } else {
                    echo '<td class="bold">'._l('eventmanager_rate_per_hour').'</td>';
                    echo '<td>'.format_money($eventmanager->eventmanager_rate_per_hour,$currency->symbol).'</td>';
                 }
                 echo '<tr>';
              }
           }
           ?>

           <tr class="eventmanager-overview-status">
            <td class="bold"><?php echo _l('eventmanager_status'); ?></td>
            <td><?php echo $eventmanager_status['name']; ?></td>
         </tr>
         <tr class="eventmanager-overview-date-created">
            <td class="bold"><?php echo _l('eventmanager_datecreated'); ?></td>
            <td><?php echo _d($eventmanager->eventmanager_created); ?></td>
         </tr>
         <tr class="eventmanager-overview-start-date">
            <td class="bold"><?php echo _l('eventmanager_start_date'); ?></td>
            <td><?php echo _d($eventmanager->start_date); ?></td>
         </tr>
         <?php if($eventmanager->deadline){ ?>
         <tr class="eventmanager-overview-deadline">
            <td class="bold"><?php echo _l('eventmanager_deadline'); ?></td>
            <td><?php echo _d($eventmanager->deadline); ?></td>
         </tr>
         <?php } ?>
         <?php if($eventmanager->date_finished){ ?>
         <tr class="eventmanager-overview-date-finished">
            <td class="bold"><?php echo _l('eventmanager_completed_date'); ?></td>
            <td class="text-success"><?php echo _dt($eventmanager->date_finished); ?></td>
         </tr>
         <?php } ?>
         <?php if($eventmanager->estimated_hours && $eventmanager->estimated_hours != '0'){ ?>
         <tr class="eventmanager-overview-estimated-hours">
            <td class="bold<?php if(hours_to_seconds_format($eventmanager->estimated_hours) < (int)$eventmanager_total_logged_time){echo ' text-warning';} ?>"><?php echo _l('estimated_hours'); ?></td>
            <td><?php echo str_replace('.', ':', $eventmanager->estimated_hours); ?></td>
         </tr>
         <?php } ?>
         <?php if(has_permission('events','','create')){ ?>
         <tr class="eventmanager-overview-total-logged-hours">
            <td class="bold"><?php echo _l('eventmanager_overview_total_logged_hours'); ?></td>
            <td><?php echo seconds_to_time_format($eventmanager_total_logged_time); ?></td>
         </tr>
         <?php } ?>
         <?php $custom_fields = get_custom_fields('eventmanager');
         if(count($custom_fields) > 0){ ?>
         <?php foreach($custom_fields as $field){ ?>
         <?php $value = get_custom_field_value($eventmanager->id,$field['id'],'eventmanager');
         if($value == ''){continue;} ?>
         <tr>
            <td class="bold"><?php echo ucfirst($field['name']); ?></td>
            <td><?php echo $value; ?></td>
         </tr>
         <?php } ?>
         <?php } ?>
      </tbody>
   </table>
</div>
<div class="col-md-5 text-center eventmanager-percent-col mtop10">
   <p class="bold"><?php echo _l('eventmanager'). ' ' . _l('eventmanager_progress'); ?></p>
   <div class="eventmanager-progress relative mtop15" data-value="<?php echo $percent_circle; ?>" data-size="150" data-thickness="22" data-reverse="true">
      <strong class="eventmanager-percent"></strong>
   </div>
</div>
</div>

<?php $tags = get_tags_in($eventmanager->id,'eventmanager'); ?>
<?php if(count($tags) > 0){ ?>
<div class="clearfix"></div>
<div class="tags-read-only-custom eventmanager-overview-tags">
   <hr class="hr-panel-heading eventmanager-area-separation hr-10" />
   <?php echo '<p class="font-size-14"><b><i class="fa fa-tag" aria-hidden="true"></i> ' . _l('tags') . ':</b></p>'; ?>
   <input type="text" class="tagsinput read-only" id="tags" name="tags" value="<?php echo prep_tags_input($tags); ?>" data-role="tagsinput">
</div>
<div class="clearfix"></div>
<?php } ?>
<div class="tc-content eventmanager-overview-description">
   <hr class="hr-panel-heading eventmanager-area-separation" />
   <p class="bold font-size-14 eventmanager-info"><?php echo _l('eventmanager_description'); ?></p>
   <?php if(empty($eventmanager->description)){
      echo '<p class="text-muted no-mbot mtop15">' . _l('no_description_eventmanager') . '</p>';
   }
   echo check_for_links($eventmanager->description); ?>
</div>
<div class="team-members eventmanager-overview-team-members">
   <hr class="hr-panel-heading eventmanager-area-separation" />
   <?php if(has_permission('events','','edit') || has_permission('events','','create')){ ?>
   <div class="inline-block pull-right mright10 eventmanager-member-settings" data-toggle="tooltip" data-title="<?php echo _l('add_edit_members'); ?>">
      <a href="#" data-toggle="modal" class="pull-right" data-target="#add-edit-members"><i class="fa fa-cog"></i></a>
   </div>
   <?php } ?>
   <p class="bold font-size-14 eventmanager-info">
      <?php echo _l('eventmanager_members'); ?>
   </p>
   <div class="clearfix"></div>
   <?php
   if(count($members) == 0){
      echo '<p class="text-muted mtop10 no-mbot">'._l('no_eventmanager_members').'</p>';
   }
   foreach($members as $member){ ?>
   <div class="media">
      <div class="media-left">
         <a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>">
            <?php echo staff_profile_image($member['staff_id'],array('staff-profile-image-small','media-object')); ?>
         </a>
      </div>
      <div class="media-body">
         <?php if(has_permission('events','','edit') || has_permission('events','','create')){ ?>
         <a href="<?php echo admin_url('eventmanager/remove_team_member/'.$eventmanager->id.'/'.$member['staff_id']); ?>" class="pull-right text-danger _delete"><i class="fa fa fa-times"></i></a>
         <?php } ?>
         <h5 class="media-heading mtop5"><a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>"><?php echo get_staff_full_name($member['staff_id']); ?></a>
            <?php if(has_permission('events','','create') || $member['staff_id'] == get_staff_user_id()){ ?>
            <br /><small class="text-muted"><?php echo _l('total_logged_hours_by_staff') .': '.seconds_to_time_format($member['total_logged_time']); ?></small>
            <?php } ?>
         </h5>
      </div>
   </div>
   <?php } ?>
</div>
</div>
<div class="col-md-6 eventmanager-overview-right">
   <div class="row">
      <div class="col-md-<?php echo ($eventmanager->deadline ? 6 : 12); ?> eventmanager-progress-bars">
         <?php $tasks_not_completed_progress = round($tasks_not_completed_progress,2); ?>
         <?php $eventmanager_time_left_percent = round($eventmanager_time_left_percent,2); ?>
         <div class="row">
           <div class="eventmanager-overview-open-tasks">
            <div class="col-md-9">
               <p class="text-uppercase bold text-dark font-medium">
                  <?php echo $tasks_not_completed; ?> / <?php echo $total_tasks; ?> <?php echo _l('eventmanager_open_tasks'); ?>
               </p>
               <p class="text-muted bold"><?php echo $tasks_not_completed_progress; ?>%</p>
            </div>
            <div class="col-md-3 text-right">
               <i class="fa fa-check-circle<?php if($tasks_not_completed_progress >= 100){echo ' text-success';} ?>" aria-hidden="true"></i>
            </div>
            <div class="col-md-12 mtop5">
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar light-green-bg no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $tasks_not_completed_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $tasks_not_completed_progress; ?>">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php if($eventmanager->deadline){?>
   <div class="col-md-6 eventmanager-progress-bars eventmanager-overview-days-left">
      <div class="row">
         <div class="col-md-9">
            <p class="text-uppercase bold text-dark font-medium">
               <?php echo $eventmanager_days_left; ?> / <?php echo $eventmanager_total_days; ?> <?php echo _l('eventmanager_days_left'); ?>
            </p>
            <p class="text-muted bold"><?php echo $eventmanager_time_left_percent; ?>%</p>
         </div>
         <div class="col-md-3 text-right">
            <i class="fa fa-calendar-check-o<?php if($eventmanager_time_left_percent >= 100){echo ' text-success';} ?>" aria-hidden="true"></i>
         </div>
         <div class="col-md-12 mtop5">
            <div class="progress no-margin progress-bar-mini">
               <div class="progress-bar<?php if($eventmanager_time_left_percent == 0){echo ' progress-bar-warning ';} else { echo ' progress-bar-success ';} ?>no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $eventmanager_time_left_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $eventmanager_time_left_percent; ?>">
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
</div>
<hr class="hr-panel-heading" />

<?php if(has_permission('events','','create')) {?>
<div class="row">
   <?php if($eventmanager->billing_type == 2 || $eventmanager->billing_type == 2){ ?>
   <div class="col-md-12 eventmanager-overview-logged-hours-finance">
      <div class="col-md-3">
         <?php

         $data = $this->eventmanager_model->total_logged_time_by_billing_type($eventmanager->id);

         ?>
         <p class="text-uppercase text-muted"><?php echo _l('eventmanager_overview_logged_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo format_money($data['total_money'],$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->eventmanager_model->data_billable_time($eventmanager->id);
         ?>
         <p class="text-uppercase text-info"><?php echo _l('eventmanager_overview_billable_hours'); ?> <span class="bold"><?php echo $data['logged_time'] ?></span></p>
         <p class="bold font-medium"><?php echo format_money($data['total_money'],$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->eventmanager_model->data_billed_time($eventmanager->id);
         ?>
         <p class="text-uppercase text-success"><?php echo _l('eventmanager_overview_billed_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo format_money($data['total_money'],$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->eventmanager_model->data_unbilled_time($eventmanager->id);
         ?>
         <p class="text-uppercase text-danger"><?php echo _l('eventmanager_overview_unbilled_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo format_money($data['total_money'],$currency->symbol); ?></p>
      </div>
      <div class="clearfix"></div>
      <hr class="hr-panel-heading" />
   </div>
   <?php } ?>
</div>
<div class="row">
   <div class="col-md-12 eventmanager-overview-expenses-finance">
      <div class="col-md-3">
         <p class="text-uppercase text-muted"><?php echo _l('eventmanager_overview_expenses'); ?></p>
         <p class="bold font-medium"><?php echo format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id),'field'=>'amount')),$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-info"><?php echo _l('eventmanager_overview_expenses_billable'); ?></p>
         <p class="bold font-medium"><?php echo format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'billable'=>1),'field'=>'amount')),$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-success"><?php echo _l('eventmanager_overview_expenses_billed'); ?></p>
         <p class="bold font-medium"><?php echo format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'invoiceid !='=>'NULL','billable'=>1),'field'=>'amount')),$currency->symbol); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-danger"><?php echo _l('eventmanager_overview_expenses_unbilled'); ?></p>
         <p class="bold font-medium"><?php echo format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'invoiceid IS NULL','billable'=>1),'field'=>'amount')),$currency->symbol); ?></p>
      </div>
   </div>
</div>
<?php } ?>
<div class="eventmanager-overview-timesheets-chart">
   <hr class="hr-panel-heading" />
   <div class="dropdown pull-right">
      <a href="#" class="dropdown-toggle" type="button" id="dropdownMenueventmanagerLoggedTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
         <?php if(!$this->input->get('overview_chart')){
            echo _l('this_week');
         } else {
            echo _l($this->input->get('overview_chart'));
         }
         ?>
         <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenueventmanagerLoggedTime">
         <li><a href="<?php echo admin_url('eventmanager/view/'.$eventmanager->id.'?group=event_overview&overview_chart=this_week'); ?>"><?php echo _l('this_week'); ?></a></li>
         <li><a href="<?php echo admin_url('eventmanager/view/'.$eventmanager->id.'?group=event_overview&overview_chart=last_week'); ?>"><?php echo _l('last_week'); ?></a></li>
         <li><a href="<?php echo admin_url('eventmanager/view/'.$eventmanager->id.'?group=event_overview&overview_chart=this_month'); ?>"><?php echo _l('this_month'); ?></a></li>
         <li><a href="<?php echo admin_url('eventmanager/view/'.$eventmanager->id.'?group=event_overview&overview_chart=last_month'); ?>"><?php echo _l('last_month'); ?></a></li>
      </ul>
   </div>
   <div class="clearfix"></div>
   <canvas id="timesheetsChart" style="max-height:300px;" width="300" height="300"></canvas>
</div>

</div>
</div>
<div class="modal fade" id="add-edit-members" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('eventmanager/add_edit_members/'.$eventmanager->id)); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('eventmanager_members'); ?></h4>
         </div>
         <div class="modal-body">
            <?php
            $selected = array();
            foreach($members as $member){
              array_push($selected,$member['staff_id']);
           }
           echo render_select('eventmanager_members[]',$staff,array('staffid',array('firstname','lastname')),'eventmanager_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
           ?>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
         <button type="submit" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
      </div>
   </div>
   <!-- /.modal-content -->
   <?php echo form_close(); ?>
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php if(isset($eventmanager_overview_chart)){ ?>
<script>
   var eventmanager_overview_chart = <?php echo json_encode($eventmanager_overview_chart); ?>;
</script>
<?php } ?>
