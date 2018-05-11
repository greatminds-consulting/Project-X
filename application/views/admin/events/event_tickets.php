<?php
    $this->load->view('admin/tickets/summary',array('event_manager_id'=>$eventmanager->id));
    echo form_hidden('event_manager_id',$eventmanager->id);
    echo '<div class="clearfix"></div>';
    if(((get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member())){
        echo '<a href="'.admin_url('tickets/add?event_manager_id='.$eventmanager->id).'" class="mbot20 btn btn-info">'._l('new_ticket').'</a>';
    }
    echo AdminTicketsTableStructure('tickets-table');
?>
