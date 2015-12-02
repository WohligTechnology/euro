<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit home category</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/edithomecategorysubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class=" row">
<div class=" input-field col s12 m6">
<?php echo form_dropdown("product1",$product1,set_value('product1',$before->product1));?>
<label for="Product1">Product1</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s12 m6">
<?php echo form_dropdown("product2",$product2,set_value('product2',$before->product2));?>
<label for="Product2">Product2</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s12 m6">
<?php echo form_dropdown("product3",$product3,set_value('product3',$before->product3));?>
<label for="Product3">Product3</label>
</div>
</div>

<div class=" row">
<div class=" input-field col s12 m6">
<?php echo form_dropdown("product4",$product4,set_value('product4',$before->product4));?>
<label for="Product4">Product4</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big image1">
                   			<?php if ($before->image1 == '') {
} else {
    ?><img src="<?php echo base_url('uploads').'/'.$before->image1;
    ?>">
						<?php
} ?></span>
				<div class="btn blue darken-4">
					<span>image1</span>
					<input name="image1" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate image1" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image1', $before->image1);?>">
				</div>
<!--				<div class="md4"><a class="waves-effect waves-light btn red clearimg input-field ">Clear Image</a></div>-->
			</div>

		</div>
		
		<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big image1">
                   			<?php if ($before->imagehover == '') {
} else {
    ?><img src="<?php echo base_url('uploads').'/'.$before->imagehover;
    ?>">
						<?php
} ?></span>
				<div class="btn blue darken-4">
					<span>imagehover</span>
					<input name="imagehover" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate image1" type="text" placeholder="Upload one or more files" value="<?php echo set_value('imagehover', $before->imagehover);?>">
				</div>
<!--				<div class="md4"><a class="waves-effect waves-light btn red clearimg input-field ">Clear Image</a></div>-->
			</div>

		</div>
<!--
<div class="row">
<div class="input-field col s6">
<label for="Image Hover">Image Hover</label>
<input type="text" id="Image Hover" name="imagehover" value='<?php echo set_value('imagehover',$before->imagehover);?>'>
</div>
</div>
-->
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewhomecategory"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
