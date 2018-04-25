<?php init_head(); ?>
<div id="wrapper">
<div class="content">
<div class="row">

<?php if(isset($member)){ ?>
    <div class="member">
        <?php echo form_hidden('isedit'); ?>
        <?php echo form_hidden('memberid',$member->supplierid); ?>
    </div>

    <div class="col-md-12">
        <?php if(total_rows('tbldepartments',array('email'=>$member->email)) > 0) { ?>
            <div class="alert alert-danger">
                The staff member email exists also as support department email, according to the docs, the support department email must be unique email in the system, you must change the staff email or the support department email in order all the features to work properly.
            </div>
        <?php } ?>
        <div class="panel_s">
            <div class="panel-body">
                <h4 class="no-margin"><?php echo $member->businessname; ?>

                </h4>
            </div>
        </div>
    </div>
<?php } ?>
<?php echo form_open_multipart($this->uri->uri_string(),array('class'=>'staff-form','autocomplete'=>'off')); ?>
 <div class="col-md-<?php if(!isset($member)){echo '8 col-md-offset-2';} else {echo '5';} ?>" id="small-table">
<div class="panel_s">
<div class="panel-body">
    <h2>Supplier Profile</h2>
    <hr />

<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="tab_staff_profile">
    <?php $rel_id = (isset($member) ? $member->supplierid : false); ?>
    <?php echo render_custom_fields('supplier',$rel_id); ?>

    <?php $value = (isset($member) ? $member->businessname : ''); ?>
    <?php $attrs = (isset($member) ? array() : array('autofocus'=>true)); ?>
    <?php echo render_input('businessname','supplier_add_edit_businessname',$value,'text',$attrs); ?>
    <?php $value = (isset($member) ? $member->email : ''); ?>
    <?php echo render_input('email','supplier_add_edit_email',$value,'email',array('autocomplete'=>'off')); ?>
    <div class="form-group">
        <label for="abn" class="control-label"> <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="Australian Business Number"></i>ABN</label>
        <input type="text" class="form-control" name="abn" value="<?php if(isset($member)){echo $member->abn;} ?>">
    </div>
    <div class="form-group">
        <label for="abn" class="control-label"> <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="Australian Company Number"></i>ACN</label>
        <input type="text" class="form-control" name="acn" value="<?php if(isset($member)){echo $member->acn;} ?>">
    </div>
    <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('address1'); ?>"></i>
    <?php $value = (isset($member) ? $member->address1 : ''); ?>
    <?php echo render_textarea('address1','address1',$value); ?>

    <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('address2'); ?>"></i>
    <?php $value = (isset($member) ? $member->address2 : ''); ?>
    <?php echo render_textarea('address2','address2',$value); ?>
    <div class="form-group">
        <label for="state" class="control-label"> <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="state"></i>State</label>
        <input type="text" class="form-control" name="state" value="<?php if(isset($member)){echo $member->state;} ?>">
    </div>
    <div class="form-group">
        <label for="lastname"><?php echo _l('clients_country'); ?></label>
        <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" data-live-search="true" name="country" class="form-control" id="country">
            <option value=""></option>
            <?php foreach(get_all_countries() as $country){ ?>
                <?php
                $selected = '';
                if($member->country == $country['country_id']){echo $selected = true;}
                ?>
                <option value="<?php echo $country['country_id']; ?>" <?php echo set_select('country', $country['country_id'],$selected); ?>><?php echo $country['short_name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="postcode" class="control-label"> <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="Post Code"></i>Post code</label>
        <input type="number" class="form-control" name="postcode" value="<?php if(isset($member)){echo $member->postcode;} ?>">
    </div>
    <label for="password" class="control-label"><?php echo _l('supplier_add_edit_password'); ?></label>
    <div class="input-group">
        <input type="password" class="form-control password" name="password" autocomplete="off" >
                        <span class="input-group-addon">
                        <a href="#password" class="show_password" onclick="showPassword('password'); return false;"><i class="fa fa-eye"></i></a>
                        </span>
                        <span class="input-group-addon">
                        <a href="#" class="generate_password" onclick="generatePassword(this);return false;"><i class="fa fa-refresh"></i></a>
                        </span>
    </div>
    <?php if(isset($member)){ ?>
        <p class="text-muted"><?php echo _l('staff_add_edit_password_note'); ?></p>
        <?php if($member->last_password_change != NULL){ ?>
            <?php echo _l('staff_add_edit_password_last_changed'); ?>:
            <span class="text-has-action" data-toggle="tooltip" data-title="<?php echo _dt($member->last_password_change); ?>">
                        <?php echo time_ago($member->last_password_change); ?>
                     </span>
        <?php } } ?>


    <div class="clearfix"></div>
    <hr />
    <p class="bold"><?php echo _l('customer_permissions'); ?></p>
    <p class="text-danger"><?php echo _l('supplier_permissions_info'); ?></p>
    <?php
    $default_supplier_permissions = array();
    if(!isset($member)){
        $default_supplier_permissions = @unserialize(get_option('default_supplier_permissions'));
    }
    ?>
    <?php foreach($supplier_permissions as $permission){ ?>
        <div class="col-md-6 row">
            <div class="row">
                <div class="col-md-6 mtop10 border-right">
                    <span><?php echo $permission['name']; ?></span>
                </div>
                <div class="col-md-6 mtop10">
                    <div class="onoffswitch">
                        <input type="checkbox" id="<?php echo $permission['id']; ?>" class="onoffswitch-checkbox" <?php if(isset($member) && has_supplier_permission($permission['short_name'],$member->supplierid) || is_array($default_supplier_permissions) && in_array($permission['id'],$default_supplier_permissions)){echo 'checked';} ?> value="<?php echo $permission['id']; ?>" name="permissions[]">
                        <label class="onoffswitch-label" for="<?php echo $permission['id']; ?>"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
    <hr />

</div>
</div>
</div>
</div>
</div>
<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>
<?php echo form_close(); ?>
    <?php if(isset($member)){ ?>
        <div class="col-md-7 small-table-right-col">
            <div class="panel_s">
                <div class="panel-body">
                    <h4 class="no-margin">
                        <?php echo _l('supplier_items'); ?>
                    </h4>
                    <hr class="hr-panel-heading" />
                    <?php
                    $data['id']=1;?>
                    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#sales_item_modal"><?php echo _l('new_invoice_item'); ?></a>
                    <?php $this->load->view('admin/invoice_items/item',$data); ?>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />

                    <div class="clearfix"></div>
                    <div class="mtop15">
                        <table class="table dt-table scroll-responsive" data-order-col="2" data-order-type="desc">
                            <thead>
                            <tr>
                                <th width="50%"><?php echo _l('item_description'); ?></th>
                                <th><?php echo _l('item_long_description'); ?></th>
                                <th><?php echo _l('item_rate'); ?></th>
                                <th><?php echo _l('item_tax1'); ?></th>
                                <th><?php echo _l('item_tax2'); ?></th>
                                <th><?php echo _l('item_unit'); ?></th>
                                <th><?php echo _l('item_groupname'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($items as $temdetails){ ?>
                                <tr>
                                    <td><?php echo $temdetails['description']; ?></td>
                                    <td><?php echo $temdetails['long_description']; ?></td>
                                    <td><?php echo $temdetails['rate']; ?></td>
                                    <td><?php echo $temdetails['taxrate']; ?></td>
                                    <td><?php echo $temdetails['taxrate_2']; ?></td>
                                    <td><?php echo $temdetails['unit']; ?></td>
                                    <td><?php echo $temdetails['group_name']; ?></td>
                                    <?php foreach ($custom_fields as $field) { ?>
                                        <td><?php echo get_custom_field_value($temdetails['itemid'],$field['itemid'],'items'); ?></td>
                                    <?php } ?>
                                    <td>
                                        <a href="/suppliers/item/<?php echo $temdetails['itemid'] ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="/suppliers/itemdelete/<?php echo $temdetails['itemid'] ?>" class="btn btn-danger _delete btn-icon"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
init_roles_permissions();
        _validate_form($('.staff-form'), {
            businessname: 'required',
            password: {
                required: {
                    depends: function(element) {
                        return ($('input[name="isedit"]').length == 0) ? true : false
                    }
                }
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + "admin/misc/supplier_email_exists",
                    type: 'post',
                    data: {
                        email: function() {
                            return $('input[name="email"]').val();
                        },
                        memberid: function() {
                            return $('input[name="memberid"]').val();
                        }
                    }
                }
            }
        });
    });

</script>
</body>
</html>
