<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create galleryimage</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/creategalleryimagesubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Gallery Category">Gallery Category</label>
<input type="text" id="Gallery Category" name="gallerycategory" value='<?php echo set_value('gallerycategory');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewgalleryimage"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
