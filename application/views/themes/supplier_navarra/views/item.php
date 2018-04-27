<?php echo form_open_multipart('suppliers/item'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="panel_s">
            <div class="panel-heading text-uppercase">
                <?php echo $heading; ?>
            </div>
            <div class="panel-body">
                <div class="row">
                        <div class="col-md-12">
                        <div class="alert alert-warning affect-warning hide">
                            <?php echo _l('changing_items_affect_warning'); ?>
                        </div>
                            <div class="form-group">
                                <label for="description"><?php echo _l('invoice_item_add_edit_description'); ?></label>
                                <input type="text" class="form-control" name="description" id="description" value="<?php echo $item_details->description ;?>">
                                <?php echo form_error('description'); ?>
                            </div>
                            <div class="form-group">
                                <label for="stockinhand"><?php echo _l('stock_in_hand'); ?></label>
                                <input type="text" class="form-control" name="stockinhand" id="stockinhand" value="<?php echo $item_details->stockinhand ;?>">
                                <input type="hidden" name="itemid" id="itemid" value="<?php echo $item_details->itemid ;?>">
                                <?php echo form_error('stockinhand'); ?>
                            </div>
                            <div class="form-group">
                                <label for="long_description"><?php echo _l('invoice_item_long_description'); ?></label>
                                <input type="text" class="form-control" name="long_description" id="long_description" value="<?php echo $item_details->long_description ;?>">
                            </div>
                            <div class="form-group">
                                <label for="item_images" class="control-label">Item Image</label>
                                <input type="file" name="item_images" class="form-control" id="item_images">
                                <?php if($item_details->item_image!=''){?>
                                <img src="<?php echo base_url()?>uploads/items/<?php echo $item_details->itemid ?>/thumb_<?php echo $item_details->item_image ?>"  width="42" height="42">
                            <?php }
                            ?>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="rate" class="control-label">
                                            <?php echo _l('invoice_item_add_edit_rate_currency',$base_currency->name . ' <small>('._l('base_currency_string').')</small>'); ?></label>
                                        <input type="number" id="rate" name="rate" class="form-control" value="<?php echo $item_details->rate ;?>" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="margin" class="control-label">Margin</label>
                                        <input type="text" class="form-control" name="margin" id="itemmargin" value="<?php if($item_details==''){ echo $suppliermargin->margin;} else {echo $item_details->margin;}?>" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total" class="control-label">Total Amount</label>
                                        <div name="total" class="control-label" id="total"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        foreach($currencies as $currency){
                            if($currency['isdefault'] == 0 && total_rows('tblclients',array('default_currency'=>$currency['id'])) > 0){ ?>
                                <div class="form-group">
                                    <label for="rate_currency_<?php echo $currency['id']; ?>" class="control-label">
                                        <?php echo _l('invoice_item_add_edit_rate_currency',$currency['name']); ?></label>
                                    <input type="number" id="rate_currency_<?php echo $currency['id']; ?>" name="rate_currency_<?php echo $currency['id']; ?>" class="form-control" value="">
                                </div>
                            <?php   }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="tax"><?php echo _l('tax_1'); ?></label>
                                    <select class="selectpicker display-block" data-width="100%" name="tax" data-none-selected-text="<?php echo _l('no_tax'); ?>">
                                        <option value=""></option>
                                        <?php foreach($taxes as $tax){ ?>
                                            <option value="<?php echo $tax['id']; ?>" data-subtext="<?php echo $tax['name']; ?>"><?php echo $tax['taxrate']; ?>%</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="tax2"><?php echo _l('tax_2'); ?></label>
                                    <select class="selectpicker display-block" data-width="100%" name="tax2" data-none-selected-text="<?php echo _l('no_tax'); ?>">
                                        <option value=""></option>
                                        <?php foreach($taxes as $tax){ ?>
                                            <option value="<?php echo $tax['id']; ?>" data-subtext="<?php echo $tax['name']; ?>"><?php echo $tax['taxrate']; ?>%</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix mbot15"></div>
                        <?php echo render_input('unit','unit',$item_details->unit); ?>
                        <div id="custom_fields_items">
                            <?php echo render_custom_fields('items'); ?>
                        </div>
                            <?php  $packages = array();
                            foreach ($item_packages as $item_package) {
                                $packages[] = $item_package['id'];
                            }?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-center mtop20">
        <button type="submit" class="btn btn-info" data-form="#open-new-ticket-form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $( document ).ready(function() {
        var rate = parseInt($('input[name=rate]').val());
        if (isNaN(rate)) {
            rate=0;
        }
        var margin = parseInt($('#itemmargin').val());
        if (isNaN(margin)) {
            margin=0;
        }
        var total = rate + margin;
        $('#total').html(total);
        $("#rate, #itemmargin").keyup(function() {
            var rate = parseInt($('input[name=rate]').val());
            if (isNaN(rate)) {
                rate=0;
            }
            var margin = parseInt($('#itemmargin').val());
            if (isNaN(margin)) {
                margin=0;
            }
            var total = rate + margin;
            $('#total').html(total);
        });
    });
</script>