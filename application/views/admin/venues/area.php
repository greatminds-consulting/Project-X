<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open_multipart(admin_url('venues/add_areas/'.$details[0]['id']),array('id'=>'add_areas','class' =>'add_areas')); ?>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php  echo $title;?></h4>
                        <hr class="hr-panel-heading" />
                        <div class="form-group" app-field-wrapper="name">
                            <label for="company" class="control-label"> <small class="req text-danger">* </small>Name</label>
                            <input type="text" id="name" name="name" class="form-control" autofocus="1" value="<?php echo $details[0]['name'];?>">
                        </div>
                        <div class="form-group" app-field-wrapper="name"><button type="button" class="btn btn-info" onclick="add_layout()">Add New Layout</button></div>
                        <div class="layout-div">
                        <?php if ($area_layouts) {
                            foreach ($area_layouts as $area_layout) { ?>
                                    <div class="layout-div-section">
                                        <div class="form-group" app-field-wrapper="name">
                                            <label for="company" class="control-label"><small class="req text-danger">* </small>Area Layout</label>
                                            <label for="company" class="control-label pull-right delete-block"><a href="#"  class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a></label>
                                            <select class="form-control area-layout-select layout-id-<?php echo $area_layout['layout_id']?>" name="layout[]" required>
                                                <option value="">Select Layout</option>
                                                <?php
                                                foreach($layouts as $layout) {?>
                                                    <option value="<?php echo $layout['id'];?>" <?php if($area_layout['layout_id'] == $layout['id']){echo "selected";} ?>><?php echo $layout['name'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="layout_minimum" class="control-label">Layout Minimum</label>
                                            <input type="text"  required name="layout_minimum[]" class="form-control"  value="<?php echo $area_layout['layout_min'];?>">
                                        </div>
                                        <div class="form-group" app-field-wrapper="name">
                                            <label for="layout_maximum" class="control-label">Layout Maximum</label>
                                            <input type="text"  required name="layout_maximum[]" class="form-control" value="<?php echo $area_layout['layout_max'];?>">
                                        </div>
                                        <div class="clearfix"><hr class="hr-panel-heading" /></div>
                                    </div>

                           <?php  }
                        } else { ?>
                                <div class="layout-div-section">
                                    <div class="form-group" app-field-wrapper="name">
                                        <label for="company" class="control-label"><small class="req text-danger">* </small>Area Layout</label>
                                        <select class="form-control area-layout-select" name="layout[]" required>
                                            <option value="">Select Layout</option>
                                            <?php
                                            foreach($layouts as $layout) {?>
                                                <option value="<?php echo $layout['id'];?>" <?php if($details[0]['layout_id'] == $layout['id']){echo "selected";} ?>><?php echo $layout['name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="layout_minimum" class="control-label">Layout Minimum</label>
                                        <input type="text"  required name="layout_minimum[]" class="form-control"  value="<?php echo $details[0]['layout_minimum'];?>">
                                    </div>
                                    <div class="form-group" app-field-wrapper="name">
                                        <label for="layout_maximum" class="control-label">Layout Maximum</label>
                                        <input type="text"  required name="layout_maximum[]" class="form-control" value="<?php echo $details[0]['layout_maximum'];?>">
                                    </div>
                                    <div class="clearfix"><hr class="hr-panel-heading" /></div>
                                </div>

                        <?php }?>
                        </div>
                        <?php echo render_input('venue_area_id','',$details[0]['id'],'hidden'); ?>
                        <div class="form-group" app-field-wrapper="amenity">
                            <label for="amenities" class="control-label">Area Amenities </label>
                            <?php
                            foreach ($amenities as $amenity) {?>
                            <div class="checkbox">
                                <input type="checkbox" <?php if (isset($area_amenities[$amenity['id']])){echo 'checked';}?> value="<?php echo $amenity['id']?>"  name="amenity[]">
                                <label for="checkbox1">
                                    <?php echo $amenity['name']?>
                                </label>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="btn-bottom-toolbar text-right">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/html" class="area-layout">
        <div class="layout-div-section">
            <div class="form-group" app-field-wrapper="name">
                <label for="company" class="control-label"><small class="req text-danger">* </small>Area Layout</label>
                <label for="company" class="control-label pull-right delete-block" ><a href="#"  class="btn btn-danger  btn-icon"><i class="fa fa-remove"></i></a></label>
                <select class="form-control area-layout-select " name="layout[]" required>
                    <option value="">Select Layout</option>
                                            <?php
                                            foreach($layouts as $layout) {?>
                                                <option value="<?php echo $layout['id'];?>" <?php if($details[0]['layout_id'] == $layout['id']){echo "selected";} ?>><?php echo $layout['name'];?></option>
                                            <?php }?>
                                        </select>
                <input type="hidden" class="selected-layout" value="">
            </div>
            <div class="form-group">
                <label for="layout_minimum" class="control-label">Layout Minimum</label>
                <input type="text"  required name="layout_minimum[]" class="form-control"  value="">
            </div>
            <div class="form-group" app-field-wrapper="name">
                <label for="layout_maximum" class="control-label">Layout Maximum</label>
                <input type="text"  required name="layout_maximum[]" class="form-control" value="">
            </div>
            <div class="clearfix"><hr class="hr-panel-heading" /></div>
        </div>
</script>
<script>
_validate_form($('#add_areas'),{name:'required','layout':'required','layout_minimum': {required: true,digits: true},layout_maximum: {required: true,digits: true}});

    function add_layout() {
        $('.layout-div').append($('.area-layout').html());
        $('.delete-block').show();
    }
    $(document).on('change', '.area-layout-select', function(){
        if ($('.layout-id-'+$(this).val()).length > 0) {
            $('.layout-id-'+$(this).val()).focus();
            $(this).val($(this).next('input').val());
        } else {
        if ($(this).next('input')) {
            $(this).removeClass('layout-id-'+$(this).next('input').val()).addClass('layout-id-'+$(this).val());
            $(this).next('input').val($(this).val());
        }
        }
    });
    $(document).on('click', '.btn-danger i.fa-remove', function(){
        $(this).closest('.layout-div-section').remove();
        if ($('.area-layout-select').length < 2) {
            $('.delete-block').hide();
        }
        return false;
    });

</script>

