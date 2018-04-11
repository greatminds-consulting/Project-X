<?php init_head(); ?>
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <div class="clearfix"></div>
                            <?php render_datatable(
                                array(
                                    '#',
                                    _l('item_name'),
                                    _l('item_type'),
                                    _l('archived_date'),
                                    _l('options'),
                                ),'recycle_bin'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php init_tail(); ?>
    <script>
        $(function(){
            initDataTable('.table-recycle_bin', window.location.href, [4], [4]);
        });
    </script>





















<?php
//$table_data = array();
//$_table_data = array(
//    '#',
//    _l('item_name'),
//    _l('item_type'),
//    _l('archived_date'),
//);
//foreach($_table_data as $_t){
//    array_push($table_data,$_t);
//}
//$custom_fields = get_custom_fields('recycle_bin',array('show_on_table'=>1));
//foreach($custom_fields as $field){
//    array_push($table_data,$field['name']);
//}
//$table_data = do_action('recycle_bin_table_columns',$table_data);
//$_op = _l('options');
//array_push($table_data,$_op);
//render_datatable($table_data,'recycle_bin'); ?>