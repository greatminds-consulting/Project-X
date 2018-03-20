<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'id',
    'name',
    'specifications',
    'ceiling_height',
    'foyer_area',
    'balcony_area',
);
$sIndexColumn = "id";
$sTable       = 'tblvenuerooms';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name' || $aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('rooms/edit/' . $aRow['id']) . '">' . $_data . '</a>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('rooms/edit/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('rooms/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
