<div class="modal fade" id="venue-amenities-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('venues/amenities'),array('id'=>'venue-amenities-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_amenities'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('name','amenity_name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  window.addEventListener('load',function(){
     _validate_form($('#venue-amenities-form'),{name:'required'},manage_amenities);
        $('#venue-amenities-modal').on('hidden.bs.modal', function(event) {
            $('#venue-amenities-modal input[name="name"]').val('');
        });
  });
   function manage_amenities(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if(response.success == true){
                $('#venue-amenities-modal').modal('hide');
                alert_float('success',response.message);
                if($('table').hasClass('amenities')) {
                 $('.table.amenities tbody').append('<tr><td><a href="">'+response.name+'</a><a href="" class="pull-right"><small>Disable</small></a></td></tr>');
                }
            }
        });
        return false;
    }

    function new_amenities(){
        $('#venue-amenities-modal').modal('show');
    }

    function edit_category(invoker,id){
        var name = $(invoker).data('name');
        var description = $(invoker).data('description');
        $('#additional').append(hidden_input('id',id));
        $('#expense-category-modal input[name="name"]').val(name);
        $('#expense-category-modal textarea').val(description);
        $('#expense-category-modal').modal('show');
        $('.add-title').addClass('hide');
    }
</script>
