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
                                                <th><?php echo _l('area_layout_minimum'); ?></th>
                                                <th><?php echo _l('area_layout_maximum'); ?></th>
                                                <th><?php echo _l('area_layout'); ?></th>
                                                <th class="pull-right">Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($areas as $area){ ?>
                                                <tr>
                                                    <td class="<?php if($area['area_active'] == 0){echo 'text-throught';} ?>">
                                                        <a href="<?php echo admin_url('venues/area/'.$area['area_id']); ?>"><?php echo $area['area_name']; ?></a>
                                                    </td>
                                                    <td>
                                                       <p><?php echo $area['layout_minimum'];?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $area['layout_maximum'];?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $area['name'];?></p>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo admin_url('venues/area'.($area['area_active'] == '1' ? 'disable/' : 'enable/').$area['area_id']); ?>" class="pull-right"><small><?php echo _l($area['area_active'] == 1 ? 'disable' : 'enable'); ?></small></a>
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