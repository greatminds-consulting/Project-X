<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('venues/area'); ?>"  class="btn btn-info pull-left display-block"><?php echo _l('new_area'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php render_datatable(
                            array(
                                _l('#'),
                                _l('name'),
                                _l('Layout Name'),
                                _l('Amenities Name'),
                                _l('options')
                            ),'areas'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-areas', window.location.href, [4], [4]);
    });
</script>
</body>
</html>
