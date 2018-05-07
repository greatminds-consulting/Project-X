<?php init_head(); ?>
<style>
#ribbon_eventmanager_<?php echo $eventmanager->id; ?> span::before {
  border-top: 3px solid <?php echo $eventmanager_status['color']; ?>;
  border-left: 3px solid <?php echo $eventmanager_status['color']; ?>;
}
</style>
<div id="wrapper">
  <?php echo form_hidden('event_manager_id',$eventmanager->id) ?>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s eventmanager-top-panel panel-full">
          <div class="panel-body _buttons">
            <div class="row">
              <div class="col-md-8 eventmanager-heading">
                <h3 class="hide eventmanager-name"><?php echo $eventmanager->name; ?></h3>
                <div id="eventmanager_view_name">
                 <select class="selectpicker" id="eventmanager_top" data-width="fit"<?php if(count($other_eventmanager) > 4){ ?> data-live-search="true" <?php } ?>>
                   <option value="<?php echo $eventmanager->id; ?>" selected><?php echo $eventmanager->name; ?></option>
                   <?php foreach($other_eventmanager as $op){ ?>
                   <option value="<?php echo $op['id']; ?>" data-subtext="<?php echo $op['company']; ?>">#<?php echo $op['id']; ?> - <?php echo $op['name']; ?></option>
                   <?php } ?>
                 </select>
               </div>
             </div>
             <div class="col-md-4 text-right">
              <?php if(has_permission('tasks','','create')){ ?>
              <a href="#" onclick="new_task_from_relation(undefined,'eventmanager',<?php echo $eventmanager->id; ?>); return false;" class="btn btn-info"><?php echo _l('new_task'); ?></a>
              <?php } ?>
              <?php
              $invoice_func = 'pre_invoice_eventmanager';
              ?>
              <?php if(has_permission('invoices','','create')){ ?>
              <a href="#" onclick="<?php echo $invoice_func; ?>(<?php echo $eventmanager->id; ?>); return false;" class="invoice-eventmanager btn btn-info<?php if($eventmanager->client_data->active == 0){echo ' disabled';} ?>"><?php echo _l('invoice_eventmanager'); ?></a>
              <?php } ?>
              <?php
              $eventmanager_pin_tooltip = _l('pin_eventmanager');
              if(total_rows('tblpinnedevents',array('staff_id'=>get_staff_user_id(),'event_manager_id'=>$eventmanager->id)) > 0){
                $eventmanager_pin_tooltip = _l('unpin_eventmanager');
              }
              ?>
              <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo _l('more'); ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right width200 eventmanager-actions">
                  <li>
                   <a href="<?php echo admin_url('eventmanager/pin_action/'.$eventmanager->id); ?>">
                    <?php echo $eventmanager_pin_tooltip; ?>
                  </a>
                </li>
                <?php if(has_permission('events','','edit')){ ?>
                <li>
                  <a href="<?php echo admin_url('eventmanager/event/'.$eventmanager->id); ?>">
                    <?php echo _l('edit_eventmanager'); ?>
                  </a>
                </li>
                <?php } ?>
                <?php if(has_permission('events','','create')){ ?>
                <li>
                  <a href="#" onclick="copy_eventmger(); return false;">
                    <?php echo _l('copy_eventmanager'); ?>
                  </a>
                </li>
                <?php } ?>
                <?php if(has_permission('events','','create') || has_permission('events','','edit')){ ?>
                <li class="divider"></li>
                <?php foreach($statuses as $status){
                  if($status['id'] == $eventmanager->status){continue;}
                  ?>
                  <li>
                    <a href="#" onclick="eventmanager_mark_as_modal(<?php echo $status['id']; ?>,<?php echo $eventmanager->id; ?>); return false;"><?php echo _l('eventmanager_mark_as',$status['name']); ?></a>
                  </li>
                  <?php } ?>
                  <?php } ?>
                  <li class="divider"></li>
                  <?php if(has_permission('events','','create')){ ?>
                  <li>
                   <a href="<?php echo admin_url('eventmanager/export_eventmanager_data/'.$eventmanager->id); ?>" target="_blank"><?php echo _l('export_eventmanager_data'); ?></a>
                 </li>
                 <?php } ?>
                 <?php if(is_admin()){ ?>
                 <li>
                  <a href="<?php echo admin_url('eventmanager/view_eventmanager_as_client/'.$eventmanager->id .'/'.$eventmanager->clientid); ?>" target="_blank"><?php echo _l('eventmanager_view_as_client'); ?></a>
                </li>
                <?php } ?>
                <?php if(has_permission('events','','delete')){ ?>
                <li>
                  <a href="<?php echo admin_url('events/delete/'.$eventmanager->id); ?>" class="_delete">
                    <span class="text-danger"><?php echo _l('delete_eventmanager'); ?></span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="panel_s eventmanager-menu-panel">
      <div class="panel-body">
        <?php do_action('before_render_eventmanager_view',$eventmanager->id); ?>
        <?php echo '<div class="ribbon eventmanager-status-ribbon-'.$eventmanager->status.'" id="ribbon_eventmanager_'.$eventmanager->id.'"><span style="background:'.$eventmanager_status['color'].'">'.$eventmanager_status['name'].'</span></div>'; ?>
        <?php $this->load->view('admin/events/event_tabs'); ?>
      </div>
    </div>
    <?php if($view == 'event_milestones') { ?>
    <a href="#" class="eventmanager-tabs-and-opts-toggler screen-options-btn bold"><?php echo _l('show_tabs_and_options'); ?></a>
    <?php } else { ?>
    <?php if((has_permission('events','','create') || has_permission('events','','edit')) && $eventmanager->status == 1 && $this->eventmanager_model->timers_started_for_eventmanager($eventmanager->id)){ ?>
    <div class="alert alert-warning eventmanager-no-started-timers-found mbot15">
      <?php echo _l('eventmanager_not_started_status_tasks_timers_found'); ?>
    </div>
    <?php } ?>
    <?php if($eventmanager->deadline && date('Y-m-d') > $eventmanager->deadline && $eventmanager->status == 2){ ?>
    <div class="alert alert-warning bold eventmanager-due-notice mbot15">
      <?php echo _l('eventmanager_due_notice',floor((abs(time() - strtotime($eventmanager->deadline)))/(60*60*24))); ?>
    </div>
    <?php } ?>
    <?php if(!has_contact_permission('eventmanager',get_primary_contact_user_id($eventmanager->clientid)) && total_rows('tblcontacts',array('userid'=>$eventmanager->clientid)) > 0){ ?>
    <div class="alert alert-warning eventmanager-permissions-warning mbot15">
      <?php echo _l('eventmanager_customer_permission_warning'); ?>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="panel_s">
      <div class="panel-body">
        <?php echo $group_view; ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php if(isset($discussion)){
  echo form_hidden('discussion_id',$discussion->id);
  echo form_hidden('discussion_user_profile_image_url',$discussion_user_profile_image_url);
  echo form_hidden('current_user_is_admin',$current_user_is_admin);
}
echo form_hidden('eventmanager_percent',$percent);
?>
<div id="invoice_eventmanager"></div>
<div id="pre_invoice_eventmanager"></div>
<?php $this->load->view('admin/events/milestone'); ?>
<?php $this->load->view('admin/events/copy_settings'); ?>
<?php $this->load->view('admin/events/_mark_tasks_finished'); ?>
<?php init_tail(); ?>
<?php $discussion_lang = get_eventmanager_discussions_language_array(); ?>
<?php echo app_script('assets/js','eventmanager.js'); ?>
<!-- For invoices table -->
<script>
  taskid = '<?php echo $this->input->get('taskid'); ?>';
</script>
<script>
  var gantt_data = {};
  <?php if(isset($gantt_data)){ ?>
    gantt_data = <?php echo json_encode($gantt_data); ?>;
    <?php } ?>
    var discussion_id = $('input[name="discussion_id"]').val();
    var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
    var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
    var eventmanager_id = $('input[name="event_manager_id"]').val();
    if(typeof(discussion_id) != 'undefined'){
      discussion_comments('#discussion-comments',discussion_id,'regular');
    }
    $(function(){
     var eventmanager_progress_color = '<?php echo do_action('admin_eventmanager_progress_color','#84c529'); ?>';
     var circle = $('.eventmanager-progress').circleProgress({fill: {
      gradient: [eventmanager_progress_color, eventmanager_progress_color]
    }}).on('circle-animation-progress', function(event, progress, stepValue) {
      $(this).find('strong.eventmanager-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
    });
  });

    function discussion_comments(selector,discussion_id,discussion_type){
       $(selector).comments({
       roundProfilePictures: true,
       textareaRows: 4,
       textareaRowsOnFocus: 6,
       profilePictureURL:discussion_user_profile_image_url,
       enableUpvoting: false,
       enableAttachments:true,
       popularText:'',
       enableDeletingCommentWithReplies:false,
       textareaPlaceholderText:"<?php echo $discussion_lang['discussion_add_comment']; ?>",
       newestText:"<?php echo $discussion_lang['discussion_newest']; ?>",
       oldestText:"<?php echo $discussion_lang['discussion_oldest']; ?>",
       attachmentsText:"<?php echo $discussion_lang['discussion_attachments']; ?>",
       sendText:"<?php echo $discussion_lang['discussion_send']; ?>",
       replyText:"<?php echo $discussion_lang['discussion_reply']; ?>",
       editText:"<?php echo $discussion_lang['discussion_edit']; ?>",
       editedText:"<?php echo $discussion_lang['discussion_edited']; ?>",
       youText:"<?php echo $discussion_lang['discussion_you']; ?>",
       saveText:"<?php echo $discussion_lang['discussion_save']; ?>",
       deleteText:"<?php echo $discussion_lang['discussion_delete']; ?>",
       viewAllRepliesText:"<?php echo $discussion_lang['discussion_view_all_replies'] . ' (__replyCount__)'; ?>",
       hideRepliesText:"<?php echo $discussion_lang['discussion_hide_replies']; ?>",
       noCommentsText:"<?php echo $discussion_lang['discussion_no_comments']; ?>",
       noAttachmentsText:"<?php echo $discussion_lang['discussion_no_attachments']; ?>",
       attachmentDropText:"<?php echo $discussion_lang['discussion_attachments_drop']; ?>",
       currentUserIsAdmin:current_user_is_admin,
       getComments: function(success, error) {
         $.get(admin_url + 'eventmanager/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
           success(response);
         },'json');
       },
       postComment: function(commentJSON, success, error) {
         $.ajax({
           type: 'post',
           url: admin_url + 'eventmanager/add_discussion_comment/'+discussion_id+'/'+discussion_type,
           data: commentJSON,
           success: function(comment) {
             comment = JSON.parse(comment);
             success(comment)
           },
           error: error
         });
       },
       putComment: function(commentJSON, success, error) {
         $.ajax({
           type: 'post',
           url: admin_url + 'eventmanager/update_discussion_comment',
           data: commentJSON,
           success: function(comment) {
             comment = JSON.parse(comment);
             success(comment)
           },
           error: error
         });
       },
       deleteComment: function(commentJSON, success, error) {
         $.ajax({
           type: 'post',
           url: admin_url + 'eventmanager/delete_discussion_comment/'+commentJSON.id,
           success: success,
           error: error
         });
       },
       timeFormatter: function(time) {
         return moment(time).fromNow();
       },
       uploadAttachments: function(commentArray, success, error) {
         var responses = 0;
         var successfulUploads = [];
         var serverResponded = function() {
           responses++;
             // Check if all requests have finished
             if(responses == commentArray.length) {
                 // Case: all failed
                 if(successfulUploads.length == 0) {
                   error();
                 // Case: some succeeded
               } else {
                 successfulUploads = JSON.parse(successfulUploads);
                 success(successfulUploads)
               }
             }
           }
           $(commentArray).each(function(index, commentJSON) {
             // Create form data
             var formData = new FormData();
             if(commentJSON.file.size && commentJSON.file.size > max_php_ini_upload_size_bytes){
              alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
              serverResponded();
            } else {
             $(Object.keys(commentJSON)).each(function(index, key) {
               var value = commentJSON[key];
               if(value) formData.append(key, value);
             });

             if (typeof(csrfData) !== 'undefined') {
                formData.append(csrfData['token_name'], csrfData['hash']);
             }
             $.ajax({
               url: admin_url + 'eventmanager/add_discussion_comment/'+discussion_id+'/'+discussion_type,
               type: 'POST',
               data: formData,
               cache: false,
               contentType: false,
               processData: false,
               success: function(commentJSON) {
                 successfulUploads.push(commentJSON);
                 serverResponded();
               },
               error: function(data) {
                var error = JSON.parse(data.responseText);
                alert_float('danger',error.message);
                serverResponded();
              }
            });
           }
         });
         }
       });
}
</script>
</body>
</html>
