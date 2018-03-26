<?php init_head(); ?>
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="no-margin"><?php echo _l('venue_area'); ?></h4>
                                    <hr class="hr-panel-heading" />
                                    <div class="panel-body _buttons">
                                        <?php if(has_permission('amenities','','create')){ ?>
                                            <a href="<?php echo admin_url('venues/area'); ?>"  class="btn btn-info pull-left display-block"><?php echo _l('new_area'); ?></a>
                                        <?php } ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered amenities">
                                            <thead>
                                            <tr>
                                                <th><?php echo _l('area_name'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($areas as $area){ ?>
                                                <tr>
                                                    <td class="<?php if($area['active'] == 0){echo 'text-throught';} ?>">
                                                        <a href="<?php echo admin_url('venues/area/'.$area['id']); ?>"><?php echo $area['name']; ?></a>
                                                        <a href="<?php echo admin_url('venues/area'.($area['active'] == '1' ? 'disable/' : 'enable/').$area['id']); ?>" class="pull-right"><small><?php echo _l($area['active'] == 1 ? 'disable' : 'enable'); ?></small></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php init_tail(); ?>