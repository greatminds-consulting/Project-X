<?php init_head(); ?>
<div id="wrapper">
    <div class="content email-templates">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l('templates'); ?></h4>
                                <div class="panel-body _buttons">
                                    <?php if(has_permission('templates','','create')){ ?>
                                        <a href="<?php echo admin_url('templates/new_template'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_template'); ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <h4 class="bold well email-template-heading">
                                    <?php echo _l('email_template_proposals_fields_heading'); ?>
                                     <?php if($hasPermissionEdit){ ?>
                                      <a href="<?php echo admin_url('templates/disable_by_type/proposals'); ?>" class="pull-right mleft5 mright25"><small><?php echo _l('disable_all'); ?></small></a>
                                      <a href="<?php echo admin_url('templates/enable_by_type/proposals'); ?>" class="pull-right"><small><?php echo _l('enable_all'); ?></small></a>
                                     <?php } ?>

                                    </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('email_templates_table_heading_name'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($proposals as $proposal_template){ ?>
                                            <tr>
                                                <td class="<?php if($proposal_template['active'] == 0){echo 'text-throught';} ?>">
                                                    <a href="<?php echo admin_url('templates/template/'.$proposal_template['templateid']); ?>"><?php echo $proposal_template['name']; ?></a>
                                                    <?php if(ENVIRONMENT !== 'production'){ ?>
                                                    <br/><small><?php echo $proposal_template['slug']; ?></small>
                                                    <?php } ?>
                                                    <?php if($hasPermissionEdit){ ?>
                                                    <a href="<?php echo admin_url('templates/'.($proposal_template['active'] == '1' ? 'disable/' : 'enable/').$proposal_template['templateid']); ?>" class="pull-right"><small><?php echo _l($proposal_template['active'] == 1 ? 'disable' : 'enable'); ?></small></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>
