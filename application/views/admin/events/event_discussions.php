<?php if(!isset($discussion)){ ?>
<a href="#" onclick="new_discussion();return false;" class="btn btn-info mbot25"><?php echo _l('new_eventmanager_discussion'); ?></a>
<?php
    $this->load->view('admin/events/event_discussion');
    render_datatable(array(
     _l('eventmanager_discussion_subject'),
     _l('eventmanager_discussion_last_activity'),
     _l('eventmanager_discussion_total_comments'),
     _l('eventmanager_discussion_show_to_customer'),
     _l('options'),
     ),'eventmanager-discussions'); ?>
<?php } else { ?>
<h3 class="bold no-margin"><?php echo $discussion->subject; ?></h3>
<hr />
<p class="no-margin"><?php echo _l('eventmanager_discussion_posted_on',_d($discussion->datecreated)); ?></p>
<p class="no-margin">
    <?php if($discussion->staff_id == 0){
        echo _l('eventmanager_discussion_posted_by',get_contact_full_name($discussion->contact_id)) . ' <span class="label label-info inline-block">'._l('is_customer_indicator').'</span>';
        } else {
        echo _l('eventmanager_discussion_posted_by',get_staff_full_name($discussion->staff_id));
        }
        ?>
</p>
<p><?php echo _l('eventmanager_discussion_total_comments'); ?>: <?php echo total_rows('tbleventdiscussioncomments',array('discussion_id'=>$discussion->id)); ?>
<p class="text-muted"><?php echo $discussion->description; ?></p>
<hr />
<div id="discussion-comments"></div>
<?php } ?>
