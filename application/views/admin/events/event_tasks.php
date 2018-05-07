<!-- eventmanager Tasks -->
<?php
    if($eventmanager->settings->hide_tasks_on_main_tasks_table == '1') {
        echo '<i class="fa fa-exclamation fa-2x pull-left" data-toggle="tooltip" data-title="'._l('eventmanager_hide_tasks_settings_info').'"></i>';
    }
?>
<div class="tasks-table">
    <?php init_relation_eventmanagertasks_table(array( 'data-new-rel-id'=>$eventmanager->id,'data-new-rel-type'=>'eventmanager')); ?>
</div>
