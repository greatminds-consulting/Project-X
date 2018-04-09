<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
           <?php do_action('before_items_page_content'); ?>
           <?php if(has_permission('items','','create')){ ?>
           <div class="_buttons">
            <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#sales_item_modal"><?php echo _l('new_invoice_item'); ?></a>
            <a href="#" class="btn btn-info pull-left mleft5" data-toggle="modal" data-target="#groups"><?php echo _l('item_groups'); ?></a>
            <a href="#" class="btn btn-info pull-left mleft5" data-toggle="modal" data-target="#packages"><?php echo _l('item_packages'); ?></a>
          </div>
          <div class="clearfix"></div>
          <hr class="hr-panel-heading" />
          <?php } ?>
          <?php
          $table_data = array(
            _l('invoice_items_list_description'),
            _l('invoice_item_long_description'),
            _l('invoice_items_list_rate'),
            _l('tax_1'),
            _l('tax_2'),
            _l('unit'),
            _l('item_group_name'),
            _l('item_package_name'));
            $cf = get_custom_fields('items');
            foreach($cf as $custom_field) {
                array_push($table_data,$custom_field['name']);
            }
            array_push($table_data,_l('options'));
            render_datatable($table_data,'invoice-items'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/invoice_items/item'); ?>
<div class="modal fade" id="groups" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php echo _l('item_groups'); ?>
        </h4>
      </div>
      <div class="modal-body">
        <?php if(has_permission('items','','create')){ ?>
        <div class="input-group">
          <input type="text" name="item_group_name" id="item_group_name" class="form-control" placeholder="<?php echo _l('item_group_name'); ?>">
          <span class="input-group-btn">
            <button class="btn btn-info p9" type="button" id="new-item-group-insert"><?php echo _l('new_item_group'); ?></button>
          </span>
        </div>
        <hr />
        <?php } ?>
        <div class="row">
         <div class="container-fluid">
          <table class="table dt-table table-items-groups" data-order-col="0" data-order-type="asc">
            <thead>
              <tr>
                <th><?php echo _l('item_group_name'); ?></th>
                <th><?php echo _l('options'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($items_groups as $group){ ?>
              <tr data-group-row-id="<?php echo $group['id']; ?>">
                <td data-order="<?php echo $group['name']; ?>">
                  <span class="group_name_plain_text"><?php echo $group['name']; ?></span>
                  <div class="group_edit hide">
                   <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-info p7 update-item-group" type="button"><?php echo _l('submit'); ?></button>
                    </span>
                  </div>
                </div>
              </td>
              <td align="right">
                <?php if(has_permission('items','','edit')){ ?><button type="button" class="btn btn-default btn-icon edit-item-group"><i class="fa fa-pencil-square-o"></i></button><?php } ?>
                <?php if(has_permission('items','','delete')){ ?><a href="<?php echo admin_url('invoice_items/delete_group/'.$group['id']); ?>" class="btn btn-danger btn-icon delete-item-group _delete"><i class="fa fa-remove"></i></a><?php } ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="packages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo _l('item_packages'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php if(has_permission('items','','create')){ ?>
                    <div class="input-group">
                        <input type="text" name="item_package_name" id="item_package_name" class="form-control" placeholder="<?php echo _l('item_package_name'); ?>">
          <span class="input-group-btn">
            <button class="btn btn-info p9" type="button" id="new-item-package-insert"><?php echo _l('new_item_package'); ?></button>
          </span>
                    </div>
                    <hr />
                <?php } ?>
                <div class="row">
                    <div class="container-fluid">
                        <table class="table dt-table table-items-groups" data-order-col="0" data-order-type="asc">
                            <thead>
                            <tr>
                                <th><?php echo _l('item_package_name'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($items_packages as $package){ ?>
                                <tr data-package-row-id="<?php echo $package['id']; ?>">
                                    <td data-order="<?php echo $package['name']; ?>">
                                        <span class="package_name_plain_text"><?php echo $package['name']; ?></span>
                                        <div class="package_edit hide">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-info p7 update-item-package" type="button"><?php echo _l('submit'); ?></button>
                    </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td align="right">
                                        <?php if(has_permission('items','','edit')){ ?><button type="button" class="btn btn-default btn-icon edit-item-package"><i class="fa fa-pencil-square-o"></i></button><?php } ?>
                                        <?php if(has_permission('items','','delete')){ ?><a href="<?php echo admin_url('invoice_items/delete_package/'.$package['id']); ?>" class="btn btn-danger btn-icon delete-item-group _delete"><i class="fa fa-remove"></i></a><?php } ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
  $(function(){
    var not_sortable_items;
    not_sortable_items = [($('.table-invoice-items').find('th').length - 1)];
    initDataTable('.table-invoice-items', admin_url+'invoice_items/table', not_sortable_items, not_sortable_items,'undefined',[0,'ASC']);
    if(get_url_param('groups_modal')){
       // Set time out user to see the message
       setTimeout(function(){
         $('#groups').modal('show');
       },1000);
    }

      if(get_url_param('packages_modal')){
          // Set time out user to see the message
          setTimeout(function(){
              $('#packages').modal('show');
          },1000);
      }

    $('#new-item-group-insert').on('click',function(){
      var group_name = $('#item_group_name').val();
      if(group_name != ''){
          $.post(admin_url+'invoice_items/add_group',{name:group_name}).done(function(){
           window.location.href = admin_url+'invoice_items?groups_modal=true';
         });
      }
    });

    $('#new-item-package-insert').on('click',function(){
      var group_name = $('#item_package_name').val();
      if(group_name != ''){
          $.post(admin_url+'invoice_items/add_package',{name:group_name}).done(function(){
              window.location.href = admin_url+'invoice_items?packages_modal=true';
          });
      }
    });

    $('body').on('click','.edit-item-group',function(){
      var tr = $(this).parents('tr'),
      group_id = tr.attr('data-group-row-id');
      tr.find('.group_name_plain_text').toggleClass('hide');
      tr.find('.group_edit').toggleClass('hide');
      tr.find('.group_edit input').val(tr.find('.group_name_plain_text').text());
    });

    $('body').on('click','.edit-item-package',function(){
      var tr = $(this).parents('tr'),
          group_id = tr.attr('data-package-row-id');
      tr.find('.package_name_plain_text').toggleClass('hide');
      tr.find('.package_edit').toggleClass('hide');
      tr.find('.package_edit input').val(tr.find('.package_name_plain_text').text());
    });

    $('body').on('click','.update-item-group',function(){
      var tr = $(this).parents('tr');
      var group_id = tr.attr('data-group-row-id');
      name = tr.find('.group_edit input').val();
      if(name != ''){
        $.post(admin_url+'invoice_items/update_group/'+group_id,{name:name}).done(function(){
         window.location.href = admin_url+'invoice_items';
       });
      }
    });

    $('body').on('click','.update-item-package',function(){
      var tr = $(this).parents('tr');
      var package_id = tr.attr('data-package-row-id');
      name = tr.find('.package_edit input').val();
      if(name != ''){
          $.post(admin_url+'invoice_items/update_package/'+package_id,{name:name}).done(function(){
              window.location.href = admin_url+'invoice_items';
          });
      }
    });
  });
</script>
</body>
</html>
