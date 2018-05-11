<div class="modal fade" id="mark_tasks_finished_modal" tabindex="-1" role="dialog" data-toggle="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4><?php echo _l('additional_action_required'); ?></h4>
        </div>
        <div class="modal-body">
          <div class="checkbox checkbox-primary">
            <input type="checkbox" name="notify_eventmanager_members_status_change" id="notify_eventmanager_members_status_change">
            <label for="notify_eventmanager_members_status_change"><?php echo _l('notify_eventmanager_members_status_change'); ?></label>
        </div>
        <div class="checkbox checkbox-primary">
            <input type="checkbox" name="mark_all_tasks_as_completed" checked id="mark_all_tasks_as_completed">
            <label for="mark_all_tasks_as_completed"><?php echo _l('eventmanager_mark_all_tasks_as_completed'); ?></label>
        </div>
        <?php if(total_rows('tblemailtemplates',array('slug'=>'eventmanager-finished-to-customer','active'=>0)) == 0 && total_rows('tblcontacts',array('userid'=>$eventmanager->clientid,'active'=>1)) > 0){ ?>
        <div class="form-group eventmanager_marked_as_finished hide no-mbot">
            <hr />
            <div class="checkbox checkbox-primary">
                <input type="checkbox" name="eventmanager_marked_as_finished_email_to_contacts" id="eventmanager_marked_as_finished_email_to_contacts">
                <label for="eventmanager_marked_as_finished_email_to_contacts"><?php echo _l('eventmanager_marked_as_finished_to_contacts'); ?></label>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-info" id="eventmanager_mark_status_confirm" onclick="confirm_eventmanager_status_change(this); return false;"><?php echo _l('eventmanager_mark_tasks_finished_confirm'); ?></button>
    </div>
</div>
</div>
</div>
