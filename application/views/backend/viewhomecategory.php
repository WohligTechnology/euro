<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable capitalize">
<?php $this->chintantable->createsearch(" List of home category");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">Id</th>
<!--
<th data-field="product1">Product1</th>
<th data-field="product2">Product2</th>
<th data-field="product3">Product3</th>
<th data-field="product4">Product4</th>
-->
<th data-field="name">Name</th>
<th data-field="image1">Image1</th>
<th data-field="imagehover">Image Hover</th>
<th data-field="action">Action</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
<div class="createbuttonplacement"><a class="btn-floating btn-large waves-effect waves-light blue darken-4 tooltipped" href="<?php echo site_url("site/createhomecategory"); ?>"data-position="top" data-delay="50" data-tooltip="Create"><i class="material-icons">add</i></a></div>
</div>
</div>
<script>
function drawtable(resultrow) {
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.image1 + "</td><td>" + resultrow.imagehover + "</td><td><a class='btn btn-primary btn-xs waves-effect waves-light blue darken-4 z-depth-0 less-pad' href='<?php echo site_url('site/edithomecategory?id=');?>"+resultrow.id+"'><i class='fa fa-pencil propericon'></i></a><a class='btn btn-danger btn-xs waves-effect waves-light red pad10 z-depth-0 less-pad' onclick=return confirm(\"Are you sure you want to delete?\") href='<?php echo site_url('site/deletehomecategory?id='); ?>"+resultrow.id+"'><i class='material-icons propericon'>delete</i></a></td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
