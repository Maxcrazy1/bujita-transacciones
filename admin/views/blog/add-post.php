<script type="text/javascript">
function check_form(a){
	if(a.postTitle.value.trim()=="") {
		alert('Please enter title');
		a.postTitle.focus();
		return false;
	} else if(a.postCont.value.trim()=="") {
		alert('Please enter content');
		a.postCont.focus();
		return false;
	}
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Add/Edit Blog</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/blog.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Title</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="postTitle" value="<?=$blog_data['postTitle']?>" name="postTitle">
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Title</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="meta_title" value="<?=$blog_data['meta_title']?>" name="meta_title">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Description</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_desc" rows="4"><?=$blog_data['meta_desc']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Keywords</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_keywords" rows="3"><?=$blog_data['meta_keywords']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="fileInput">Icon</label>
                                        <div class="controls">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="input-append">
                                                    <div class="uneditable-input">
                                                        <i class="icon-file fileupload-exists"></i>
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-alt btn-file">
                                                            <span class="fileupload-new">Select Image</span>
                                                            <span class="fileupload-exists">Change</span>
                                                            <input type="file" class="form-control" id="image" name="image" onChange="checkFile(this)">
                                                    </span>
                                                    <a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>
											
											<?php 
											if($blog_data['image']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/blog/<?=$blog_data['image']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/blog.php?id=<?=$_REQUEST['id']?>&r_b_img_id=<?=$blog_data['postID']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
													</div>
												</div>
											<?php 
											} ?>	 
										</div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Content</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="postCont" rows="8"><?=$blog_data['postCont']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Categories</label>
                                        <div class="controls">
										<?php get_categories_list($id); ?>
                                        </div>
                                    </div>
									
                                    <input type="hidden" name="id" value="<?=$blog_data['postID']?>" />
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="add_edit_blog"><?=($id?'Update':'Save')?></button>
										<a href="blog.php" class="btn btn-alt btn-large btn-black">Back</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>