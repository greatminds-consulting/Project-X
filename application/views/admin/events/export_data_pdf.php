<?php

$pdf = new Pdf('L', 'mm', 'landscape', true, 'UTF-8', false);
$pdf->SetTitle($eventmanager->name);
$this->pdf->SetMargins(PDF_MARGIN_LEFT, 26, PDF_MARGIN_RIGHT);
$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$this->pdf->SetAutoPageBreak(TRUE, 30);
$pdf->SetAuthor(get_option('company'));
$pdf->SetFont(get_option('pdf_font'), '', get_option('pdf_font_size'));
$pdf->AddPage();
$dimensions = $pdf->getPageDimensions();
$custom_fields = get_custom_fields('eventmanager');

$divide_document_overview = 3;
// If custom fields found divide the overview in 4 parts not in 3 to include the custom fields too
if(count($custom_fields) > 0){
    $divide_document_overview = 4;
}

// Like heading eventmanager name
$html = '<h1>'._l('eventmanager_name').': '.$eventmanager->name.'</h1>';
// eventmanager overview heading
$html .= '<h3>'.ucwords(_l('eventmanager_overview')).'</h3>';
if(!empty($eventmanager->description)){
    // eventmanager description
    $html .= '<p><b style="background-color:#f0f0f0;">' . _l('eventmanager_description') . '</b><br /><br /> ' . $eventmanager->description . '</p>';
}

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Ln(10);
$html = '';
// eventmanager overview
// Billing type
if($eventmanager->billing_type == 1){
  $type_name = 'eventmanager_billing_type_fixed_cost';
} else if($eventmanager->billing_type == 2){
  $type_name = 'eventmanager_billing_type_eventmanager_hours';
} else {
  $type_name = 'eventmanager_billing_type_eventmanager_task_hours';
}
$html .= '<b style="background-color:#f0f0f0;">'._l('eventmanager_overview').'</b><br /><br />';

$html .= '<b>'._l('eventmanager_billing_type').': </b>' . _l($type_name) . '<br />';

if($eventmanager->billing_type == 1 || $eventmanager->billing_type == 2){
  if($eventmanager->billing_type == 1){
      $html .= '<b>'._l('eventmanager_total_cost').': </b>' . format_money($eventmanager->eventmanager_cost,$eventmanager->currency_data->symbol) . '<br />';
  } else {
    $html .= '<b>'._l('eventmanager_rate_per_hour').': </b>' . format_money($eventmanager->eventmanager_rate_per_hour,$eventmanager->currency_data->symbol) . '<br />';
  }
}
$status = get_eventmanager_status_by_id($eventmanager->status);
// eventmanager status
$html .= '<b>' . _l('eventmanager_status') . ': </b>' . $status['name'] . '<br />';
// Date created
$html .= '<b>' . _l('eventmanager_datecreated') . ': </b>' . _d($eventmanager->eventmanager_created) . '<br />';
// Start date
$html .= '<b>' . _l('eventmanager_start_date') . ': </b>' . _d($eventmanager->start_date) . '<br />';
// Deadline
$d = $eventmanager->deadline ? _d($eventmanager->deadline) : '/';
$html .= '<b>' . _l('eventmanager_deadline') . ': </b>' . $d  . '<br /><br />';
// Total Days
$html .= '<b>' . _l('total_eventmanager_worked_days') . ': </b>' . $total_days . '<br />';
// Total logged hours for this eventmanager
$html .= '<b>' . _l('eventmanager_overview_total_logged_hours') . ': </b>' . $total_logged_time . '<br />';
// Total members
$html .= '<b>' . _l('total_eventmanager_members') . ': </b>' . $total_members . '<br />';
// Total files
$html .= '<b>' . _l('total_eventmanager_files') . ': </b>' . $total_files_attached . '<br />';
// Total Discussions
$html .= '<b>' . _l('total_eventmanager_discussions_created') . ': </b>' . $total_files_attached . '<br />';
// Total Milestones
$html .= '<b>' . _l('total_milestones') . ': </b>' . $total_milestones . '<br />';
// Total Tickets
$html .= '<b>' . _l('total_tickets_related_to_eventmanager') . ': </b>' . $total_tickets . '<br />';
// Write eventmanager overview data
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

$html = '';
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('finance_overview')) . '</b><br /><br />';
$html .= '<b>' . _l('eventmanager_total_invoices_created') . ' </b>' . $total_invoices .'<br />';
// Not paid invoices total
$html .= '<b>' . _l('outstanding_invoices') . ' </b>' . format_money($invoices_total_data['due'],$eventmanager->currency_data->symbol) .'<br />';
// Due invoices total
$html .= '<b>' . _l('past_due_invoices') . ' </b>' . format_money($invoices_total_data['overdue'],$eventmanager->currency_data->symbol) .'<br />';
// Paid invoices
$html .= '<b>' . _l('paid_invoices') . ' </b>' . format_money($invoices_total_data['paid'],$eventmanager->currency_data->symbol) .'<br /><br />';

