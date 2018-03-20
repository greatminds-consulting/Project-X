<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open_multipart(admin_url('Rooms/add_rooms'),array('id'=>'add_rooms')); ?>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo $title; ?></h4>
                        <hr class="hr-panel-heading" />
                        <div class="col-md-6">
                        <div class="form-group" app-field-wrapper="venueName">
                            <label for="company" class="control-label"> <small class="req text-danger">* </small>Venue Name</label>
                            <select class="form-control" name="venueName">
                                <option value="">Select venue</option>
                                <?php
                               foreach($venues as $venueDetails) {?>
                                <option value="<?php echo $venueDetails['id'];?>"><?php echo $venueDetails['name'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group" app-field-wrapper="roomname">
                            <label for="company" class="control-label"> <small class="req text-danger">* </small>Room Name</label>
                            <input type="text" id="roomName" name="roomName" class="form-control" autofocus="1" value="">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group" app-field-wrapper="specifications">
                            <label for="address" class="control-label">Room Specifications</label>
                            <textarea id="specifications" name="specifications" class="form-control" rows="4"></textarea>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="ceilingHeight">
                                <label for="company" class="control-label"> Ceiling Height</label>
                                <input type="text" id="ceilingHeight" name="ceilingHeight" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="foyerArea">
                                <label for="company" class="control-label"> Foyer Area</label>
                                <input type="text" id="foyerArea" name="foyerArea" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="balconyArea">
                                <label for="company" class="control-label"> Balcony Area</label>
                                <input type="text" id="balconyArea" name="balconyArea" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="totalArea">
                                <label for="company" class="control-label"> Total Area</label>
                                <input type="text" id="totalArea" name="totalArea" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="capacity">
                                <label for="company" class="control-label"> Capacity</label>
                                <input type="text" id="capacity" name="capacity" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="theaterMin">
                                <label for="company" class="control-label"> Theater Min</label>
                                <input type="text" id="theaterMin" name="theaterMin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="theaterMax">
                                <label for="company" class="control-label"> Theater Max</label>
                                <input type="text" id="theaterMax" name="theaterMax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="ushapemin">
                                <label for="company" class="control-label"> U-Shape Min</label>
                                <input type="text" id="ushapemin" name="ushapemin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="ushapemax">
                                <label for="company" class="control-label"> U-Shape Max</label>
                                <input type="text" id="ushapemax" name="ushapemax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="carbaretMin">
                                <label for="company" class="control-label">Carbaret Min</label>
                                <input type="text" id="carbaretMin" name="carbaretMin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="carbaretMax">
                                <label for="company" class="control-label">Carberet Max</label>
                                <input type="text" id="carbaretMax" name="carbaretMax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="cocktailmin">
                                <label for="company" class="control-label"> Cocktail Min</label>
                                <input type="text" id="cocktailmin" name="cocktailmin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="cocktailmax">
                                <label for="company" class="control-label">Cocktail Max</label>
                                <input type="text" id="cocktailmax" name="cocktailmax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="dinnermin">
                                <label for="company" class="control-label">Dinner Min</label>
                                <input type="text" id="dinnermin" name="dinnermin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="dinnermax">
                                <label for="company" class="control-label">Dinner Max</label>
                                <input type="text" id="dinnermax" name="dinnermax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="DinnerDancemin">
                                <label for="company" class="control-label"> Dinner+Dance Min</label>
                                <input type="text" id="DinnerDancemin" name="DinnerDancemin" class="form-control" autofocus="1" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" app-field-wrapper="DinnerDancemax">
                                <label for="company" class="control-label">Dinner+Dance Max</label>
                                <input type="text" id="DinnerDancemax" name="DinnerDancemax" class="form-control" autofocus="1" value="">
                            </div>
                        </div>
                        <div class="btn-bottom-toolbar text-right">
                            <button type="submit" class="btn btn-info">Save</button>
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
    _validate_form($('#add_rooms'),{roomName:'required',venueName:'required'});


</script>

