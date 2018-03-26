<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open_multipart(admin_url('Venues/add_areas/'.$details->id),array('id'=>'add_areas')); ?>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php  echo $title;?></h4>
                        <hr class="hr-panel-heading" />
                        <div class="form-group" app-field-wrapper="name">
                            <label for="company" class="control-label"> <small class="req text-danger">* </small>Name</label>
                            <input type="text" id="name" name="name" class="form-control" autofocus="1" value="<?php if(isset($details->name) !== ''){ echo $details->name;}?>">
                        </div>
                        <?php  echo render_select('layout',$layouts,array('id','name'),'area_layout'); ?>
                        <div class="form-group" app-field-wrapper="name">
                            <label for="layout_minimum" class="control-label">Layout Minimum</label>
                            <input type="text" id="layout_minimum" name="layout_minimum" class="form-control" autofocus="1" value="<?php if(isset($details->name) !== ''){ echo $details->name;}?>">
                        </div>
                        <div class="form-group" app-field-wrapper="name">
                            <label for="layout_maximum" class="control-label">Layout Maximum</label>
                            <input type="text" id="layout_maximum" name="layout_maximum" class="form-control" autofocus="1" value="<?php if(isset($details->name) !== ''){ echo $details->name;}?>">
                        </div>

                        <div class="form-group" app-field-wrapper="wheelchair">
                            <label for="amenities" class="control-label">Area Amenities : </label>
                            <?php foreach ($amenities as $amenity) {?>
                            <div class="checkbox">
                                <input type="checkbox" value="<?php echo $amenity['id']?>"  name="amenity[]">
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

<script>
_validate_form($('#add_areas'),{name:'required',layout:'required'});
</script>

