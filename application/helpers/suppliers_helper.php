<?php
/**
 * Used in:
 * Search contact tickets
 * Project dropdown quick switch
 * Calendar tooltips
 * @param  [type] $userid [description]
 * @return [type]         [description]
 */
function get_supplier_company_name($userid, $prevent_empty_company = false)
{
    $_userid = get_supplier_user_id();
    if ($userid !== '') {
        $_userid = $userid;
    }
    $CI =& get_instance();

    $supplier = $CI->db->select('businessname')
        ->where('supplierid', $_userid)
        ->from('tblsuppliers')
        ->get()
        ->row();
    if ($supplier) {
        return $supplier->businessname;
    } else {
        return '';
    }
}