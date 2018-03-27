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
                            <input type="text" id="addressOne" name="addressOne" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->address1) !== ''){ echo $venuedetails->address1;}?>">
                        </div>
                        <div class="form-group" app-field-wrapper="addresstwo">
                            <label for="address" class="control-label">Address2</label>
                            <input type="text" id="addressTwo" name="addressTwo" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->address2) !== ''){ echo $venuedetails->address2;}?>">
                        </div>
                        <div class="form-group" app-field-wrapper="phone">
                            <label for="phone" class="control-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->phone) !== ''){  echo $venuedetails->phone; }?>">
                        </div>
                        <div class="form-group" app-field-wrapper="email">
                            <label for="email" class="control-label"> <small class="req text-danger">* </small>Email</label>
                            <input type="text" id="email" name="email" class="form-control" autofocus="1" value="<?php if(isset($venuedetails->email) !== ''){ echo $venuedetails->email; } ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" app-field-wrapper="suburb">
                                    <label for="phone" class="control-label">Suburb</label>
                                    <input type="text" id="suburb" name="suburb" class="form-control" value="<?php if(isset($venuedetails->suburb) !== ''){ echo $venuedetails->suburb; } ?>">
                                </div>
                            </div><div class="col-md-4">
                                <div class="form-group" app-field-wrapper="state">
                                    <label for="phone" class="control-label">State</label>
                                    <input type="text" id="state" name="state" class="form-control" value="<?php if(isset($venuedetails->state) !== ''){ echo $venuedetails->state; } ?>">
                                </div>
                            </div><div class="col-md-4">
                                <div class="form-group" app-field-wrapper="postcode">
                                    <label for="phone" class="control-label">Postcode</label>
                                    <input type="text" id="postcode" name="postcode" class="form-control" value="<?php if(isset($venuedetails->postcode) !== ''){ echo $venuedetails->postcode; } ?>">
                                </div>
                            </div>
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
                                    <label for="phone" class="control-label">Monday From</label>
                                    <input type="text" id="monday_from" name="monday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->monday_from) !== ''){ echo $venuedetails->monday_from; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="monday">
                                    <label for="phone" class="control-label">Monday To</label>
                                    <input type="text" id="monday_to" name="monday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->monday_to) !== ''){ echo $venuedetails->monday_to; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="monday">
                                    <label for="phone" class="control-label">Tuesday From</label>
                                    <input type="text" id="tuesday_from" name="tuesday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->tuesday_from) !== ''){ echo $venuedetails->tuesday_from; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="tuesday">
                                    <label for="phone" class="control-label">Tuesday To</label>
                                    <input type="text" id="tuesday_to" name="tuesday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->tuesday_to) !== ''){ echo $venuedetails->tuesday_to; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="wednesday">
                                    <label for="phone" class="control-label">Wednesday From</label>
                                    <input type="text" id="wednesday_from" name="wednesday_from" class="form-control timepicker"  value="<?php if(isset($venuedetails->wednesday_from) !== ''){ echo $venuedetails->wednesday_from; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="wednesday">
                                    <label for="phone" class="control-label">Wednesday To</label>
                                    <input type="text" id="wednesday_to" name="wednesday_to" class="form-control timepicker"  value="<?php if(isset($venuedetails->wednesday_to) !== ''){ echo $venuedetails->wednesday_to; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="thursday">
                                    <label for="phone" class="control-label">Thursday From</label>
                                    <input type="text" id="thursday_from" name="thursday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->thursday_from) !== ''){ echo $venuedetails->thursday_from;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="thursday">
                                    <label for="phone" class="control-label">Thursday To</label>
                                    <input type="text" id="thursday_to" name="thursday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->thursday_to) !== ''){ echo $venuedetails->thursday_to;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="friday">
                                    <label for="phone" class="control-label">Friday From</label>
                                    <input type="text" id="friday_from" name="friday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->friday_from) !== ''){ echo $venuedetails->friday_from;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="friday">
                                    <label for="phone" class="control-label">Friday To</label>
                                    <input type="text" id="friday_to" name="friday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->friday_to) !== ''){ echo $venuedetails->friday_to;} ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="saturday">
                                    <label for="phone" class="control-label">Saturday From</label>
                                    <input type="text" id="saturday_from" name="saturday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->saturday_from) !== ''){  echo $venuedetails->saturday_from; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="saturday">
                                    <label for="phone" class="control-label">Saturday To</label>
                                    <input type="text" id="saturday_to" name="saturday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->saturday_to) !== ''){  echo $venuedetails->saturday_to; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="sunday">
                                    <label for="phone" class="control-label">Sunday From</label>
                                    <input type="text" id="sunday" name="sunday_from" class="form-control timepicker" value="<?php if(isset($venuedetails->sunday_from) !== ''){  echo $venuedetails->sunday_from; } ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" app-field-wrapper="sunday">
                                    <label for="phone" class="control-label">Sunday To</label>
                                    <input type="text" id="sunday_to" name="sunday_to" class="form-control timepicker" value="<?php if(isset($venuedetails->sunday_to) !== ''){  echo $venuedetails->sunday_to; } ?>">
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
    var time_picker_options = {
        datepicker: false,
        format:	'g:i a',
        formatTime:	'g:i a',
        validateOnBlur: false
    }
    var time_format = '<?php echo get_option('time_format'); ?>';
    if(time_format == 24){
        time_picker_options.format = 'H:i';
        time_picker_options.formatTime = 'H:i';
    } else {
        time_picker_options.format = ' g:i A';
        time_picker_options.formatTime = 'g:i A';
    }
    $('.timepicker').datetimepicker(time_picker_options);
_validate_form($('#add_venues'),{name:'required',date:'required',email: {required: true,email: true}});


</script>

