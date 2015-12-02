<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create enquiry</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createenquirysubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Status">Status</label>
<input type="text" id="Status" name="status" value='<?php echo set_value('status');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Name">Name</label>
<input type="text" id="Name" name="name" value='<?php echo set_value('name');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Email Id">Email Id</label>
<input type="email" id="Email Id" name="email" value='<?php echo set_value('email');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Telephone">Telephone</label>
<input type="text" id="Telephone" name="telephone" value='<?php echo set_value('telephone');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s12">
<textarea name="query" class="materialize-textarea" length="400"><?php echo set_value( 'query');?></textarea>
<label>Query</label>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewenquiry"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
