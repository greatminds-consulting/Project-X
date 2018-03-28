<div class="modal fade" id="venue-layout-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('venues/layout'),array('id'=>'venue-layout-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('name','layout_name'); ?>
                        <?php echo render_input('layout_id','','','hidden'); ?>
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
     _validate_form($('#venue-layout-form'),{name:'required'},manage_layout);
        $('#venue-layout-modal').on('hidden.bs.modal', function(event) {
            $('#venue-layout-modal input[name="name"]').val('');
        });
  });

  function manage_layout(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if(response.success == true){
                $('#venue-layout-modal').modal('hide');
                alert_float('success',response.message);
                if (response.type == 'add') {
                    if($('table').hasClass('layout')) {
                        $('.table.layout tbody').append('<tr><td><a href="">'+response.name+'</a><a href="" class="pull-right"><small>Disable</small></a></td></tr>');
                    }
                } else {
                    if($('table').hasClass('layout')) {
                        $('.table.layout tbody tr.layout_'+response.id).html('<td><a href="">'+response.name+'</a><a href="" class="pull-right"><small>Disable</small></a></td>');
                    }
                }

            }
        });
        return false;
    }

    function new_layout(){
        $('.add-title').html('Add Layout');
        $('#venue-layout-modal').modal('show');
    }

    function edit_layout($id,$name) {
          $('#venue-layout-modal').modal('show');
          $('#venue-layout-modal input[name="name"]').val($name);
          $('#venue-layout-modal input[name="layout_id"]').val($id);
          $('.add-title').html('Edit Layout');
    }
</script>

