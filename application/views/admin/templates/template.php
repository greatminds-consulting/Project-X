<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin">
              <?php echo $title; ?>
            </h4>
            <hr class="hr-panel-heading" />
              <?php echo form_open($this->uri->uri_string()); ?>

              <div class="row">
              <div class="col-md-12">
               <?php
               $type = array(
                   0 => array(
                       'id' => 'proposals',
                       'name' => 'Proposals'
                   )
               );
               echo render_input('name','template_name',$template->name,'text',array('disabled'=>true));
               echo render_input('type','template_type',$template->type,'text',array('disabled'=>true));
               ?>
              <hr />
              <?php
              $editors = array();
              array_push($editors,'message['.$template->templateid.']');
              ?>
              <p class="bold"><?php echo _l('email_template_message'); ?></p>
              <?php echo render_textarea('message['.$template->templateid.']','',$template->message,array('data-url-converter-callback'=>'myCustomURLConverter'),array(),'','tinymce tinymce-manual'); ?>

              <div class="btn-bottom-toolbar text-right">
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
              </div>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<?php init_tail(); ?>
<script>
  $(function(){
    <?php foreach($editors as $id){ ?>
      init_editor('textarea[name="<?php echo $id; ?>"]',{urlconverter_callback:'merge_field_format_url'});
      <?php } ?>
      var merge_fields_col = $('.merge_fields_col');
        // If not fields available
        $.each(merge_fields_col, function() {
          var total_available_fields = $(this).find('p');
          if (total_available_fields.length == 0) {
            $(this).remove();
          }
        });
    // Add merge field to tinymce
    $('.add_merge_field').on('click', function(e) {
     e.preventDefault();
     tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
   });
    _validate_form($('form'), {
      name: 'required',
      fromname: 'required'
    });
  });
</script>
</body>
</html>
