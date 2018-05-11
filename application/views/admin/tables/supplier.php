<?php
defined('BASEPATH') or exit('No direct script access allowed');



$custom_fields = get_custom_fields('supplier', array(
    'show_on_table' => 1
));

$aColumns      = array(
    'supplierid',
    'businessname',
    'email',
    'abn',
    'active'
);

$sIndexColumn  = "supplierid";
$sTable        = 'tblsuppliers';
$join          = array();
$i             = 0;
foreach ($custom_fields as $field) {

    $select_as = 'cvalue_'.$i;
    if ($field['type'] == 'date_picker' || $field['type'] == 'date_picker_time') {
        $select_as = 'date_picker_cvalue_'.$i;
    }
    array_push($aColumns, 'ctable_'.$i.'.value as '.$select_as);
    array_push($join, 'LEFT JOIN tblcustomfieldsvalues as ctable_' . $i . ' ON tblsuppliers.supplierid = ctable_' . $i . '.relid AND ctable_' . $i . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $i . '.fieldid=' . $field['id']);
    $i++;
}

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$where = do_action('supplier_table_sql_where', array());

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join);


$output  = $result['output'];
$rResult = $result['rResult'];


foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[strafter($aColumns[$i], 'as ')];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }
        if ($aColumns[$i] == 'active') {
            $checked = '';
            if ($aRow['active'] == 1) {
                $checked = 'checked';
            }

            $_data = '<div class="onoffswitch">
                <input type="checkbox" data-switch-url="'.admin_url().'staff/change_staff_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_'.$aRow['staffid'].'" data-id="'.$aRow['staffid'].'" ' . $checked . '>
                <label class="onoffswitch-label" for="c_'.$aRow['staffid'].'"></label>
            </div>';

            // For exporting
            $_data .= '<span class="hide">' . ($checked == 'checked' ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
        } elseif ($aColumns[$i] == 'businessname') {
            $_data = '<a href="' . admin_url('supplier/member/' . $aRow['supplierid']) . '">' . $_data . '</a>';
        } else {
            if ($aColumns[$i] == 'email') {
            $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
            }
        }
        $row[] = $_data;
    }
    $options = icon_btn('supplier/member/' . $aRow['supplierid'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('supplier/delete/' . $aRow['supplierid'], 'remove', 'btn-danger _delete');
    $output['aaData'][] = $row;
}
