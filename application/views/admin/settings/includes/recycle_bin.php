<?php
$table_data = array();
$_table_data = array(
    '#',
    _l('item_name'),
    _l('item_type'),
    _l('archived_date'),
);
foreach($_table_data as $_t){
    array_push($table_data,$_t);
}
$custom_fields = get_custom_fields('recycle_bin',array('show_on_table'=>1));
foreach($custom_fields as $field){
    array_push($table_data,$field['name']);
}
$table_data = do_action('recycle_bin_table_columns',$table_data);
$_op = _l('options');
array_push($table_data,$_op);
render_datatable($table_data,'recycle_bin'); ?>