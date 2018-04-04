<?php
defined('BASEPATH') or exit('No direct script access allowed');

$has_permission_delete = has_permission('leads','','delete');
$custom_fields = get_table_custom_fields('recycle_bin');

$aColumns     = array(
    'id',
    'item_id',
    'item_name',
    'item_type',
    'dateadded'
    );

$sIndexColumn = "id";
$sTable       = 'tblrecyclebin';


foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_'.$key);
    array_push($customFieldsColumns,$selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN tblcustomfieldsvalues as ctable_' . $key . ' ON tblleads.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where = array();
$filter = false;

if ($this->ci->input->post('custom_view')) {
    $filter = $this->ci->input->post('custom_view');
    if ($filter == 'lost') {
        array_push($where, 'AND lost = 1');
    } elseif ($filter == 'junk') {
        array_push($where, 'AND junk = 1');
    } elseif ($filter == 'not_assigned') {
        array_push($where, 'AND staff_id = 0');
    } elseif ($filter == 'contacted_today') {
        array_push($where, 'AND lastcontact LIKE "'.date('Y-m-d').'%"');
    } elseif ($filter == 'created_today') {
        array_push($where, 'AND dateadded LIKE "'.date('Y-m-d').'%"');
    } elseif ($filter == 'public') {
        array_push($where, 'AND is_public = 1');
    }
}

if (!$filter || ($filter && $filter != 'lost' && $filter != 'junk')) {
    array_push($where, 'AND lost = 0 AND junk = 0');
}

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);


$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();


    $row[] =  $aRow['item_id'];
    $row[] =  $aRow['item_name'];;
    $row[] =  $aRow['item_type'];;
    $row[] =  $aRow['dateadded'];;
     // Custom fields add values
    foreach($customFieldsColumns as $customFieldColumn){
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $options = '<a href="'.getCompleteUrl('settings/archiverestore/'.$aRow['id']).'" class="btn btn-success _delete btn-icon remove-archive-restore">Restore</a>';
    $options .= '<a href="'.getCompleteUrl('/setting/archive').'" class="btn btn-danger _delete btn-icon remove-archive-item">Remove Permanently</a>';

    $row[] = $options;

    $output['aaData'][] = $row;
}
