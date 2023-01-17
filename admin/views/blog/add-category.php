<script type="text/javascript">
function check_form(a){
	if(a.catTitle.value.trim()=="") {
		alert('Please enter title of category.');
		a.catTitle.focus();
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
				<header><h2><?=($id?'Edit Category':'Add Category')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/blog.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="catTitle" value="<?=$page_data['catTitle']?>" name="catTitle">
                                        </div>
                                    </div>
									
                                    <input type="hidden" name="id" value="<?=$page_data['catID']?>" />
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="add_edit_cat"><?=($id?'Update':'Save')?></button>
										<a href="categories.php" class="btn btn-alt btn-large btn-black">Back</a>
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