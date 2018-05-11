<?php echo form_hidden('eventmanager_id',$eventmanager->id); ?>
<div class="panel_s">
    <div class="panel-body">
        <h3 class="bold mtop10 project-name pull-left"><?php echo $eventmanager->name; ?></h3>
        <?php if($eventmanager->settings->view_tasks == 1 && $eventmanager->settings->create_tasks == 1){ ?>
            <a href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=new_task'); ?>" class="btn btn-info pull-right mtop5"><?php echo _l('new_task'); ?></a>
        <?php } ?>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <?php get_template_part('events/event_tabs'); ?>
        <div class="clearfix mtop15"></div>
        <?php get_template_part('events/'.$group); ?>
    </div>
</div>
