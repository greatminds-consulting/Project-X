<?php init_head(); ?>
<div id="wrapper">
    <div class="content email-templates">
          <div class="row">
                <div class="col-md-12">
                        <div class="panel_s">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="no-margin"><?php echo _l('venue_settings'); ?></h4>
                                        <hr class="hr-panel-heading" />
                                        <h4 class="bold well email-template-heading">
                                            <?php echo _l('amenities_title'); ?>
                                            <?php if($hasPermissionEdit){ ?>
                                                <a href="" class="pull-right mleft5 mright25"><small><?php echo _l('disable_all'); ?></small></a>
                                                <a href="" class="pull-right"><small><?php echo _l('enable_all'); ?></small></a>
                                            <?php } ?>
                                        </h4>
                                        <div class="panel-body _buttons">
                                            <?php if(has_permission('amenities','','create')){ ?>
                                                <a href="#" class="btn btn-info pull-left display-block" onclick="new_amenities();return false;"><?php echo _l('new_amenities'); ?></a>
                                            <?php } ?>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered amenities">
                                                <thead>
                                                <tr>
                                                    <th><?php echo _l('amenities_name'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($amenities as $amenitiy){ ?>
                                                    <tr class="amenity_<?php echo $amenitiy['id']?>">
                                                        <td class="<?php if($amenitiy['active'] == 0){echo 'text-throught';} ?>">
                                                            <a href="#" onclick="edit_amenities(<?php echo $amenitiy['id']?>,'<?php echo $amenitiy['name']?>');return false;"><?php echo $amenitiy['name']; ?></a>
                                                            <a href="" class="pull-right"><small><?php echo _l($amenitiy['active'] == 1 ? 'disable' : 'enable'); ?></small></a>
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
<?php $this->load->view('admin/venues/venue_amenities'); ?>
<?php init_tail(); ?>