// Finance Overview
if($eventmanager->billing_type == 2 || $eventmanager->billing_type == 3) {
    // Total logged time + money
    $logged_time_data = $this->eventmanager_model->total_logged_time_by_billing_type($eventmanager->id);
    $html .= '<b>' . _l('eventmanager_overview_logged_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$eventmanager->currency_data->symbol) .'<br />';
    // Total billable time + money
    $logged_time_data = $this->eventmanager_model->data_billable_time($eventmanager->id);
    $html .= '<b>' . _l('eventmanager_overview_billable_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$eventmanager->currency_data->symbol) .'<br />';
    // Total billed time + money
    $logged_time_data = $this->eventmanager_model->data_billed_time($eventmanager->id);
    $html .= '<b>' . _l('eventmanager_overview_billed_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$eventmanager->currency_data->symbol) .'<br />';
    // Total unbilled time + money
    $logged_time_data = $this->eventmanager_model->data_unbilled_time($eventmanager->id);
    $html .= '<b>' . _l('eventmanager_overview_unbilled_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$eventmanager->currency_data->symbol) .'<br /><br/>';
}

// Total expenses + money
$html .= '<b>' . _l('eventmanager_overview_expenses') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id),'field'=>'amount')),$eventmanager->currency_data->symbol) . '<br />';
// Billable expenses + money
$html .= '<b>' . _l('eventmanager_overview_expenses_billable') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'billable'=>1),'field'=>'amount')),$eventmanager->currency_data->symbol) . '<br />';
// Billed expenses + money
$html .= '<b>' . _l('eventmanager_overview_expenses_billed') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'invoiceid !='=>'NULL','billable'=>1),'field'=>'amount')),$eventmanager->currency_data->symbol) . '<br />';
// Unbilled expenses + money
$html .= '<b>' . _l('eventmanager_overview_expenses_unbilled') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('event_manager_id'=>$eventmanager->id,'invoiceid IS NULL','billable'=>1),'field'=>'amount')),$eventmanager->currency_data->symbol) . '<br />';
// Write finance overview
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

// Custom fields
// Check for custom fields
if(count($custom_fields) > 0) {
$html = '';
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('eventmanager_custom_fields')) . '</b><br /><br />';

foreach($custom_fields as $field){
    $value = get_custom_field_value($eventmanager->id,$field['id'],'eventmanager');
    $value = $value === '' ? '/' : $value;
    $html .= '<b>' . ucfirst($field['name']) . ': </b>' . $value . '<br />';
}

// Write custom fields
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);
}

$html = '';
// Customer Info
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('eventmanager_customer')) . '</b><br /><br /><b>'.$eventmanager->client_data->company . '</b><br />';
$html .= $eventmanager->client_data->address . '<br />';

if(!empty($eventmanager->client_data->city)){
    $html .= $eventmanager->client_data->city;
}
if(!empty($eventmanager->client_data->state)){
    $html .=', '.$eventmanager->client_data->state;
}
$country = get_country_short_name($eventmanager->client_data->country);
if(!empty($country)){
    $html .= '<br />'.$country;
}
if(!empty($eventmanager->client_data->zip)){
    $html .= ', ' .$eventmanager->client_data->zip;
}
if(!empty($eventmanager->client_data->phonenumber)){
    $html .= '<br />' .$eventmanager->client_data->phonenumber;
}
if (!empty($eventmanager->client_data->vat)) {
    $html .= '<br />'._l('client_vat_number') . ': ' . $eventmanager->client_data->vat;
}

// Write custom info
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

// Set new lines to prevent overlaping the content
$pdf->Ln(80);
// $pdf->setY(140);
// eventmanager members overview
$html = '';
// Heading
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('eventmanager_members_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="12.5%"><b>'._l('eventmanager_member').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('staff_total_task_assigned').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('staff_total_comments_on_tasks').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_eventmanager_discussions_created').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_eventmanager_discussions_comments').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_eventmanager_files').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($members as $member){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td>'.get_staff_full_name($member['staff_id']).'</td>';
        $html .= '<td>'.total_rows('tblstafftasks','rel_type="eventmanager" AND rel_id="'.$eventmanager->id.'" AND id IN (SELECT taskid FROM tblstafftaskassignees WHERE staffid="'.$member['staff_id'].'")').'</td>';
        $html .= '<td>'.total_rows('tblstafftaskcomments','staffid = '.$member['staff_id']. ' AND taskid IN (SELECT id FROM tblstafftasks WHERE rel_type="eventmanager" AND rel_id="'.$eventmanager->id.'")').'</td>';
        $html .= '<td>'.total_rows('tbleventdiscussions',array('staff_id'=>$member['staff_id'],'event_manager_id'=>$eventmanager->id)).'</td>';
        $html .= '<td>'.total_rows('tbleventdiscussioncomments','staff_id='.$member['staff_id'] . ' AND discussion_id IN (SELECT id FROM tbleventdiscussions WHERE event_manager_id='.$eventmanager->id.')').'</td>';
        $html .= '<td>'.total_rows('tbleventfiles',array('staffid'=>$member['staff_id'],'event_manager_id'=>$eventmanager->id)).'</td>';
        $member_tasks_assigned = $this->tasks_model->get_tasks_by_staff_id($member['staff_id'],array('rel_id'=>$eventmanager->id,'rel_type'=>'eventmanager'));
        $seconds = 0;
        foreach($member_tasks_assigned as $member_task){
            $seconds += $this->tasks_model->calc_task_total_time($member_task['id'],' AND staff_id='.$member['staff_id']);
        }
        $html .= '<td>'.seconds_to_time_format($seconds).'</td>';
        $html .= '<td>'.sec2qty($seconds).'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write eventmanager members table data
