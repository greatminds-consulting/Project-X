<div class="eventmanager-toggler-opts">
   <?php if(has_permission('events','','create')){ ?>
   <a href="#" class="btn btn-info" onclick="new_milestone();return false;"><?php echo _l('new_milestone'); ?></a>
   <?php } ?>
   <a href="#" class="btn btn-default" onclick="eventmilestones_switch_view(); return false;"><i class="fa fa-th-list"></i></a>
   <?php if($milestones_found) { ?>
   <div id="kanban-params">
      <div class="checkbox mbot20 mtop20">
         <input type="checkbox" value="yes" id="exclude_completed_tasks" name="exclude_completed_tasks"<?php if($milestones_exclude_completed_tasks){echo ' checked';} ?> onclick="window.location.href = '<?php echo admin_url('eventmanager/view/'.$eventmanager->id.'?group=event_milestones&exclude_completed='); ?>'+(this.checked ? 'yes' : 'no')">
         <label for="exclude_completed_tasks"><?php echo _l('exclude_completed_tasks') ?></label>
      </div>
      <div class="clearfix"></div>
      <?php echo form_hidden('event_manager_id',$eventmanager->id); ?>
   </div>
   <?php } ?>
</div>
<?php if($milestones_found){ ?>
<div class="eventmanager-milestones-kanban">
   <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
      <div class="row">
         <div class="container-fluid">
            <div id="kan-ban"></div>
         </div>
      </div>
   </div>
</div>
<?php } else { ?>
<div class="alert alert-info mtop15 no-mbot">
   <?php echo _l('no_eventmilestones_found'); ?>
</div>
<?php } ?>
<div id="eventmilestones-table" class="hide mtop25">
   <?php render_datatable(array(
      _l('milestone_name'),
      _l('milestone_due_date'),
      _l('options')
      ),'milestones'); ?>
   </div>
