<div class="row">
	<div class="col s12">
		<h4 class="pad-left-15 capitalize">Edit User</h4>
	</div>
</div>
<div class="row">
	<form class="col s12" method="post" action="<?php echo site_url('site/editusersubmit');?>" enctype="multipart/form-data">
		<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">

		<div class="row">
			<div class="input-field col m6 s12">
				<label>Name</label>
				<input type="text" name="name" value="<?php echo set_value('name',$before->name);?>">
			</div>
		</div>

		<div class="row">
			<div class="input-field col m6 s12">
				<label for="email">Email</label>
				<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
			</div>
		</div>
		<div class="row">
			<div class="input-field col m6 s12">
				<input type="password" name="password" value="" id="password">
				<label for="password">Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col m6 s12">
				<input type="password" name="confirmpassword" value="" id="confirmpassword">
				<label for="confirmpassword">Confirm Password</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col m6 s12">
				<label for="socialid">Social Id</label>
				<input type="text" id="socialid" name="socialid" value="<?php echo set_value('socialid',$before->socialid);?>">
			</div>
		</div>
		<div class="row">
			<div class="input-field col m6 s12">
				<label for="contact">Contact</label>
				<input type="text" id="contact" name="contact" value="<?php echo set_value('contact',$before->contact);?>">
			</div>
		</div>

		<div class="row">
			<div class="input-field col m6 s12">
			<select id="logintype" name="logintype" placeholder="Login Type" id="" value="<?php echo set_value('logintype',$before->logintype);?>">
			    <option value="Email">Email</option>
			    <option value="Facebook">Facebook</option>
			    <option value="Google">Google</option>
			    <option value="Twitter">Twitter</option>
			    <option value="Instagram">Instagram</option>
			</select>
				<label for="logintype">Login Type</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col m6 s12">
				<?php echo form_dropdown( 'status',$status,set_value( 'status',$before->status)); ?>
					<label>Status</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col m6 s12">
				<?php echo form_dropdown( 'accesslevel',$accesslevel,set_value( 'accesslevel',$before->accesslevel)); ?>
					<label>Access Level</label>
			</div>
		</div>
		<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big">
								                    	<?php if($before->image == "") { } else {
									                    ?><img src="<?php echo base_url('uploads')."/".$before->image; ?>">
															<?php } ?>
															</span>
				<div class="btn blue darken-4">
					<span>Image</span>
					<input name="image" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image',$before->image);?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="file-field input-field col m6 s12">
				<span class="img-center big">
								<?php if($before->coverimage == "") { } else {
                    ?><img src="<?php echo base_url('uploads')."/".$before->coverimage; ?>" >
						<?php } ?>
				</span>
				<div class="btn blue darken-4">
					<span>Cover Image</span>
					<input name="coverimage" type="file" multiple>
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('coverimage',$before->coverimage);?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="input-field col m6 s12">
				<textarea name="address" class="materialize-textarea" length="120"><?php echo set_value( 'address',$before->address);?></textarea>
				<label>Address</label>
			</div>
		</div>

		<!--        EVENT NOTIFICATION-->
		<?php if($before->eventnotification == "true") {?>
			<div class="row">
				<div class="col m3 s6">
					<label for="filled-in-box" class="form-checkbox">Event Notification</label>
				</div>
				<div class="col m3 s6">
					<div class="switch">
						<label>
							Off
							<input type="checkbox" name="eventnotification" value="true" checked>
							<span class="lever"></span> On
						</label>
					</div>
				</div>
			</div>
			<?php }
     else { ?>
				<div class="row">
					<div class="col m3 s6">
						<label for="filled-in-box" class="form-checkbox">Event Notification</label>
					</div>
					<div class="col m3 s6">
						<div class="switch">
							<label>
								Off
								<input type="checkbox" name="eventnotification" value="true">
								<span class="lever"></span> On
							</label>
						</div>
					</div>
				</div>

				<?php } ?>

					<!--               PHOTO NOTIFICATION-->
					<?php if($before->photonotification == "true") {?>
						<div class="row">
							<div class="col m3 s6">
								<label for="filled-in-box" class="form-checkbox">Photo Notification</label>
							</div>
							<div class="col m3 s6">
								<div class="switch">
									<label>
										Off
										<input type="checkbox" name="photonotification" value="true" checked>
										<span class="lever"></span> On
									</label>
								</div>
							</div>
						</div>
						<?php }
     else { ?>
							<div class="row">
								<div class="col m3 s6">
									<label for="filled-in-box" class="form-checkbox">Photo Notification</label>
								</div>
								<div class="col m3 s6">
									<div class="switch">
										<label>
											Off
											<input type="checkbox" name="photonotification" value="true">
											<span class="lever"></span> On
										</label>
									</div>
								</div>
							</div>

							<?php } ?>
								<!--               VIDEO NOTIFICATION-->
								<?php if($before->videonotification == "true") {?>
									<div class="row">
										<div class="col m3 s6">
											<label for="filled-in-box" class="form-checkbox">Video Notification</label>
										</div>
										<div class="col m3 s6">
											<div class="switch">
												<label>
													Off
													<input type="checkbox" name="videonotification" value="true" checked>
													<span class="lever"></span> On
												</label>
											</div>
										</div>
									</div>
									<?php }
     else { ?>
										<div class="row">
											<div class="col m3 s6">
												<label for="filled-in-box" class="form-checkbox">Video Notification</label>
											</div>
											<div class="col m3 s6">
												<div class="switch">
													<label>
														Off
														<input type="checkbox" name="videonotification" value="true">
														<span class="lever"></span> On
													</label>
												</div>
											</div>
										</div>

										<?php } ?>
											<!--               BLOG NOTIFICATION-->

											<?php if($before->blognotification == "true") {?>
												<div class="row">
													<div class="col m3 s6">
														<label for="filled-in-box" class="form-checkbox">Blog Notification</label>
													</div>
													<div class="col m3 s6">
														<div class="switch">
															<label>
																Off
																<input type="checkbox" name="blognotification" value="true" checked>
																<span class="lever"></span> On
															</label>
														</div>
													</div>
												</div>
												<?php }
     else { ?>
													<div class="row">
														<div class="col m3 s6">
															<label for="filled-in-box" class="form-checkbox">Blog Notification</label>
														</div>
														<div class="col m3 s6">
															<div class="switch">
																<label>
																	Off
																	<input type="checkbox" name="blognotification" value="true">
																	<span class="lever"></span> On
																</label>
															</div>
														</div>
													</div>

													<?php } ?>
														<div class=" form-group">
															<div class="row">
																<div class="col m12">
																	<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
																	<a href="<?php echo site_url('site/viewusers'); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
																</div>
															</div>
														</div>



	</form>
</div>