<?php
defined('BASEPATH') or exit('No direct script access allowed');

$has_permission_delete = has_permission('leads','','delete');
$custom_fields = get_table_custom_fields('areas');

$aColumns     = array(
    'tblvenueareas.id as id',
    'tblvenueareas.name as name',
    'tblvenueareas.active as active',
    get_sql_select_area_layout_full_names().' as layouts',
    get_sql_select_area_amenities_full_names().' as amenities',
    );

$sIndexColumn = "id";
$sTable       = 'tblvenueareas';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);

$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = array();
        $row[] = $aRow['id'];
        $row[] = $aRow['name'];
        $row[] = $aRow['layouts'];
        $row[] = $aRow['amenities'];
    $options = icon_btn('venues/area/' . $aRow['id'], 'pencil-square-o');
    $options .= icon_btn('venues/areaDelete/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $row[]   = $options .= '<a href="area'.($aRow['active'] == 1 ? 'disable/' : 'enable/').$aRow['id'].'">'.($aRow['active'] == 1 ? 'Disable' : 'Enable').'</a>';

$output['aaData'][] = $row;
}


