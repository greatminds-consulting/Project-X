<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'subject',
    'last_activity',
    '(SELECT COUNT(*) FROM tbleventdiscussioncomments WHERE discussion_id = tbleventdiscussions.id)',
    'show_to_customer',
);
$sIndexColumn = "id";
$sTable       = 'tbleventdiscussions';
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable, array(), array('AND event_manager_id='.$event_manager_id), array(
    'id',
    'description',
));
$output       = $result['output'];
$rResult      = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i] == 'subject'){
            $_data = '<a href="'.admin_url('eventmanager/view/'.$event_manager_id.'?group=event_discussions&discussion_id='.$aRow['id']).'">'.$_data.'</a>';
        } else if($aColumns[$i] == 'show_to_customer'){
            if($_data == 1){
                $_data = _l('eventmanager_discussion_visible_to_customer_yes');
            } else {
                $_data = _l('eventmanager_discussion_visible_to_customer_no');
            }
        } else if($aColumns[$i] == 'last_activity'){
            if(!is_null($_data)){
                $_data ='<span class="text-has-action" data-toggle="tooltip" data-title="'._dt($_data).'">' . time_ago($_data) . '</span>';
            } else {
                $_data = _l('eventmanager_discussion_no_activity');
            }
        }
        $row[] = $_data;
    }
    $options = '';
    if(has_permission('events','','edit')){
        $options .= icon_btn('#', 'pencil-square-o','btn-default',array('onclick'=>'edit_discussion(this,'.$aRow['id'].'); return false;','data-subject'=>$aRow['subject'],'data-description'=>clear_textarea_breaks($aRow['description']),'data-show-to-customer'=>$aRow['show_to_customer']));
    }
    if(has_permission('events','','delete')){
        $options .= icon_btn('#', 'remove', 'btn-danger',array('onclick'=>'delete_eventmanager_discussion('.$aRow['id'].'); return false'));

    }
    $row[]   = $options;

    $output['aaData'][] = $row;
}
