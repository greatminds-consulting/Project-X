<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open($this->uri->uri_string(),array('id'=>'event_form')); ?>
            <div class="col-md-7">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        $disable_type_edit = '';
                        if(isset($eventmanager)){
                            if($eventmanager->billing_type != 1){
                                if(total_rows('tblstafftasks',array('rel_id'=>$eventmanager->id,'rel_type'=>'eventmanager','billable'=>1,'billed'=>1)) > 0){
                                    $disable_type_edit = 'disabled';
                                }
                            }
                        }
                        ?>
                        <?php $value = (isset($eventmanager) ? $eventmanager->name : ''); ?>
                        <?php echo render_input('name','eventmanager_name',$value); ?>
                        <div class="form-group select-placeholder">
                            <label for="clientid" class="control-label"><?php echo _l('eventmanager_customer'); ?></label>
                            <select id="clientid" name="clientid" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                               <?php $selected = (isset($eventmanager) ? $eventmanager->clientid : '');
                               if($selected == ''){
                                   $selected = (isset($customer_id) ? $customer_id: '');
                               }
                               if($selected != ''){
                                $rel_data = get_relation_data('customer',$selected);
                                $rel_val = get_relation_values($rel_data,'customer');
                                echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" <?php if((isset($eventmanager) && $eventmanager->progress_from_tasks == 1) || !isset($eventmanager)){echo 'checked';} ?> name="progress_from_tasks" id="progress_from_tasks">
                            <label for="progress_from_tasks"><?php echo _l('calculate_progress_through_tasks'); ?></label>
                        </div>
                    </div>
                    <?php
                    if(isset($eventmanager) && $eventmanager->progress_from_tasks == 1){
                        $value = $this->eventmanager_model->calc_progress_by_tasks($eventmanager->id);
                    } else if(isset($eventmanager) && $eventmanager->progress_from_tasks == 0){
                        $value = $eventmanager->progress;
                    } else {
                        $value = 0;
                    }
                    ?>
                    <label for=""><?php echo _l('eventmanager_progress'); ?> <span class="label_progress"><?php echo $value; ?>%</span></label>
                    <?php echo form_hidden('progress',$value); ?>
                    <div class="eventmanager_progress_slider eventmanager_progress_slider_horizontal mbot15"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group select-placeholder">
                                <label for="billing_type"><?php echo _l('eventmanager_billing_type'); ?></label>
                                <div class="clearfix"></div>
                                <select name="billing_type" class="selectpicker" id="billing_type" data-width="100%" <?php echo $disable_type_edit ; ?> data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <option value=""></option>
                                    <option value="1" <?php if(isset($eventmanager) && $eventmanager->billing_type == 1 || !isset($eventmanager) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 1){echo 'selected'; } ?>><?php echo _l('eventmanager_billing_type_fixed_cost'); ?></option>
                                    <option value="2" <?php if(isset($eventmanager) && $eventmanager->billing_type == 2 || !isset($eventmanager) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 2){echo 'selected'; } ?>><?php echo _l('eventmanager_billing_type_eventmanager_hours'); ?></option>
                                    <option value="3" data-subtext="<?php echo _l('eventmanager_billing_type_eventmanager_task_hours_hourly_rate'); ?>" <?php if(isset($eventmanager) && $eventmanager->billing_type == 3 || !isset($eventmanager) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 3){echo 'selected'; } ?>><?php echo _l('eventmanager_billing_type_eventmanager_task_hours'); ?></option>
                                </select>
                                <?php if($disable_type_edit != ''){
                                    echo '<p class="text-danger">'._l('cant_change_billing_type_billed_tasks_found').'</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group select-placeholder">
                                <label for="status"><?php echo _l('eventmanager_status'); ?></label>
                                <div class="clearfix"></div>
                                <select name="status" id="status" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <?php foreach($statuses as $status){ ?>
                                    <option value="<?php echo $status['id']; ?>" <?php if(!isset($eventmanager) && $status['id'] == 2 || (isset($eventmanager) && $eventmanager->status == $status['id'])){echo 'selected';} ?>><?php echo $status['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php if(total_rows('tblemailtemplates',array('slug'=>'eventmanager-finished-to-customer','active'=>0)) == 0){ ?>
                    <div class="form-group eventmanager_marked_as_finished hide">
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="eventmanager_marked_as_finished_email_to_contacts" id="eventmanager_marked_as_finished_email_to_contacts">
                            <label for="eventmanager_marked_as_finished_email_to_contacts"><?php echo _l('eventmanager_marked_as_finished_to_contacts'); ?></label>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(isset($eventmanager)){ ?>
                    <div class="form-group mark_all_tasks_as_completed hide">
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="mark_all_tasks_as_completed" id="mark_all_tasks_as_completed">
                            <label for="mark_all_tasks_as_completed"><?php echo _l('eventmanager_mark_all_tasks_as_completed'); ?></label>
                        </div>
                    </div>
                    <div class="notify_eventmanager_members_status_change hide">
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="notify_eventmanager_members_status_change" id="notify_eventmanager_members_status_change">
                            <label for="notify_eventmanager_members_status_change"><?php echo _l('notify_eventmanager_members_status_change'); ?></label>
                        </div>
                        <hr />
                    </div>
                    <?php } ?>
                    <?php
                    $input_field_hide_class_total_cost = '';
                    if(!isset($eventmanager)){
                        if($auto_select_billing_type && $auto_select_billing_type->billing_type != 1 || !$auto_select_billing_type){
                            $input_field_hide_class_total_cost = 'hide';
                        }
                    } else if(isset($eventmanager) && $eventmanager->billing_type != 1){
                        $input_field_hide_class_total_cost = 'hide';
                    }
                    ?>
                    <div id="eventmanager_cost" class="<?php echo $input_field_hide_class_total_cost; ?>">
                        <?php $value = (isset($eventmanager) ? $eventmanager->eventmanager_cost : ''); ?>
                        <?php echo render_input('eventmanager_cost','eventmanager_total_cost',$value,'number'); ?>
                    </div>
                    <?php
                    $input_field_hide_class_rate_per_hour = '';
                    if(!isset($eventmanager)){
                        if($auto_select_billing_type && $auto_select_billing_type->billing_type != 2 || !$auto_select_billing_type){
                            $input_field_hide_class_rate_per_hour = 'hide';
                        }
                    } else if(isset($eventmanager) && $eventmanager->billing_type != 2){
                        $input_field_hide_class_rate_per_hour = 'hide';
                    }
                    ?>
                    <div id="eventmanager_rate_per_hour" class="<?php echo $input_field_hide_class_rate_per_hour; ?>">
                        <?php $value = (isset($eventmanager) ? $eventmanager->eventmanager_rate_per_hour : ''); ?>
                        <?php
                        $input_disable = array();
                        if($disable_type_edit != ''){
                            $input_disable['disabled'] = true;
                        }
                        ?>
                        <?php echo render_input('eventmanager_rate_per_hour','eventmanager_rate_per_hour',$value,'number',$input_disable); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo render_input('estimated_hours','estimated_hours',isset($eventmanager) ? $eventmanager->estimated_hours : '','number'); ?>
                        </div>
                        <div class="col-md-6">
                           <?php
                           $selected = array();
                           if(isset($$eventmanager_members)){
                            foreach($$eventmanager_members as $member){
                                array_push($selected,$member['staff_id']);
                            }
                        } else {
                            array_push($selected,get_staff_user_id());
                        }
                        echo render_select('eventmanager_members[]',$staff,array('staffid',array('firstname','lastname')),'eventmanager_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php $value = (isset($eventmanager) ? _d($eventmanager->start_date) : _d(date('Y-m-d'))); ?>
                        <?php echo render_date_input('start_date','eventmanager_start_date',$value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = (isset($eventmanager) ? _d($eventmanager->deadline) : ''); ?>
                        <?php echo render_date_input('deadline','eventmanager_deadline',$value); ?>
                    </div>
                </div>
                <?php if(isset($eventmanager) && $eventmanager->date_finished != null && $eventmanager->status == 4) { ?>
                    <?php echo render_datetime_input('date_finished','eventmanager_completed_date',_dt($eventmanager->date_finished)); ?>
                <?php } ?>
                <div class="form-group">
                    <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                    <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($eventmanager) ? prep_tags_input(get_tags_in($eventmanager->id,'eventmanager')) : ''); ?>" data-role="tagsinput">
                </div>
                <?php $rel_id_custom_field = (isset($eventmanager) ? $eventmanager->id : false); ?>
                <?php echo render_custom_fields('eventmanager',$rel_id_custom_field); ?>
                <p class="bold"><?php echo _l('eventmanager_description'); ?></p>
                <?php $contents = ''; if(isset($eventmanager)){$contents = $eventmanager->description;} ?>
                <?php echo render_textarea('description','',$contents,array(),array(),'','tinymce'); ?>
                <?php if(total_rows('tblemailtemplates',array('slug'=>'assigned-to-eventmanager','active'=>0)) == 0){ ?>
                <div class="checkbox checkbox-primary">
                   <input type="checkbox" name="send_created_email" id="send_created_email">
                   <label for="send_created_email"><?php echo _l('eventmanager_send_created_email'); ?></label>
               </div>
               <?php } ?>
               <div class="btn-bottom-toolbar text-right">
                   <button type="submit" data-form="#eventmanager_form" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
               </div>
           </div>
       </div>
   </div>
   <div class="col-md-5">
    <div class="panel_s">
        <div class="panel-body" id="eventmanager-settings-area">
         <h4 class="no-margin">
             <?php echo _l('eventmanager_settings'); ?>
         </h4>
         <hr class="hr-panel-heading" />
         <?php foreach($settings as $setting){ ?>

            <?php
            $checked = ' checked';
            if(isset($eventmanager)){
                if($eventmanager->settings->{$setting} == 0){
                    $checked = '';
                }
            } else {
                foreach($last_eventmanager_settings as $_l_setting) {
                    if($setting == $_l_setting['name']){
                        // hide_tasks_on_main_tasks_table is not applied on most used settings to prevent confusions
                        if($_l_setting['value'] == 0 || $_l_setting['name'] == 'hide_tasks_on_main_tasks_table'){
                            $checked = '';
                        }
                    }
                }
                if(count($last_eventmanager_settings) == 0 && $setting == 'hide_tasks_on_main_tasks_table') {
                    $checked = '';
                }
            } ?>
            <?php if($setting != 'available_features'){ ?>
            <div class="checkbox">
            <input type="checkbox" name="settings[<?php echo $setting; ?>]" <?php echo $checked; ?> id="<?php echo $setting; ?>">
            <label for="<?php echo $setting; ?>">
                <?php if($setting == 'hide_tasks_on_main_tasks_table'){ ?>
                <?php echo _l('hide_tasks_on_main_tasks_table'); ?>
                <?php } else{ ?>
                <?php echo _l('eventmanager_allow_client_to',_l('eventmanager_setting_'.$setting)); ?>
                <?php } ?>
            </label>
        </div>
        <?php } else { ?>
        <div class="form-group mtop15 select-placeholder">
            <label for="available_features"><?php echo _l('visible_tabs'); ?></label>
            <select name="settings[<?php echo $setting; ?>][]" id="<?php echo $setting; ?>" multiple="true" class="selectpicker" id="available_features" data-width="100%" data-actions-box="true">
            <?php $tabs = get_eventmanager_tabs_admin(null);
           ?>
            <?php foreach($tabs as $tab) {
                $selected = '';
             ?>
            <?php if(isset($tab['dropdown'])){ ?>
            <optgroup label="<?php echo $tab['lang']; ?>">
                <?php foreach($tab['dropdown'] as $tab_dropdown) {
                    $selected = '';
                    if(isset($eventmanager) && $eventmanager->settings->available_features[$tab_dropdown['name']] == 1) {
                        $selected = ' selected';
                    } else if(!isset($eventmanager) && count($last_eventmanager_settings) > 0) {
                        foreach($last_eventmanager_settings as $last_eventmanager_setting) {
                            if($last_eventmanager_setting['name'] == $setting) {
                                if($last_eventmanager_setting['value'][$tab_dropdown['name']] == 1) {
                                    $selected = ' selected';
                                }
                            }
                        }
                    } else if(!isset($eventmanager)) {
                        $selected = ' selected';
                    }
                 ?>
                <option value="<?php echo $tab_dropdown['name']; ?>"<?php echo $selected; ?><?php if(isset($tab_dropdown['linked_to_customer_option']) && is_array($tab_dropdown['linked_to_customer_option']) && count($tab_dropdown['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab_dropdown['linked_to_customer_option']); ?>"<?php } ?>><?php echo $tab_dropdown['lang']; ?></option>
                <?php } ?>
            </optgroup>
            <?php } else {
                if(isset($eventmanager) && $eventmanager->settings->available_features[$tab['name']] == 1) {
                    $selected = ' selected';
                } else if(!isset($eventmanager) && count($last_eventmanager_settings) > 0) {
                        foreach($last_eventmanager_settings as $last_eventmanager_setting) {
                            if($last_eventmanager_setting['name'] == $setting) {
                                if($last_eventmanager_setting['value'][$tab['name']] == 1) {
                                    $selected = ' selected';
                                }
                            }
                        }
                    } else if(!isset($eventmanager)) {
                        $selected = ' selected';
                    }
                ?>
            <option value="<?php echo $tab['name']; ?>"<?php if($tab['name'] =='eventmanager_overview'){echo ' disabled selected';} ?>
                <?php echo $selected; ?><?php if(isset($tab['linked_to_customer_option']) && is_array($tab['linked_to_customer_option']) && count($tab['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab['linked_to_customer_option']); ?>"<?php } ?>><?php echo $tab['lang']; ?>
            </option>
            <?php } ?>
            <?php } ?>
        </select>
        </div>
        <?php } ?>
        <hr class="no-margin" />
        <?php } ?>
    </div>
</div>
</div>
<?php echo form_close(); ?>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<?php init_tail(); ?>
<script>
    <?php if(isset($eventmanager)){ ?>
        var original_eventmanager_status = '<?php echo $eventmanager->status; ?>';
        <?php } ?>
        $(function(){

            $('select[name="billing_type"]').on('change',function(){
                var type = $(this).val();
                if(type == 1){
                    $('#eventmanager_cost').removeClass('hide');
                    $('#eventmanager_rate_per_hour').addClass('hide');
                } else if(type == 2){
                    $('#eventmanager_cost').addClass('hide');
                    $('#eventmanager_rate_per_hour').removeClass('hide');
                } else {
                    $('#eventmanager_cost').addClass('hide');
                    $('#eventmanager_rate_per_hour').addClass('hide');
                }
            });

            _validate_form($('form'),{name:'required',clientid:'required',start_date:'required',billing_type:'required'});

            $('select[name="status"]').on('change',function(){
                var status = $(this).val();
                var mark_all_tasks_completed = $('.mark_all_tasks_as_completed');
                var notify_eventmanager_members_status_change = $('.notify_eventmanager_members_status_change');
                mark_all_tasks_completed.removeClass('hide');
                if(typeof(original_eventmanager_status) != 'undefined'){
                    if(original_eventmanager_status != status){
                        mark_all_tasks_completed.removeClass('hide');
                        mark_all_tasks_completed.find('input').prop('checked',true);
                        notify_eventmanager_members_status_change.removeClass('hide');
                    } else {
                        mark_all_tasks_completed.addClass('hide');
                        mark_all_tasks_completed.find('input').prop('checked',false);
                        notify_eventmanager_members_status_change.addClass('hide');
                    }
                }
                if(status == 4){
                    $('.eventmanager_marked_as_finished').removeClass('hide');
                } else {
                    $('.eventmanager_marked_as_finished').addClass('hide');
                    $('.eventmanager_marked_as_finished').prop('checked',false);
                }
            });

            $('form').on('submit',function(){
                $('select[name="billing_type"]').prop('disabled',false);
                $('#available_features,#available_features option').prop('disabled',false);
                $('input[name="eventmanager_rate_per_hour"]').prop('disabled',false);
            });

            var progress_input = $('input[name="progress"]');
            var progress_from_tasks = $('#progress_from_tasks');
            var progress = progress_input.val();

            $('.eventmanager_progress_slider').slider({
                min:0,
                max:100,
                value:progress,
                disabled:progress_from_tasks.prop('checked'),
                slide: function( event, ui ) {
                    progress_input.val( ui.value );
                    $('.label_progress').html(ui.value+'%');
                }
            });

            progress_from_tasks.on('change',function(){
                var _checked = $(this).prop('checked');
                $('.eventmanager_progress_slider').slider({disabled:_checked});
            });

            $('#eventmanager-settings-area input').on('change',function(){
                if($(this).attr('id') == 'view_tasks' && $(this).prop('checked') == false){
                    $('#create_tasks').prop('checked',false).prop('disabled',true);
                    $('#edit_tasks').prop('checked',false).prop('disabled',true);
                    $('#view_task_comments').prop('checked',false).prop('disabled',true);
                    $('#comment_on_tasks').prop('checked',false).prop('disabled',true);
                    $('#view_task_attachments').prop('checked',false).prop('disabled',true);
                    $('#view_task_checklist_items').prop('checked',false).prop('disabled',true);
                    $('#upload_on_tasks').prop('checked',false).prop('disabled',true);
                    $('#view_task_total_logged_time').prop('checked',false).prop('disabled',true);
                } else if($(this).attr('id') == 'view_tasks' && $(this).prop('checked') == true){
                    $('#create_tasks').prop('disabled',false);
                    $('#edit_tasks').prop('disabled',false);
                    $('#view_task_comments').prop('disabled',false);
                    $('#comment_on_tasks').prop('disabled',false);
                    $('#view_task_attachments').prop('disabled',false);
                    $('#view_task_checklist_items').prop('disabled',false);
                    $('#upload_on_tasks').prop('disabled',false);
                    $('#view_task_total_logged_time').prop('disabled',false);
                }
            });

            // Auto adjust customer permissions based on selected eventmanager visible tabs
            // Eq eventmanager creator disable TASKS tab, then this function will auto turn off customer eventmanager option Allow customer to view tasks

            $('#available_features').on('change',function(){
                $("#available_features option").each(function(){
                   if($(this).data('linked-customer-option') && !$(this).is(':selected')) {
                        var opts = $(this).data('linked-customer-option').split(',');
                        for(var i = 0; i<opts.length;i++) {
                            var eventmanager_option = $('#'+opts[i]);
                            eventmanager_option.prop('checked',false);
                            if(opts[i] == 'view_tasks') {
                                eventmanager_option.trigger('change');
                            }
                        }
                   }
               });
            });
            $("#view_tasks").trigger('change');
            <?php if(!isset($eventmanager)) { ?>
                $('#available_features').trigger('change');
            <?php } ?>
        });
    </script>
</body>
</html>
