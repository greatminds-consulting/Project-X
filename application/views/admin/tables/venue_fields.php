<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$aColumns     = array(
    'id',
    'name',
    'address1',
    'address2',
    'email',
    'phone',
    'details',
);
$sIndexColumn = "id";
$sTable       = 'tblvenues';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] == 'address2') {
            continue;
        }
        if ($aColumns[$i] == 'address1') {
            $_data = $aRow['address1'].' '. $aRow['address2'];
        } else {
            $_data = $aRow[$aColumns[$i]];

        }
        if ($aColumns[$i] == 'name' || $aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('venues/edit/' . $aRow['id']) . '">' . $_data . '</a>';
        }
    $row[] = $_data;
    }

    $options = icon_btn('venues/edit/' . $aRow['id'], 'pencil-square-o');
    $row[]   = $options .= icon_btn('venues/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
