<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open_multipart(admin_url('Venues/add_venues/'.$venuedetails->venue_id),array('id'=>'add_venues')); ?>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php  echo $title;?></h4>
                        <hr class="hr-panel-heading" />
                        <div class="form-group" app-field-wrapper="name">
                            <label for="company" class="control-label"> <small class="req text-danger">* </small>Name</label>
                            <input type="text" id="name" name="name" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->name) !== ''){ echo $venuedetails->name;}?>">
                        </div>
                        <div class="form-group" app-field-wrapper="address">
                            <label for="address" class="control-label">Address1</label>
                            <textarea id="addressOne" name="addressOne" class="form-control" rows="4"><?php if(isset($venuedetails->address1) !== ''){  echo $venuedetails->address1; }?></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="addresstwo">
                            <label for="address" class="control-label">Address2</label>
                            <textarea id="addressTwo" name="addressTwo" class="form-control" rows="4"><?php if(isset($venuedetails->address2) !== ''){ echo $venuedetails->address2; }?></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="details">
                            <label for="address" class="control-label">Details</label>
                            <textarea id="details" name="details" class="form-control" rows="4"><?php if(isset($venuedetails->details) !== ''){  echo $venuedetails->details; }?></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="phone">
                            <label for="phone" class="control-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->phone) !== ''){  echo $venuedetails->phone; }?>">
                        </div>
                        <div class="form-group" app-field-wrapper="email">
                            <label for="email" class="control-label"> <small class="req text-danger">* </small>Email</label>
                            <input type="text" id="email" name="email" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->email) !== ''){ echo $venuedetails->email; } ?>">
                        </div>
                        <div class="form-group" app-field-wrapper="amenities">
                            <label for="amenities" class="control-label">Amenities</label>
                            <textarea id="amenities" name="amenities" class="form-control" rows="4"><?php if(isset($venuedetails->amenities) !== ''){ echo $venuedetails->amenities; } ?></textarea>
                        </div>

                        <div class="form-group" app-field-wrapper="wheelchair">
                            <label for="amenities" class="control-label">Wheel Chair Access : </label>
                            <div class="checkbox checkbox-inline">
                                <input type="radio" value="1" id="checkbox1" name="wheelchair" <?php if(isset($venuedetails->wheelchairaccess) !== ''){ echo ($venuedetails->wheelchairaccess== 1) ?  "checked" : "" ;  } ?>>
                                <label for="checkbox1">
                                    Yes
                                </label>
                            </div>
                            <div class="checkbox checkbox-inline">
                                <input type="radio" value="0" id="checkbox2"  name="wheelchair" <?php if(isset($venuedetails->wheelchairaccess) !== ''){  echo ($venuedetails->wheelchairaccess== 0) ?  "checked" : "" ; } ?>>
                                <label for="checkbox2">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="form-group" app-field-wrapper="carramp">
                            <label for="amenities" class="control-label">Car Ramp : </label>
                            <div class="checkbox checkbox-inline">
                                <input type="radio" value="1" id="checkbox3" name="carramp" <?php if(isset($venuedetails->carramp) !== ''){ echo ($venuedetails->carramp== 1) ?  "checked" : "" ; } ?>>
                                <label for="checkbox3">
                                    Yes
                                </label>
                            </div>
                            <div class="checkbox checkbox-inline">
                                <input type="radio" value="0" id="checkbox4"  name="carramp" <?php if(isset($venuedetails->carramp) !== ''){  echo ($venuedetails->carramp== 0) ?  "checked" : "" ;  }?>>
                                <label for="checkbox4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="btn-bottom-toolbar text-right">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">Opening Hours</h4>
                        <hr class="hr-panel-heading" />
                        <div id="expense_currency">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="monday">
                                    <label for="phone" class="control-label">Monday</label>
                                    <input type="text" id="monday" name="monday" class="form-control timepicker" value="<?php if(isset($venuedetails->monday) !== ''){ echo $venuedetails->monday; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="tuesday">
                                    <label for="phone" class="control-label">Tuesday</label>
                                    <input type="text" id="tuesday" name="tuesday" class="form-control timepicker" value="<?php if(isset($venuedetails->tuesday) !== ''){  echo $venuedetails->tuesday; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="wednesday">
                                    <label for="phone" class="control-label">Wednesday</label>
                                    <input type="text" id="wednesday" name="wednesday" class="form-control timepicker"  value="<?php if(isset($venuedetails->wednesday) !== ''){ echo $venuedetails->wednesday; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="thursday">
                                    <label for="phone" class="control-label">Thursday</label>
                                    <input type="text" id="thursday" name="thursday" class="form-control timepicker" value="<?php if(isset($venuedetails->thursday) !== ''){ echo $venuedetails->thursday;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="friday">
                                    <label for="phone" class="control-label">Friday</label>
                                    <input type="text" id="friday" name="friday" class="form-control timepicker" value="<?php if(isset($venuedetails->friday) !== ''){ echo $venuedetails->friday;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="saturday">
                                    <label for="phone" class="control-label">Saturday</label>
                                    <input type="text" id="saturday" name="saturday" class="form-control timepicker" value="<?php if(isset($venuedetails->saturday) !== ''){  echo $venuedetails->saturday; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="sunday">
                                    <label for="phone" class="control-label">Sunday</label>
                                    <input type="text" id="sunday" name="sunday" class="form-control timepicker" value="<?php if(isset($venuedetails->sunday) !== ''){  echo $venuedetails->sunday; } ?>">
                                </div>
                            </div>

                        </div>
                        <div class="clearfix mtop15"></div>
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">Image Gallery</h4>
                        <hr class="hr-panel-heading" />
                        <div id="expense_currency">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="attachment" class="control-label">Featured Image</label>
                                    <div class="input-group">
                                        <input type="file"   class="form-control" name="image" >
                                        <?php
                                        if($venuedetails->featured_image !=''){
                                            ?>

                                            <br>&nbsp<br>&nbsp<img src="<?php echo base_url()?>uploads/venues/<?php echo $venuedetails->featured_image ?>"  width="42" height="42">
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="attachment" class="control-label"> Image Gallery</label>
                                    <div class="input-group">
                                        <input type="file"  class="form-control" name="userfile[]" multiple="" >
                                        <br>&nbsp<br>&nbsp
                                        <?php

                                        foreach($gallery as $galleryimages) {
                                            ?>
                                            <img src="<?php echo base_url()?>uploads/venues/gallery/<?php echo $galleryimages['image'] ?>"  width="42" height="42">&nbsp&nbsp&nbsp <a href="#" onclick="removeimage(<?php echo $galleryimages['id'] ?>);">Remove</a>&nbsp&nbsp&nbsp <br>&nbsp<br>&nbsp
                                        <?php }?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix mtop15"></div>
                        <div class="row">
                        </div>
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
    function removeimage(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>admin/venues/imagedelete",
            data: {"imageid":id},
            dataType : "json",
            success: function(response) {

                if(response='true')
                {
                    alert("Successfully deleted the image");
                }
                else
                {
                    alert("Problem in deleting file");
                }
                location.reload();
            }
        });
    }
    $('.timepicker').datetimepicker({
        datepicker: false,
        format:'h:i A',
        formatTime:	'h:i A',
        step: 30
    });
_validate_form($('#add_venues'),{name:'required',date:'required',email: {required: true,email: true}});


</script>

