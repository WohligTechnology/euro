<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create home category</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createhomecategorysubmit");?>' enctype= 'multipart/form-data'>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("product1",$product1,set_value('product1'));?>
<label>Product1</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("product2",$product2,set_value('product2'));?>
<label>Product2</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("product3",$product3,set_value('product3'));?>
<label>Product3</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("product4",$product4,set_value('product4'));?>
<label>Product4</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name');?>'>
</div>
</div>
<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image1</span>
<input type="file" name="image1" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('image1');?>'>
</div>
</div>
</div>
<div class="row">
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image Hover</span>
<input type="file" name="imagehover" multiple>
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('imagehover');?>'>
</div>
</div>
</div>
<!--
<div class="row">
<div class="input-field col s6">
<label for="Image Hover">Image Hover</label>
<input type="text" id="Image Hover" name="imagehover" value='<?php echo set_value('imagehover');?>'>
</div>
</div>
-->
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewhomecategory"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
