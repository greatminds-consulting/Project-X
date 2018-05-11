<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="panel_s">
                    <div class="panel-body">
                        <?php if(has_permission('staff','','create')){ ?>
                            <div class="_buttons">
                                <a href="<?php echo admin_url('supplier/member'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_supplier'); ?></a>
                            </div>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                        <?php } ?>
                        <div class="clearfix"></div>
                        <?php
                        $table_data = array(
                            _l('supplier_dt_id'),
                            _l('supplier_dt_name'),
                            _l('supplier_dt_email'),
                            _l('supplier_abn'),
                             _l('supplier_dt_active'),
                        );
                        $custom_fields = get_custom_fields('supplier',array('show_on_table'=>1));
                        foreach($custom_fields as $field){
                            array_push($table_data,$field['name']);
                        }
                        array_push($table_data,_l('options'));
                        render_datatable($table_data,'supplier');
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script>
    $(function(){
        var headers_staff = $('.table-supplier').find('th');
        var not_sortable_staff = (headers_staff.length - 1);
        initDataTable('.table-supplier', window.location.href, [not_sortable_staff], [not_sortable_staff]);
    });
</script>
</body>
</html>