$pdf->writeHTML($html, true, false, false, false, '');

// Tasks overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('detailed_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="26.12%"><b>'._l('tasks_dt_name').'</b></th>';
$html .= '<th width="12%"><b>'._l('total_task_members_assigned').'</b></th>';
$html .= '<th width="12%"><b>'._l('total_task_members_followers').'</b></th>';
$html .= '<th width="9.28%"><b>'._l('task_single_start_date').'</b></th>';
$html .= '<th width="9.28%"><b>'._l('task_single_due_date').'</b></th>';
$html .= '<th width="7%"><b>'._l('task_status').'</b></th>';
$html .= '<th width="14.28%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="10%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($tasks as $task){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td width="26.12%">'.$task['name'].'</td>';
        $html .= '<td width="12%">'.total_rows('tblstafftaskassignees',array('taskid'=>$task['id'])).'</td>';
        $html .= '<td width="12%">'.total_rows('tblstafftasksfollowers',array('taskid'=>$task['id'])).'</td>';
        $html .= '<td width="9.28%">'._d($task['startdate']).'</td>';
        $html .= '<td width="9.28%">'.(is_date($task['duedate']) ? _d($task['duedate']): '').'</td>';
        $html .= '<td width="7%">'.format_task_status($task['status'],true,true).'</td>';
        $html .= '<td width="14.28%">'.seconds_to_time_format($task['total_logged_time']).'</td>';
        $html .= '<td width="10%">'.sec2qty($task['total_logged_time']).'</td>';

    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write tasks data
$pdf->writeHTML($html, true, false, false, false, '');

// Timesheets overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('timesheets_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="16.66%"><b>'._l('eventmanager_timesheet_user').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('eventmanager_timesheet_task').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('eventmanager_timesheet_start_time').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('eventmanager_timesheet_end_time').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($timesheets as $timesheet){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td>'.get_staff_full_name($timesheet['staff_id']).'</td>';
        $html .= '<td>' . $timesheet['task_data']->name . '</td>';
        $html .= '<td>'._dt($timesheet['start_time'],true).'</td>';
        $html .= '<td>'.(!is_null($timesheet['end_time']) ? _dt($timesheet['end_time'],true) : '').'</td>';
        $html .= '<td>'.seconds_to_time_format($timesheet['total_spent']).'</td>';
        $html .= '<td>'.sec2qty($timesheet['total_spent']).'</td>';

    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write timesheets data
$pdf->writeHTML($html, true, false, false, false, '');

// Milestones overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('eventmanager_milestones_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="20%"><b>'._l('milestone_name').'</b></th>';
$html .= '<th width="30%"><b>'._l('milestone_description').'</b></th>';
$html .= '<th width="15%"><b>'._l('milestone_due_date').'</b></th>';
$html .= '<th width="15%"><b>'._l('total_tasks_in_milestones').'</b></th>';
$html .= '<th width="20%"><b>'._l('milestone_total_logged_time').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($milestones as $milestone){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td width="20%">'.$milestone['name'].'</td>';
        $html .= '<td width="30%">'.$milestone['description'].'</td>';
        $html .= '<td width="15%">'._d($milestone['due_date']).'</td>';
        $html .= '<td width="15%">'.total_rows('tblstafftasks',array('milestone'=>$milestone['id'],'rel_id'=>$eventmanager->id,'rel_type'=>'eventmanager')).'</td>';
        $html .= '<td width="20%">'.seconds_to_time_format($milestone['total_logged_time']).'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write milestones table data
$pdf->writeHTML($html, true, false, false, false, '');

if (ob_get_length() > 0 && ENVIRONMENT == 'production') {
    ob_end_clean();
}

// Output PDF to user
$pdf->output('#'.$eventmanager->id.'_' . $eventmanager->name.'_'._d(date('Y-m-d')).'.pdf','I');
