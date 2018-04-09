<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form'));
			if(isset($invoice)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/invoices/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item'); ?>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
	$(function(){
		validate_invoice_form();
	    // Init accountacy currency symbol
	    init_currency_symbol();
	    // Project ajax search
	    init_ajax_project_search_by_customer_id();
	    // Maybe items ajax search
	    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
        $("body").on('change', 'select[name="package_id"]', function () {
            if ($('.invoice-items-table tr').length > 2) {
                var r = confirm("<?php echo _l('package_confirm_action_prompt'); ?>");
                if (r == false) {
                    $(this).selectpicker('val', packageid);
                    return false;
                } else {
                    $.each( $('.invoice-items-table tr'), function( key, value ) {
                        $(value).find('a.btn-danger').click()
                    });
                }
            }
            packageid = $(this).selectpicker('val');
            if (packageid != '' && packageid !== 'newitem') {
                requestGetJSON('invoice_items/get_package_by_id/' + packageid).done(function(response) {
                    if (response) {
                        $.each(response, function(i, obj) {
                            clear_item_preview_values();

                            $('.main textarea[name="description"]').val(obj.description);
                            $('.main textarea[name="long_description"]').val(obj.long_description.replace(/(<|&lt;)br\s*\/*(>|&gt;)/g, " "));

                            _set_item_preview_custom_fields_array(obj.custom_fields);

                            var taxSelectedArray = [];
                            if (obj.taxname && obj.taxrate) {
                                taxSelectedArray.push(obj.taxname + '|' + obj.taxrate);
                            }
                            if (obj.taxname_2 && obj.taxrate_2) {
                                taxSelectedArray.push(obj.taxname_2 + '|' + obj.taxrate_2);
                            }
                            obj.taxname = taxSelectedArray;

                            $(document).trigger({
                                type: "item-added-to-preview",
                                item: obj,
                                item_type: 'item'
                            });
                            add_item_to_table(obj,obj.itemid,undefined)
                        });

                    }

                });
            }
        });
	});
</script>
</body>
</html>
