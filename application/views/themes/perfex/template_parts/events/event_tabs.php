<ul class="nav nav-tabs no-margin" role="tablist">

    <li role="presentation" class="active eventmanager_tab_overview">
        <a data-group="event_overview" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_overview'); ?>" role="tab"><i class="fa fa-th" aria-hidden="true"></i> <?php echo _l('eventmanager_overview'); ?></a>
    </li>

    <?php
    if($eventmanager->settings->view_tasks == 1 && $eventmanager->settings->available_features['eventmanager_tasks'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_tasks">
        <a data-group="event_tasks" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_tasks'); ?>" role="tab"><i class="fa fa-check-circle" aria-hidden="true"></i> <?php echo _l('tasks'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->view_timesheets == 1 && $eventmanager->settings->available_features['eventmanager_timesheets'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_timesheets">
        <a data-group="event_timesheets" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_timesheets'); ?>" role="tab"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo _l('eventmanager_timesheets'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->view_milestones == 1 && $eventmanager->settings->available_features['eventmanager_milestones'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_milestones">
        <a data-group="event_milestones" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_milestones'); ?>" role="tab"><i class="fa fa-rocket" aria-hidden="true"></i> <?php echo _l('eventmanager_milestones'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->available_features['eventmanager_files'] == 1) { ?>
    <li role="presentation" class="eventmanager_tab_files">
        <a data-group="event_files" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_files'); ?>" role="tab"><i class="fa fa-files-o" aria-hidden="true"></i> <?php echo _l('eventmanager_files'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->available_features['eventmanager_discussions'] == 1) { ?>
    <li role="presentation" class="eventmanager_tab_discussions">
        <a data-group="event_discussions" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_discussions'); ?>" role="tab"><i class="fa fa-commenting" aria-hidden="true"></i> <?php echo _l('eventmanager_discussions'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->view_gantt == 1 && $eventmanager->settings->available_features['eventmanager_gantt'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_gantt">
        <a data-group="event_gantt" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_gantt'); ?>" role="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> <?php echo _l('eventmanager_gant'); ?></a>
    </li>
    <?php } ?>

    <?php if(has_contact_permission('support') && $eventmanager->settings->available_features['eventmanager_tickets'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_tickets">
        <a data-group="event_tickets" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_tickets'); ?>" role="tab"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo _l('eventmanager_tickets'); ?></a>
    </li>
    <?php } ?>

    <?php if(has_contact_permission('estimates') && $eventmanager->settings->available_features['eventmanager_estimates'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_estimates">
        <a data-group="event_estimates" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_estimates'); ?>" role="tab"><i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo _l('estimates'); ?></a>
    </li>
    <?php } ?>

    <?php if(has_contact_permission('invoices') && $eventmanager->settings->available_features['eventmanager_invoices'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_invoices">
        <a data-group="event_invoices" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_invoices'); ?>" role="tab"><i class="fa fa-sun-o" aria-hidden="true"></i> <?php echo _l('eventmanager_invoices'); ?></a>
    </li>
    <?php } ?>

    <?php if($eventmanager->settings->view_activity_log == 1 && $eventmanager->settings->available_features['eventmanager_activity'] == 1){ ?>
    <li role="presentation" class="eventmanager_tab_activity">
        <a data-group="event_activity" href="<?php echo site_url('clients/eventmanager/'.$eventmanager->id.'?group=event_activity'); ?>" role="tab"><i class="fa fa-exclamation" aria-hidden="true"></i> <?php echo _l('eventmanager_activity'); ?></a>
    </li>
    <?php } ?>

</ul>
