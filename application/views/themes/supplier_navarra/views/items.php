<div class="panel_s">
    <div class="panel-body">
        <div class="_buttons">
            <a href="/suppliers/item" class="btn btn-info pull-left"><?php echo _l('new_invoice_item'); ?></a>
        </div>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <div class="row mbot15">
            <div class="col-md-12">
                <h3 class="text-success no-mtop"><?php echo _l('items_summary'); ?></h3>
            </div>
        </div>
        <hr />
        <table class="table dt-table" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th><?php echo _l('reminder_description'); ?></th>
                <th><?php echo _l('invoice_item_long_description'); ?></th>
                <th><?php echo _l('estimate_table_rate_heading'); ?></th>
                <th><?php echo _l('tax_1'); ?></th>
                <th><?php echo _l('tax_2'); ?></th>
                <th><?php echo _l('unit'); ?></th>
                <th><?php echo _l('kb_group_add_edit_name'); ?></th>
                <?php
                $custom_fields = get_custom_fields('items',array('show_on_client_portal'=>1));
                foreach($custom_fields as $field){ ?>
                    <th><?php echo $field['name']; ?></th>
                <?php } ?>
                <th><?php echo _l('options'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?php echo $item['description']; ?></td>
                    <td><?php echo $item['long_description']; ?></td>
                    <td><?php echo $item['rate']; ?></td>
                    <td><?php echo $item['taxrate']; ?></td>
                    <td><?php echo $item['taxrate_2']; ?></td>
                    <td><?php echo $item['unit']; ?></td>
                    <td><?php echo $item['group_name']; ?></td>
                    <?php foreach ($custom_fields as $field) { ?>
                        <td><?php echo get_custom_field_value($item['itemid'],$field['itemid'],'items'); ?></td>
                    <?php } ?>
                    <td>
                        <a href="/suppliers/item/<?php echo $item['itemid'] ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                        <a href="/suppliers/itemdelete/<?php echo $item['itemid'] ?>" class="btn btn-danger _delete btn-icon"><i class="fa fa-remove"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php


