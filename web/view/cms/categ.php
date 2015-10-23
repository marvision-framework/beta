
                    <!-- categ BEGIN -->
   <div class="mailbox row">
       <div class="col-xs-12">
           <div class="box box-solid">
               <div class="box-body">
                   <div class="row">
                       <div class="col-md-9 col-sm-8"> 
						<div class="tab-content col-md-12"> 
                           <?php foreach ($categ as $key => $cat) { 
                           	$cat = categdata($cat); 
                           ?>
						<div class="tab-pane" id="tab_<?php echo $cat->id;?>"> 
						<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="iddata" value="<?php echo $cat->id;?>">
						<div class="modal-body  col-md-12">
			                    <div class="col-md-12 fileupload fileupload-new" data-provides="fileupload">
			                        <div class="fileupload-new thumbnail" style="width: 100%; height: 150px;"><img src="<?php echo $cat->cover;?>" alt="" style="width:100%;"/></div>
			                        <div class="fileupload-preview fileupload-exists thumbnail fullimg" style="max-width: 100%; min-width: 100%;max-height: 150px; min-height: 160px;"></div>
			                        <div style="margin-top: -35px;">
			                            <span class="btn btn-file btn-primary"><span class="fileupload-new">Select Cover image</span><span class="fileupload-exists"><i class="ion ion-refresh"></i></span>
			                            <input type="file" name="img" /></span>
			                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="ion ion-close"></i></a>
			                        </div>
			                    </div>
						<div class="form-group col-md-4">
			                    <div class="fileupload fileupload-new" data-provides="fileupload">
			                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $cat->logo;?>" alt="" /></div>
			                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
			                        <div style="margin-top:-39px;">
			                            <span class="btn btn-file btn-primary"><span class="fileupload-new">Select Logo</span><span class="fileupload-exists"><i class="ion ion-refresh"></i></span>
			                            <input type="file" name="logo" /></span>
			                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="ion ion-close"></i></a>
			                        </div>
			                    </div>
						<label>Parents</label>
						<select name="parent" class="form-control ar_p" style="font-size:12px;">
							<option value="0">&nbsp;Racine principale</option>
							<?php foreach (categ_articlewithparent("0") as $key => $value) { ?>
							<option <?php if($cat->idparent == $value->id){ echo "selected";} ?> value="<?php echo $value->id;?>" <?php if($cat->id == $value->id){ echo "disabled"; }?> >&nbsp; - <?php echo categdata($value)->title;?></option>
			            	<?php if (!empty(categ_articlewithparent($value->id)) && ($value->id != $cat->id)) { ?>
				                
							<?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
							<option <?php if($cat->idparent == $value->id){ echo "selected";} ?> value="<?php echo $value->id;?>" <?php if($cat->id == $value->id){ echo "disabled"; }?> >&nbsp; -- <?php echo categdata($value)->title;?></option>
					        <?php if (!empty(categ_articlewithparent($value->id)) && ($value->id != $cat->id)) { ?>
						    <?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
							<option <?php if($cat->idparent == $value->id){ echo "selected";} ?> value="<?php echo $value->id;?>" <?php if($cat->id == $value->id){ echo "disabled"; }?> >&nbsp; --- <?php echo categdata($value)->title;?></option>
							<?php if (!empty(categ_articlewithparent($value->id)) && ($value->id != $cat->id)) { ?>
							<?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
							<option <?php if($cat->idparent == $value->id){ echo "selected";} ?> value="<?php echo $value->id;?>" <?php if($cat->id == $value->id){ echo "disabled"; }?> >&nbsp; ---- <?php echo categdata($value)->title;?></option>
							<?php }}}}}}} ?>
						</select> <hr>
											                        <div class="input-group">
									                                    <label>Catégorie Color :</label>
											                        	<div class="col-md-12"> <input type="color" class="form-control" name="color" value="<?php echo $cat->color;?>"   /></div>
											                        </div>
											                        
											                        <div class="input-group">
									                                    <label>Catégorie icon :</label>
											                        	<div class="col-md-12"> <input type="text" placeholder=" ion-... " name="icon" class="form-control" value="<?php echo $cat->icon;?>" data-toggle="modal" data-target="#ionicons" id="code_icon_<?php echo $cat->id;?>" onclick="iigetinput(this)" /></div>
											                        </div>
									                            </div>
									                            <div class="form-group col-md-8">
									                                
									                                <div class="input-group">
									                                    <label>Catégorie Title:</label> 
									                    				<?php foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) { ?>
									                        				<input name="title<?php echo $lang;?>" type="text" id="title<?php echo $lang;?>" oninput="autoSlug(this.value,'autoslugcateg<?php echo $cat->id;?>')" class="form-control" placeholder="<?php echo strtoupper($lang);?>" value="<?php echo $cat->alltitle[$lang];?>">
									                                	<?php } ?>
									                                </div> <hr>
									                                <div class="input-group">
									                                    <label>Catégorie Slug :</label>
									                                    <input name="slug" type="text" class="form-control" id="autoslugcateg<?php echo $cat->id;?>" placeholder="Catégorie Slug" value="<?php echo $cat->slug;?>">
									                                </div> <hr>
									                            </div>
									                            <div class="form-group col-md-6 col-md-offset-4">
									                                <div class="checkbox">
									                                    <label>
									                                        <input type="checkbox" name="option[pub]" value="1" <?php if($cat->online == "1"){ echo "checked";}?>/>
									                                            Publier
									                                    </label>
									                                </div>
									                            </div>
									                            <div class="form-group col-md-6 col-md-offset-4">
									                                <div class="checkbox">
									                                    <label>
									                                        <input type="checkbox" name="option[menu]" value="1" <?php if($cat->menu == "1"){ echo "checked";}?>/>
									                                            Menu
									                                    </label>
									                                </div>
									                            </div>
									                        </div>
									                        <div class="modal-footer clearfix ">
									                            	<input type="submit" class="btn btn-primary" name="editcateg" value=" Modifer " <?php if($_SESSION['User']->role != "2"){echo 'disabled="disabled"';} ?>/>
									                            	<input type="submit" class="btn btn-danger" name="deletecateg" value=" supprimer " <?php if($_SESSION['User']->role != "2"){echo 'disabled="disabled"';} ?>/>
									                        </div>
									                    </form>
								                    </div><!-- /.tab- -->
							                    <?php } ?>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->

                                <div class="col-md-3 col-sm-4 ar_p">
                                <a class="btn btn-block btn-primary" <?php if($_SESSION['User']->role != "2"){echo 'disabled="disabled"';} ?> data-toggle="modal" data-target="#compose-modal"><i class="fa fa-inbox"></i>  Add New Folder</a>
                                <div style="margin-top: 15px;">
								<ul class="nav nav-pills nav-stacked " style="padding-right: 0;">
	                                <?php foreach (categ_articlewithparent("0") as $key => $value) { ?>
									<li>
									  <a href="#tab_<?php echo $value->id;?>" data-toggle="tab"><b><?php echo categdata($value)->title;?></b> </a>
									</li>
									<?php if (!empty(categ_articlewithparent($value->id))) {
											foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
											<li class=""><a href="#tab_<?php echo $value->id;?>" data-toggle="tab"> <i class="ion ion-minus-round"></i> <i class="ion ion-arrow-left-c"></i> <?php echo categdata($value)->title;?> </a></li>
											<?php if (!empty(categ_articlewithparent($value->id))) {
											foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
											<li class=""><a href="#tab_<?php echo $value->id;?>" data-toggle="tab"> <i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i> <i class="ion ion-arrow-left-c"></i> <?php echo categdata($value)->title;?> </a></li>
											<?php if (!empty(categ_articlewithparent($value->id))) {
											foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
											<li class=""><a href="#tab_<?php echo $value->id;?>" data-toggle="tab"> <i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i> <i class="ion ion-arrow-left-c"></i> <?php echo categdata($value)->title;?> </a></li>
											<?php if (!empty(categ_articlewithparent($value->id))) {
												foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
												<li class=""><a href="#tab_<?php echo $value->id;?>" data-toggle="tab"> <i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i><i class="ion ion-minus-round"></i> <i class="ion ion-arrow-left-c"></i> <?php echo categdata($value)->title;?> </a></li>
									<?php }}}}}}}} ?>
								<?php } ?>
								</ul>
                           </div>
                        </div><!-- /.col (LEFT) -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col (MAIN) -->
   </div>
<!-- categ END -->


<!-- model -->
<input type="hidden" id="inputhoveriuonicon" value="">
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title ar"><i class="fa fa-inbox"></i>  Add New Catégorie</h4>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body  col-md-12">
					<div class="col-md-12 fileupload fileupload-new" data-provides="fileupload">
			            <div class="fileupload-new thumbnail" style="width: 100%; height: 150px;"><img src="<?php echo URL;?>/assets/upload/img/demoUpload.jpg" alt="" style="width:100%;"/></div>
			            <div class="fileupload-preview fileupload-exists thumbnail fullimg" style="max-width: 100%; min-width: 100%;max-height: 150px; min-height: 160px;"></div>
			            <div style="margin-top: -35px;">
			                <span class="btn btn-file btn-primary"><span class="fileupload-new">Select Cover image</span><span class="fileupload-exists"><i class="ion ion-refresh"></i></span>
			                <input type="file" name="img" /></span>
			                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="ion ion-close"></i></a>
			            </div>
			        </div>
                    <div class="form-group col-md-4"> 
			            <div class="fileupload fileupload-new" data-provides="fileupload">
			                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo URL;?>/assets/upload/img/demoUpload.jpg" alt="" /></div>
			                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
			                <div style="margin-top:-39px;">
			                    <span class="btn btn-file btn-primary"><span class="fileupload-new">Select Logo</span><span class="fileupload-exists"><i class="ion ion-refresh"></i></span>
			                    <input type="file" name="logo" /></span>
			                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="ion ion-close"></i></a>
			                </div>
			            </div>
	                     <hr>
			            <div class="input-group">
	                     <label>Catégorie Color :</label>
			             <div class="col-md-12"> <input type="color" class="form-control" name="color" value="" /></div>
			            </div>
			            <div class="input-group">
	                      <label>Catégorie icon :</label>
			              <div class="col-md-12"> <input type="text" placeholder=" ion-... " name="icon" class="form-control" value="" data-toggle="modal" data-target="#ionicons" id="code_icon" onclick="iigetinput(this)" /></div>
			            </div>
	                    <hr>
	                    <label>Parents</label>
	                    <select name="parent" class="form-control ar_p" style="font-size:12px;">
	                        <option value="0">&nbsp;Racine principale</option>
	                    <?php foreach (categ_articlewithparent("0") as $key => $value) { ?>
	                       <option value="<?php echo $value->id;?>">&nbsp; - <?php echo categdata($value)->title;?></option>
						<?php if (!empty(categ_articlewithparent($value->id))) { ?>
						<?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
	                        <option value="<?php echo $value->id;?>">&nbsp; -- <?php echo categdata($value)->title;?></option>
						<?php if (!empty(categ_articlewithparent($value->id))) { ?>
						<?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
	                           <option value="<?php echo $value->id;?>">&nbsp; --- <?php echo categdata($value)->title;?></option>
						<?php if (!empty(categ_articlewithparent($value->id))) { ?>
						<?php foreach (categ_articlewithparent($value->id) as $key => $value) { ?>
	                            <option value="<?php echo $value->id;?>">&nbsp; ---- <?php echo categdata($value)->title;?></option>
						<?php }}}}}}} ?>
	                    </select>
                    </div>
                    <div class="form-group col-md-8">
                    <div class="input-group">
                       <label>Catégorie Title:</label> 
            		<?php foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) { ?>
                	<input name="title<?php echo $lang;?>" type="text" id="title<?php echo $lang;?>" oninput="autoSlug(this.value,'autoslugcateg')" class="form-control" placeholder="<?php echo strtoupper($lang);?>">
                     <?php } ?>
                    </div> <hr>
                    <div class="input-group">
                        <label>Catégorie Slug :</label>
                        <input name="slug" type="text" class="form-control" id="autoslugcateg" placeholder="Catégorie Slug">
                    </div>  <hr>

                    <div class="form-group col-md-6 col-md-offset-4">
                        <div class="checkbox">
	                        <label><input type="checkbox" name="option[pub]" value="1"/>Publier</label>
                    	</div>
                    </div>
                    <div class="form-group col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label><input type="checkbox" name="option[menu]" value="1"/>Menu</label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer clearfix ">
                    <input type="submit" class="btn btn-primary" name="addcateg" value=" Ajouter "  <?php if($_SESSION['User']->role != "2"){echo 'disabled="disabled"';} ?>/>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" <?php if($_SESSION['User']->role != "2"){echo 'disabled="disabled"';} ?>> Fermer </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="ionicons" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>ion icons framework</b> <i>Version 2.0.1</i></h4>
            </div>
        <div class="modal-body">
            <ul id="listionicons">
              <li onclick="IonSetClass(this)" class="ion-ionic" data-pack="default" data-tags="badass, framework, sexy, hawt"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-up-a" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-right-a" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-down-a" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-left-a" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-up-b" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-right-b" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-down-b" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-left-b" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-up-c" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-right-c" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-down-c" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-left-c" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-return-right" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-return-left" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-swap" data-pack="default" data-tags="switch, flip"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-shrink" data-pack="default" data-tags="pinch"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-expand" data-pack="default" data-tags="fullscreen"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-move" data-pack="default" data-tags="drag"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-resize" data-pack="default" data-tags="drag"></li>
              <li onclick="IonSetClass(this)" class="ion-chevron-up" data-pack="default" data-tags="arrow, up"></li>
              <li onclick="IonSetClass(this)" class="ion-chevron-right" data-pack="default" data-tags="arrow, right"></li>
              <li onclick="IonSetClass(this)" class="ion-chevron-down" data-pack="default" data-tags="arrow, down"></li>
              <li onclick="IonSetClass(this)" class="ion-chevron-left" data-pack="default" data-tags="arrow, left"></li>
              <li onclick="IonSetClass(this)" class="ion-navicon-round" data-pack="default" data-tags="menu, hamburger, slide menu"></li>
              <li onclick="IonSetClass(this)" class="ion-navicon" data-pack="default" data-tags="menu, hamburger, slide menu"></li>
              <li onclick="IonSetClass(this)" class="ion-drag" data-pack="default" data-tags="reorder, move, drag"></li>
              <li onclick="IonSetClass(this)" class="ion-log-in" data-pack="default" data-tags="sign in, "></li>
              <li onclick="IonSetClass(this)" class="ion-log-out" data-pack="default" data-tags="sign out"></li>
              <li onclick="IonSetClass(this)" class="ion-checkmark-round" data-pack="default" data-tags="complete, finished, success, on"></li>
              <li onclick="IonSetClass(this)" class="ion-checkmark" data-pack="default" data-tags="complete, finished, success, on"></li>
              <li onclick="IonSetClass(this)" class="ion-checkmark-circled" data-pack="default" data-tags="complete, finished, success, on"></li>
              <li onclick="IonSetClass(this)" class="ion-close-round" data-pack="default" data-tags="delete, trash, kill, x"></li>
              <li onclick="IonSetClass(this)" class="ion-close" data-pack="default" data-tags="delete, trash, kill, x"></li>
              <li onclick="IonSetClass(this)" class="ion-close-circled" data-pack="default" data-tags="delete, trash, kill, x"></li>
              <li onclick="IonSetClass(this)" class="ion-plus-round" data-pack="default" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-plus" data-pack="default" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-plus-circled" data-pack="default" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-minus-round" data-pack="default" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-minus" data-pack="default" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-minus-circled" data-pack="default" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-information" data-pack="default" data-tags="help, more, tooltip"></li>
              <li onclick="IonSetClass(this)" class="ion-information-circled" data-pack="default" data-tags="help, more, tooltip"></li>
              <li onclick="IonSetClass(this)" class="ion-help" data-pack="default" data-tags="question, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-help-circled" data-pack="default" data-tags="question, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-backspace-outline" data-pack="default" data-tags="delete, remove, back"></li>
              <li onclick="IonSetClass(this)" class="ion-backspace" data-pack="default" data-tags="delete, remove, back"></li>
              <li onclick="IonSetClass(this)" class="ion-help-buoy" data-pack="default" data-tags="question, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-asterisk" data-pack="default" data-tags="favorite, mark, star"></li>
              <li onclick="IonSetClass(this)" class="ion-alert" data-pack="default" data-tags="attention, warning, notice, !, exclamation"></li>
              <li onclick="IonSetClass(this)" class="ion-alert-circled" data-pack="default" data-tags="attention, warning, notice, !, exclamation"></li>
              <li onclick="IonSetClass(this)" class="ion-refresh" data-pack="default" data-tags="reload, renew"></li>
              <li onclick="IonSetClass(this)" class="ion-loop" data-pack="default" data-tags="refresh"></li>
              <li onclick="IonSetClass(this)" class="ion-shuffle" data-pack="default" data-tags="random"></li>
              <li onclick="IonSetClass(this)" class="ion-home" data-pack="default" data-tags="house"></li>
              <li onclick="IonSetClass(this)" class="ion-search" data-pack="default" data-tags="magnifying glass"></li>
              <li onclick="IonSetClass(this)" class="ion-flag" data-pack="default" data-tags="favorite, mark, star"></li>
              <li onclick="IonSetClass(this)" class="ion-star" data-pack="default" data-tags="favorite"></li>
              <li onclick="IonSetClass(this)" class="ion-heart" data-pack="default" data-tags="love"></li>
              <li onclick="IonSetClass(this)" class="ion-heart-broken" data-pack="default" data-tags="love"></li>
              <li onclick="IonSetClass(this)" class="ion-gear-a" data-pack="default" data-tags="settings, options, cog"></li>
              <li onclick="IonSetClass(this)" class="ion-gear-b" data-pack="default" data-tags="settings, options, cog"></li>
              <li onclick="IonSetClass(this)" class="ion-toggle-filled" data-pack="default" data-tags="settings, options, switch"></li>
              <li onclick="IonSetClass(this)" class="ion-toggle" data-pack="default" data-tags="settings, options, switch"></li>
              <li onclick="IonSetClass(this)" class="ion-settings" data-pack="default" data-tags="options, tools"></li>
              <li onclick="IonSetClass(this)" class="ion-wrench" data-pack="default" data-tags="settings, options, tools"></li>
              <li onclick="IonSetClass(this)" class="ion-hammer" data-pack="default" data-tags="settings, options, tools"></li>
              <li onclick="IonSetClass(this)" class="ion-edit" data-pack="default" data-tags="change, update, write, type, pencil"></li>
              <li onclick="IonSetClass(this)" class="ion-trash-a" data-pack="default" data-tags="delete, remove, dump"></li>
              <li onclick="IonSetClass(this)" class="ion-trash-b" data-pack="default" data-tags="delete, remove, dump"></li>
              <li onclick="IonSetClass(this)" class="ion-document" data-pack="default" data-tags="paper, file"></li>
              <li onclick="IonSetClass(this)" class="ion-document-text" data-pack="default" data-tags="paper, file"></li>
              <li onclick="IonSetClass(this)" class="ion-clipboard" data-pack="default" data-tags="write"></li>
              <li onclick="IonSetClass(this)" class="ion-scissors" data-pack="default" data-tags="cut"></li>
              <li onclick="IonSetClass(this)" class="ion-funnel" data-pack="default" data-tags="sort"></li>
              <li onclick="IonSetClass(this)" class="ion-bookmark" data-pack="default" data-tags="favorite, tag, save"></li>
              <li onclick="IonSetClass(this)" class="ion-email" data-pack="default" data-tags="snail, mail, inbox"></li>
              <li onclick="IonSetClass(this)" class="ion-email-unread" data-pack="default" data-tags="snail, mail, inbox"></li>
              <li onclick="IonSetClass(this)" class="ion-folder" data-pack="default" data-tags="snail, mail"></li>
              <li onclick="IonSetClass(this)" class="ion-filing" data-pack="default" data-tags="mail"></li>
              <li onclick="IonSetClass(this)" class="ion-archive" data-pack="default" data-tags="mail"></li>
              <li onclick="IonSetClass(this)" class="ion-reply" data-pack="default" data-tags="mail, undo"></li>
              <li onclick="IonSetClass(this)" class="ion-reply-all" data-pack="default" data-tags="mail"></li>
              <li onclick="IonSetClass(this)" class="ion-forward" data-pack="default" data-tags="mail, redo"></li>
              <li onclick="IonSetClass(this)" class="ion-share" data-pack="default" data-tags="outbound"></li>
              <li onclick="IonSetClass(this)" class="ion-paper-airplane" data-pack="default" data-tags="outbound, mail, letter, send"></li>
              <li onclick="IonSetClass(this)" class="ion-link" data-pack="default" data-tags="chain, anchor, href, attach"></li>
              <li onclick="IonSetClass(this)" class="ion-paperclip" data-pack="default" data-tags="attach"></li>
              <li onclick="IonSetClass(this)" class="ion-compose" data-pack="default" data-tags="write, compose, type"></li>
              <li onclick="IonSetClass(this)" class="ion-briefcase" data-pack="default" data-tags="store, organize"></li>
              <li onclick="IonSetClass(this)" class="ion-medkit" data-pack="default" data-tags="health"></li>
              <li onclick="IonSetClass(this)" class="ion-at" data-pack="default" data-tags="@"></li>
              <li onclick="IonSetClass(this)" class="ion-pound" data-pack="default" data-tags="hashtag, #"></li>
              <li onclick="IonSetClass(this)" class="ion-quote" data-pack="default" data-tags="chat, quotation"></li>
              <li onclick="IonSetClass(this)" class="ion-cloud" data-pack="default" data-tags="storage"></li>
              <li onclick="IonSetClass(this)" class="ion-upload" data-pack="default" data-tags="storage, cloud"></li>
              <li onclick="IonSetClass(this)" class="ion-more" data-pack="default" data-tags="circles"></li>
              <li onclick="IonSetClass(this)" class="ion-grid" data-pack="default" data-tags="menu"></li>
              <li onclick="IonSetClass(this)" class="ion-calendar" data-pack="default" data-tags="date, time, month, year"></li>
              <li onclick="IonSetClass(this)" class="ion-clock" data-pack="default" data-tags="time, watch, hours, minutes, seconds"></li>
              <li onclick="IonSetClass(this)" class="ion-compass" data-pack="default" data-tags="location, directions, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-pinpoint" data-pack="default" data-tags="gps, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-pin" data-pack="default" data-tags="gps, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-navigate" data-pack="default" data-tags="gps, location pin"></li>
              <li onclick="IonSetClass(this)" class="ion-location" data-pack="default" data-tags="gps, navigation, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-map" data-pack="default" data-tags="gps, navigation, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-lock-combination" data-pack="default" data-tags="padlock, security"></li>
              <li onclick="IonSetClass(this)" class="ion-locked" data-pack="default" data-tags="padlock, security"></li>
              <li onclick="IonSetClass(this)" class="ion-unlocked" data-pack="default" data-tags="padlock, security"></li>
              <li onclick="IonSetClass(this)" class="ion-key" data-pack="default" data-tags="access"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-graph-up-right" data-pack="default" data-tags="stats"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-graph-down-right" data-pack="default" data-tags="stats"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-graph-up-left" data-pack="default" data-tags="stats"></li>
              <li onclick="IonSetClass(this)" class="ion-arrow-graph-down-left" data-pack="default" data-tags="stats"></li>
              <li onclick="IonSetClass(this)" class="ion-stats-bars" data-pack="default" data-tags="data"></li>
              <li onclick="IonSetClass(this)" class="ion-connection-bars" data-pack="default" data-tags="data, stats"></li>
              <li onclick="IonSetClass(this)" class="ion-pie-graph" data-pack="default" data-tags="stats"></li>
              <li onclick="IonSetClass(this)" class="ion-chatbubble" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-chatbubble-working" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-chatbubbles" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-chatbox" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-chatbox-working" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-chatboxes" data-pack="default" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-person" data-pack="default" data-tags="users, staff, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-person-add" data-pack="default" data-tags="users, staff, head, human, member, new"></li>
              <li onclick="IonSetClass(this)" class="ion-person-stalker" data-pack="default" data-tags="people, human, users, staff"></li>
              <li onclick="IonSetClass(this)" class="ion-woman" data-pack="default" data-tags="female, lady, girl, dudette"></li>
              <li onclick="IonSetClass(this)" class="ion-man" data-pack="default" data-tags="male, guy, boy, dude"></li>
              <li onclick="IonSetClass(this)" class="ion-female" data-pack="default" data-tags="lady, girl, dudette"></li>
              <li onclick="IonSetClass(this)" class="ion-male" data-pack="default" data-tags="male, guy, boy, dude"></li>
              <li onclick="IonSetClass(this)" class="ion-transgender" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-fork" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-knife" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-spoon" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-soup-can-outline" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-soup-can" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-beer" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-wineglass" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-coffee" data-pack="default" data-tags="food, drink, eat, caffeine"></li>
              <li onclick="IonSetClass(this)" class="ion-icecream" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-pizza" data-pack="default" data-tags="food, drink, eat"></li>
              <li onclick="IonSetClass(this)" class="ion-power" data-pack="default" data-tags="on, off"></li>
              <li onclick="IonSetClass(this)" class="ion-mouse" data-pack="default" data-tags="computer"></li>
              <li onclick="IonSetClass(this)" class="ion-battery-full" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-battery-half" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-battery-low" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-battery-empty" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-battery-charging" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-wifi" data-pack="default" data-tags="internet, connection"></li>
              <li onclick="IonSetClass(this)" class="ion-bluetooth" data-pack="default" data-tags="connection, cloud"></li>
              <li onclick="IonSetClass(this)" class="ion-calculator" data-pack="default" data-tags="math, arithmatic, numbers, addition, subtraction"></li>
              <li onclick="IonSetClass(this)" class="ion-camera" data-pack="default" data-tags="photo"></li>
              <li onclick="IonSetClass(this)" class="ion-eye" data-pack="default" data-tags="view, see, creeper"></li>
              <li onclick="IonSetClass(this)" class="ion-eye-disabled" data-pack="default" data-tags="view, see, creeper"></li>
              <li onclick="IonSetClass(this)" class="ion-flash" data-pack="default" data-tags="lightning, weather, whether"></li>
              <li onclick="IonSetClass(this)" class="ion-flash-off" data-pack="default" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-qr-scanner" data-pack="default" data-tags="reader"></li>
              <li onclick="IonSetClass(this)" class="ion-image" data-pack="default" data-tags="photo"></li>
              <li onclick="IonSetClass(this)" class="ion-images" data-pack="default" data-tags="photo"></li>
              <li onclick="IonSetClass(this)" class="ion-wand" data-pack="default" data-tags="images, levels, light, dark, settings"></li>
              <li onclick="IonSetClass(this)" class="ion-contrast" data-pack="default" data-tags="images, levels, light, dark, settings"></li>
              <li onclick="IonSetClass(this)" class="ion-aperture" data-pack="default" data-tags="images, levels, light, dark, settings"></li>
              <li onclick="IonSetClass(this)" class="ion-crop" data-pack="default" data-tags="images, levels, light, dark, settings"></li>
              <li onclick="IonSetClass(this)" class="ion-easel" data-pack="default" data-tags="images, art, create, color"></li>
              <li onclick="IonSetClass(this)" class="ion-paintbrush" data-pack="default" data-tags="images, art, create, color"></li>
              <li onclick="IonSetClass(this)" class="ion-paintbucket" data-pack="default" data-tags="images, art, create, color"></li>
              <li onclick="IonSetClass(this)" class="ion-monitor" data-pack="default" data-tags="thunderbolt, screen"></li>
              <li onclick="IonSetClass(this)" class="ion-laptop" data-pack="default" data-tags="macbook, apple, osx"></li>
              <li onclick="IonSetClass(this)" class="ion-ipad" data-pack="default" data-tags="tablet, mobile, apple, retina, device"></li>
              <li onclick="IonSetClass(this)" class="ion-iphone" data-pack="default" data-tags="smartphone, mobile, apple, retina, device"></li>
              <li onclick="IonSetClass(this)" class="ion-ipod" data-pack="default" data-tags="music, player, apple, retina, device"></li>
              <li onclick="IonSetClass(this)" class="ion-printer" data-pack="default" data-tags="paper"></li>
              <li onclick="IonSetClass(this)" class="ion-usb" data-pack="default" data-tags="digital, computer"></li>
              <li onclick="IonSetClass(this)" class="ion-outlet" data-pack="default" data-tags="digital, computer, electricity"></li>
              <li onclick="IonSetClass(this)" class="ion-bug" data-pack="default" data-tags="develop, program, hacker, error"></li>
              <li onclick="IonSetClass(this)" class="ion-code" data-pack="default" data-tags="develop, program, hacker"></li>
              <li onclick="IonSetClass(this)" class="ion-code-working" data-pack="default" data-tags="develop, program, hacker"></li>
              <li onclick="IonSetClass(this)" class="ion-code-download" data-pack="default" data-tags="develop, program, hacker"></li>
              <li onclick="IonSetClass(this)" class="ion-fork-repo" data-pack="default" data-tags="develop, program, hacker, github"></li>
              <li onclick="IonSetClass(this)" class="ion-network" data-pack="default" data-tags="develop, program, hacker, github"></li>
              <li onclick="IonSetClass(this)" class="ion-pull-request" data-pack="default" data-tags="develop, program, hacker, github"></li>
              <li onclick="IonSetClass(this)" class="ion-merge" data-pack="default" data-tags="develop, program, hacker, github"></li>
              <li onclick="IonSetClass(this)" class="ion-xbox" data-pack="default" data-tags="fun, games"></li>
              <li onclick="IonSetClass(this)" class="ion-playstation" data-pack="default" data-tags="fun, games"></li>
              <li onclick="IonSetClass(this)" class="ion-steam" data-pack="default" data-tags="fun, games"></li>
              <li onclick="IonSetClass(this)" class="ion-closed-captioning" data-pack="default" data-tags="movie, film, television"></li>
              <li onclick="IonSetClass(this)" class="ion-videocamera" data-pack="default" data-tags="movie, film, television"></li>
              <li onclick="IonSetClass(this)" class="ion-film-marker" data-pack="default" data-tags="film, cut, action"></li>
              <li onclick="IonSetClass(this)" class="ion-disc" data-pack="default" data-tags="cd, vinyl"></li>
              <li onclick="IonSetClass(this)" class="ion-headphone" data-pack="default" data-tags="music, earbuds, beats"></li>
              <li onclick="IonSetClass(this)" class="ion-music-note" data-pack="default" data-tags="songs"></li>
              <li onclick="IonSetClass(this)" class="ion-radio-waves" data-pack="default" data-tags="music, sound, speaker"></li>
              <li onclick="IonSetClass(this)" class="ion-speakerphone" data-pack="default" data-tags="sound, speaker, loud, amplify"></li>
              <li onclick="IonSetClass(this)" class="ion-mic-a" data-pack="default" data-tags="sound, talk, speaker"></li>
              <li onclick="IonSetClass(this)" class="ion-mic-b" data-pack="default" data-tags="sound, talk, speaker"></li>
              <li onclick="IonSetClass(this)" class="ion-mic-c" data-pack="default" data-tags="sound, talk, speaker"></li>
              <li onclick="IonSetClass(this)" class="ion-volume-high" data-pack="default" data-tags="sound, noise"></li>
              <li onclick="IonSetClass(this)" class="ion-volume-medium" data-pack="default" data-tags="sound"></li>
              <li onclick="IonSetClass(this)" class="ion-volume-low" data-pack="default" data-tags="sound"></li>
              <li onclick="IonSetClass(this)" class="ion-volume-mute" data-pack="default" data-tags="sound"></li>
              <li onclick="IonSetClass(this)" class="ion-levels" data-pack="default" data-tags="options, toggles, sound, mixer"></li>
              <li onclick="IonSetClass(this)" class="ion-play" data-pack="default" data-tags="music, watch, arrow, right"></li>
              <li onclick="IonSetClass(this)" class="ion-pause" data-pack="default" data-tags="music, break, hold, freeze"></li>
              <li onclick="IonSetClass(this)" class="ion-stop" data-pack="default" data-tags="music, square, hold, freeze"></li>
              <li onclick="IonSetClass(this)" class="ion-record" data-pack="default" data-tags="music, circle"></li>
              <li onclick="IonSetClass(this)" class="ion-skip-forward" data-pack="default" data-tags="music, next"></li>
              <li onclick="IonSetClass(this)" class="ion-skip-backward" data-pack="default" data-tags="music, previous"></li>
              <li onclick="IonSetClass(this)" class="ion-eject" data-pack="default" data-tags="music, dvd, remove"></li>
              <li onclick="IonSetClass(this)" class="ion-bag" data-pack="default" data-tags="shopping, price, cart, money, container, $"></li>
              <li onclick="IonSetClass(this)" class="ion-card" data-pack="default" data-tags="credit, price, debit, money, shopping, cash, dollars, $"></li>
              <li onclick="IonSetClass(this)" class="ion-cash" data-pack="default" data-tags="credit, price, debit, money, shopping, dollars, $"></li>
              <li onclick="IonSetClass(this)" class="ion-pricetag" data-pack="default" data-tags="credit, debit, money, shopping, cash, dollars, $"></li>
              <li onclick="IonSetClass(this)" class="ion-pricetags" data-pack="default" data-tags="credit, debit, money, shopping, cash, dollars, $"></li>
              <li onclick="IonSetClass(this)" class="ion-thumbsup" data-pack="default" data-tags="like, fun, yes"></li>
              <li onclick="IonSetClass(this)" class="ion-thumbsdown" data-pack="default" data-tags="dislike, boring, no"></li>
              <li onclick="IonSetClass(this)" class="ion-happy-outline" data-pack="default" data-tags="good, like, fun, yes"></li>
              <li onclick="IonSetClass(this)" class="ion-happy" data-pack="default" data-tags="good, like, fun, yes"></li>
              <li onclick="IonSetClass(this)" class="ion-sad-outline" data-pack="default" data-tags="cry, bad, no"></li>
              <li onclick="IonSetClass(this)" class="ion-sad" data-pack="default" data-tags="cry, bad, no"></li>
              <li onclick="IonSetClass(this)" class="ion-bowtie" data-pack="default" data-tags="tie, shirt, dress, clothing"></li>
              <li onclick="IonSetClass(this)" class="ion-tshirt-outline" data-pack="default" data-tags="tie, shirt, dress, clothing"></li>
              <li onclick="IonSetClass(this)" class="ion-tshirt" data-pack="default" data-tags="tie, shirt, dress, clothing"></li>
              <li onclick="IonSetClass(this)" class="ion-trophy" data-pack="default" data-tags="competition, compete, win, lose, award"></li>
              <li onclick="IonSetClass(this)" class="ion-podium" data-pack="default" data-tags="competition, compete, win, lose, award"></li>
              <li onclick="IonSetClass(this)" class="ion-ribbon-a" data-pack="default" data-tags="competition, compete, win, lose, award, trophy"></li>
              <li onclick="IonSetClass(this)" class="ion-ribbon-b" data-pack="default" data-tags="competition, compete, win, lose, award, trophy"></li>
              <li onclick="IonSetClass(this)" class="ion-university" data-pack="default" data-tags="graduate, education, school, tassle"></li>
              <li onclick="IonSetClass(this)" class="ion-magnet" data-pack="default" data-tags="sticky, attraction"></li>
              <li onclick="IonSetClass(this)" class="ion-beaker" data-pack="default" data-tags="mixture, potion, flask"></li>
              <li onclick="IonSetClass(this)" class="ion-erlenmeyer-flask" data-pack="default" data-tags="mixture, potion, beaker, potion"></li>
              <li onclick="IonSetClass(this)" class="ion-egg" data-pack="default" data-tags="birth, twitter, bird, baby"></li>
              <li onclick="IonSetClass(this)" class="ion-earth" data-pack="default" data-tags="nature, globe, home, planet"></li>
              <li onclick="IonSetClass(this)" class="ion-planet" data-pack="default" data-tags="nature, globe, home, planet, space"></li>
              <li onclick="IonSetClass(this)" class="ion-lightbulb" data-pack="default" data-tags="idea, new, aha!"></li>
              <li onclick="IonSetClass(this)" class="ion-cube" data-pack="default" data-tags="box, square, container"></li>
              <li onclick="IonSetClass(this)" class="ion-leaf" data-pack="default" data-tags="green, recycle, plant, nature"></li>
              <li onclick="IonSetClass(this)" class="ion-waterdrop" data-pack="default" data-tags="nature, clean, recycle, fresh, wet, rain"></li>
              <li onclick="IonSetClass(this)" class="ion-flame" data-pack="default" data-tags="fire, hot, heat"></li>
              <li onclick="IonSetClass(this)" class="ion-fireball" data-pack="default" data-tags="hot, heat"></li>
              <li onclick="IonSetClass(this)" class="ion-bonfire" data-pack="default" data-tags="hot, heat"></li>
              <li onclick="IonSetClass(this)" class="ion-umbrella" data-pack="default" data-tags="wet, rain, dry, shelter"></li>
              <li onclick="IonSetClass(this)" class="ion-nuclear" data-pack="default" data-tags="danger, warning, hazard"></li>
              <li onclick="IonSetClass(this)" class="ion-no-smoking" data-pack="default" data-tags="danger, warning, cigarette, cancer"></li>
              <li onclick="IonSetClass(this)" class="ion-thermometer" data-pack="default" data-tags="hot, cold, heat, temperature, mercury"></li>
              <li onclick="IonSetClass(this)" class="ion-speedometer" data-pack="default" data-tags="travel, accelerate"></li>
              <li onclick="IonSetClass(this)" class="ion-model-s" data-pack="default" data-tags="navigation, car, drive, transportation, tesla, sexy"></li>
              <li onclick="IonSetClass(this)" class="ion-plane" data-pack="default" data-tags="fly, jet"></li>
              <li onclick="IonSetClass(this)" class="ion-jet" data-pack="default" data-tags="fly, plane"></li>
              <li onclick="IonSetClass(this)" class="ion-load-a" data-pack="default" data-tags="spinner, waiting, refresh"></li>
              <li onclick="IonSetClass(this)" class="ion-load-b" data-pack="default" data-tags="spinner, waiting, refresh"></li>
              <li onclick="IonSetClass(this)" class="ion-load-c" data-pack="default" data-tags="spinner, waiting, refresh"></li>
              <li onclick="IonSetClass(this)" class="ion-load-d" data-pack="default" data-tags="spinner, waiting, refresh"></li>


              <p><!-- end default icons pack --></p>


              <li onclick="IonSetClass(this)" class="ion-ios-ionic-outline" data-pack="ios" data-tags="badass, framework, sexy"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-back" data-pack="ios" data-tags="chevron, left"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-forward" data-pack="ios" data-tags="chevron, right"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-up" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-right" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-down" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-left" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-thin-up" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-thin-right" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-thin-down" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-arrow-thin-left" data-pack="ios" data-tags="chevron"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-circle-filled" data-pack="ios" data-tags="checkmark, radio, dot, on, selected, button"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-circle-outline" data-pack="ios" data-tags="checkmark, radio, dot, off, button"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-checkmark-empty" data-pack="ios" data-tags="success, confirmed, on, finished, complete"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-checkmark-outline" data-pack="ios" data-tags="success, confirmed, on, finished, complete"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-checkmark" data-pack="ios" data-tags="success, confirmed, on, finished, complete"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-plus-empty" data-pack="ios" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-plus-outline" data-pack="ios" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-plus" data-pack="ios" data-tags="add, include, new, invite, +"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-close-empty" data-pack="ios" data-tags="delete, remove, trash, end, stop, x"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-close-outline" data-pack="ios" data-tags="delete, remove, trash, end, stop, x"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-close" data-pack="ios" data-tags="delete, remove, trash, end, stop, x"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-minus-empty" data-pack="ios" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-minus-outline" data-pack="ios" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-minus" data-pack="ios" data-tags="hide, remove, minimize, -"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-information-empty" data-pack="ios" data-tags="help, question"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-information-outline" data-pack="ios" data-tags="help, question"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-information" data-pack="ios" data-tags="help, question"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-help-empty" data-pack="ios" data-tags="question, information, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-help-outline" data-pack="ios" data-tags="question, information, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-help" data-pack="ios" data-tags="question, information, ?"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-search" data-pack="ios" data-tags="find, seek, look, magnifying glass"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-search-strong" data-pack="ios" data-tags="find, seek, look, magnifying glass"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-star" data-pack="ios" data-tags="favorite, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-star-half" data-pack="ios" data-tags="favorite, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-star-outline" data-pack="ios" data-tags="favorite, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-heart" data-pack="ios" data-tags="love"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-heart-outline" data-pack="ios" data-tags="love"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-more" data-pack="ios" data-tags="menu"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-more-outline" data-pack="ios" data-tags="menu"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-home" data-pack="ios" data-tags="house"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-home-outline" data-pack="ios" data-tags="house"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud" data-pack="ios" data-tags="storage, weather, whether"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud-outline" data-pack="ios" data-tags="storage, weather, whether"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud-upload" data-pack="ios" data-tags="storage"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud-upload-outline" data-pack="ios" data-tags="storage"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud-download" data-pack="ios" data-tags="storage"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloud-download-outline" data-pack="ios" data-tags="storage"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-upload" data-pack="ios" data-tags="share, import"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-upload-outline" data-pack="ios" data-tags="share, import"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-download" data-pack="ios" data-tags="save, export"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-download-outline" data-pack="ios" data-tags="save, export"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-refresh" data-pack="ios" data-tags="reload, renew, reset"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-refresh-outline" data-pack="ios" data-tags="reload, renew, reset"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-refresh-empty" data-pack="ios" data-tags="reload, renew"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-reload" data-pack="ios" data-tags="renew, reset"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-loop-strong" data-pack="ios" data-tags="reload, renew, reset"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-loop" data-pack="ios" data-tags="reload, renew, reset"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bookmarks" data-pack="ios" data-tags="favorite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bookmarks-outline" data-pack="ios" data-tags="favorite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-book" data-pack="ios" data-tags="favorite, read, literature"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-book-outline" data-pack="ios" data-tags="favorite, read, literature"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flag" data-pack="ios" data-tags="marker, favorite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flag-outline" data-pack="ios" data-tags="marker, favorite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-glasses" data-pack="ios" data-tags="steve, reading, look, see"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-glasses-outline" data-pack="ios" data-tags="steve, reading, look, see"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-browsers" data-pack="ios" data-tags="square"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-browsers-outline" data-pack="ios" data-tags="square"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-at" data-pack="ios" data-tags="@"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-at-outline" data-pack="ios" data-tags="@"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pricetag" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pricetag-outline" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pricetags" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pricetags-outline" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cart" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cart-outline" data-pack="ios" data-tags="shopping, money, items, commerce, $"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-chatboxes" data-pack="ios" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-chatboxes-outline" data-pack="ios" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-chatbubble" data-pack="ios" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-chatbubble-outline" data-pack="ios" data-tags="talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cog" data-pack="ios" data-tags="settings, gear, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cog-outline" data-pack="ios" data-tags="settings, gear, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-gear" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-gear-outline" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-settings" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-settings-strong" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-toggle" data-pack="ios" data-tags="settings, options, switch"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-toggle-outline" data-pack="ios" data-tags="settings, options, switch"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-analytics" data-pack="ios" data-tags="metrics, track, data"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-analytics-outline" data-pack="ios" data-tags="metrics, track, data"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pie" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pie-outline" data-pack="ios" data-tags="cog, settings, options"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pulse" data-pack="ios" data-tags="live, hot, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pulse-strong" data-pack="ios" data-tags="live, hot, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-filing" data-pack="ios" data-tags="archive"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-filing-outline" data-pack="ios" data-tags="archive"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-box" data-pack="ios" data-tags="archive"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-box-outline" data-pack="ios" data-tags="archive"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-compose" data-pack="ios" data-tags="write, type, create"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-compose-outline" data-pack="ios" data-tags="write, type, create"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-trash" data-pack="ios" data-tags="delete, remove, dispose, waste, basket, dump, kill"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-trash-outline" data-pack="ios" data-tags="delete, remove, dispose, waste, basket, dump, kill"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-copy" data-pack="ios" data-tags="duplicate, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-copy-outline" data-pack="ios" data-tags="duplicate, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-email" data-pack="ios" data-tags="snail, mail"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-email-outline" data-pack="ios" data-tags="snail, mail"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-undo" data-pack="ios" data-tags="reply"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-undo-outline" data-pack="ios" data-tags="reply"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-redo" data-pack="ios" data-tags="forward"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-redo-outline" data-pack="ios" data-tags="forward"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paperplane" data-pack="ios" data-tags="send"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paperplane-outline" data-pack="ios" data-tags="send"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-folder" data-pack="ios" data-tags="file"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-folder-outline" data-pack="ios" data-tags="file"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paper" data-pack="ios" data-tags="feed, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paper-outline" data-pack="ios" data-tags="feed, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-list" data-pack="ios" data-tags="todo, feed, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-list-outline" data-pack="ios" data-tags="todo, feed, paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-world" data-pack="ios" data-tags="globe, earth"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-world-outline" data-pack="ios" data-tags="globe, earth"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-alarm" data-pack="ios" data-tags="wake, ring"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-alarm-outline" data-pack="ios" data-tags="wake, ring"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-speedometer" data-pack="ios" data-tags="speed, drive, level"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-speedometer-outline" data-pack="ios" data-tags="speed, drive, level"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-stopwatch" data-pack="ios" data-tags="time, speed"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-stopwatch-outline" data-pack="ios" data-tags="time, speed"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-timer" data-pack="ios" data-tags="cooking, alarm, buzz"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-timer-outline" data-pack="ios" data-tags="cooking, alarm, buzz"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-clock" data-pack="ios" data-tags="time, date, hours, minutes, seconds, watch"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-clock-outline" data-pack="ios" data-tags="time, date, hours, minutes, seconds, watch"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-time" data-pack="ios" data-tags="clock, watch, hour, minute, second"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-time-outline" data-pack="ios" data-tags="clock, watch, hour, minute, second"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-calendar" data-pack="ios" data-tags="date, time, month, year"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-calendar-outline" data-pack="ios" data-tags="date, time, month, year"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-photos" data-pack="ios" data-tags="images, stills, square"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-photos-outline" data-pack="ios" data-tags="images, stills, square"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-albums" data-pack="ios" data-tags="square, boxes, slides"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-albums-outline" data-pack="ios" data-tags="square, boxes, slides"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-camera" data-pack="ios" data-tags="picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-camera-outline" data-pack="ios" data-tags="picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-reverse-camera" data-pack="ios" data-tags="picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-reverse-camera-outline" data-pack="ios" data-tags="picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-eye" data-pack="ios" data-tags="view, see, exposed, look"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-eye-outline" data-pack="ios" data-tags="view, see, exposed, look"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bolt" data-pack="ios" data-tags="flash, lightning"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bolt-outline" data-pack="ios" data-tags="flash, lightning"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-color-wand" data-pack="ios" data-tags="camera, picture, edit, magic"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-color-wand-outline" data-pack="ios" data-tags="camera, picture, edit, magic"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-color-filter" data-pack="ios" data-tags="camera, picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-color-filter-outline" data-pack="ios" data-tags="camera, picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-grid-view" data-pack="ios" data-tags="camera, picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-grid-view-outline" data-pack="ios" data-tags="camera, picture"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-crop-strong" data-pack="ios" data-tags="camera, picture, edit"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-crop" data-pack="ios" data-tags="camera, picture, edit"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-barcode" data-pack="ios" data-tags="reader, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-barcode-outline" data-pack="ios" data-tags="reader, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-briefcase" data-pack="ios" data-tags="organize, folder"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-briefcase-outline" data-pack="ios" data-tags="organize, folder"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-medkit" data-pack="ios" data-tags="health, case, first aid, sick, disease"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-medkit-outline" data-pack="ios" data-tags="health, case, first aid, sick, disease"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-medical" data-pack="ios" data-tags="health, case, first aid, sick, disease"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-medical-outline" data-pack="ios" data-tags="health, case, first aid, sick, disease"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-infinite" data-pack="ios" data-tags="forever, loop"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-infinite-outline" data-pack="ios" data-tags="forever, loop"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-calculator" data-pack="ios" data-tags="math, arithmatic"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-calculator-outline" data-pack="ios" data-tags="math, arithmatic"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-keypad" data-pack="ios" data-tags="type, grid, circle"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-keypad-outline" data-pack="ios" data-tags="type, grid, circle"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-telephone" data-pack="ios" data-tags="oldschool, call"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-telephone-outline" data-pack="ios" data-tags="oldschool, call"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-drag" data-pack="ios" data-tags="reorder, move, drag"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-location" data-pack="ios" data-tags="navigation, map, gps, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-location-outline" data-pack="ios" data-tags="navigation, map, gps, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-navigate" data-pack="ios" data-tags="location, map, gps, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-navigate-outline" data-pack="ios" data-tags="location, map, gps, pin"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-locked" data-pack="ios" data-tags="security, padlock, safe"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-locked-outline" data-pack="ios" data-tags="security, padlock, safe"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-unlocked" data-pack="ios" data-tags="security, padlock, safe"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-unlocked-outline" data-pack="ios" data-tags="security, padlock, safe"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-monitor" data-pack="ios" data-tags="thunderbolt, display, screen"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-monitor-outline" data-pack="ios" data-tags="thunderbolt, display, screen"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-printer" data-pack="ios" data-tags="paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-printer-outline" data-pack="ios" data-tags="paper"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-game-controller-a" data-pack="ios" data-tags="gaming, nintendo, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-game-controller-a-outline" data-pack="ios" data-tags="gaming, nintendo, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-game-controller-b" data-pack="ios" data-tags="gaming, nintendo, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-game-controller-b-outline" data-pack="ios" data-tags="gaming, nintendo, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-americanfootball" data-pack="ios" data-tags="nfl, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-americanfootball-outline" data-pack="ios" data-tags="nfl, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-baseball" data-pack="ios" data-tags="mlb, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-baseball-outline" data-pack="ios" data-tags="mlb, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-basketball" data-pack="ios" data-tags="nba, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-basketball-outline" data-pack="ios" data-tags="nba, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-tennisball" data-pack="ios" data-tags="games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-tennisball-outline" data-pack="ios" data-tags="games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-football" data-pack="ios" data-tags="mls, soccer, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-football-outline" data-pack="ios" data-tags="mls, soccer, games, sports, fun, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-body" data-pack="ios" data-tags="person, users, staff, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-body-outline" data-pack="ios" data-tags="person, users, staff, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-person" data-pack="ios" data-tags="users, staff, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-person-outline" data-pack="ios" data-tags="users, staff, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-personadd" data-pack="ios" data-tags="users, staff, head, human, new, invite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-personadd-outline" data-pack="ios" data-tags="users, staff, head, human, new, invite"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-people" data-pack="ios" data-tags="stalker, person, users, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-people-outline" data-pack="ios" data-tags="stalker, person, users, head, human"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-musical-notes" data-pack="ios" data-tags="sound, noise, listening, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-musical-note" data-pack="ios" data-tags="sound, noise, listening, play"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bell" data-pack="ios" data-tags="right, noise, alarm, sound, music"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-bell-outline" data-pack="ios" data-tags="right, noise, alarm, sound, music"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-mic" data-pack="ios" data-tags="sound, noise, speaker, talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-mic-outline" data-pack="ios" data-tags="sound, noise, speaker, talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-mic-off" data-pack="ios" data-tags="sound, noise, speaker, talk"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-volume-high" data-pack="ios" data-tags="sound, noise, listen, music"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-volume-low" data-pack="ios" data-tags="sound, noise, listen, music"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-play" data-pack="ios" data-tags="music, watch, arrow, right"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-play-outline" data-pack="ios" data-tags="music, watch, arrow, right"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pause" data-pack="ios" data-tags="music, break, hold, freeze"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pause-outline" data-pack="ios" data-tags="music, break, hold, freeze"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-recording" data-pack="ios" data-tags="film, tape, voicemail"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-recording-outline" data-pack="ios" data-tags="film, tape, voicemail"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-fastforward" data-pack="ios" data-tags="next, skip, jump"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-fastforward-outline" data-pack="ios" data-tags="next, skip, jump"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rewind" data-pack="ios" data-tags="music, previous, back"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rewind-outline" data-pack="ios" data-tags="music, previous, back"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-skipbackward" data-pack="ios" data-tags="music, previous"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-skipbackward-outline" data-pack="ios" data-tags="music, previous"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-skipforward" data-pack="ios" data-tags="music, next"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-skipforward-outline" data-pack="ios" data-tags="music, next"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-shuffle-strong" data-pack="ios" data-tags="music, next"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-shuffle" data-pack="ios" data-tags="music, next"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-videocam" data-pack="ios" data-tags="film, movie, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-videocam-outline" data-pack="ios" data-tags="film, movie, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-film" data-pack="ios" data-tags="film, movie, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-film-outline" data-pack="ios" data-tags="film, movie, camera"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flask" data-pack="ios" data-tags="options, mixer, liquid"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flask-outline" data-pack="ios" data-tags="options, mixer, liquid"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-lightbulb" data-pack="ios" data-tags="idea, new, bright, aha!"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-lightbulb-outline" data-pack="ios" data-tags="idea, new, bright, aha!"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-wineglass" data-pack="ios" data-tags="alcohol, drink, food, glass, drunk, cheers"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-wineglass-outline" data-pack="ios" data-tags="alcohol, drink, food, glass, drunk, cheers"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pint" data-pack="ios" data-tags="alcohol, drink, food, beer, drunk, cheers"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-pint-outline" data-pack="ios" data-tags="alcohol, drink, food, beer, drunk, cheers"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-nutrition" data-pack="ios" data-tags="health, carrot, food"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-nutrition-outline" data-pack="ios" data-tags="health, carrot, food"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flower" data-pack="ios" data-tags="nature, spring, leaf, garden"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flower-outline" data-pack="ios" data-tags="nature, spring, leaf, garden"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rose" data-pack="ios" data-tags="nature, spring, leaf, garden, flower"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rose-outline" data-pack="ios" data-tags="nature, spring, leaf, garden, flower"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paw" data-pack="ios" data-tags="nature, animal, pet, outdoor, track"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-paw-outline" data-pack="ios" data-tags="nature, animal, pet, outdoor, track"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flame" data-pack="ios" data-tags="fire, hot, burn"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-flame-outline" data-pack="ios" data-tags="fire, hot, burn"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-sunny" data-pack="ios" data-tags="weather, whether, light, sky"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-sunny-outline" data-pack="ios" data-tags="weather, whether, light, sky"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-partlysunny" data-pack="ios" data-tags="light, weather, whether, cloudy"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-partlysunny-outline" data-pack="ios" data-tags="light, weather, whether, cloudy"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloudy" data-pack="ios" data-tags="weather, whether, overcast"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloudy-outline" data-pack="ios" data-tags="weather, whether, overcast"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rainy" data-pack="ios" data-tags="whether, weather, water, cloud"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-rainy-outline" data-pack="ios" data-tags="whether, weather, water, cloud"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-thunderstorm" data-pack="ios" data-tags="whether, weather, sky, lightning, rain, cloudy, overcast, storm"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-thunderstorm-outline" data-pack="ios" data-tags="whether, weather, sky, lightning, rain, cloudy, overcast, storm"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-snowy" data-pack="ios" data-tags="cold, weather, whether, overcast"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-moon" data-pack="ios" data-tags="sky, night, dark"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-moon-outline" data-pack="ios" data-tags="sky, night, dark"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloudy-night" data-pack="ios" data-tags="weather, whether, overcast"></li>
              <li onclick="IonSetClass(this)" class="ion-ios-cloudy-night-outline" data-pack="ios" data-tags="weather, whether, overcast"></li>


              <p><!-- end iOS 7-style icons pack --></p>


              <li onclick="IonSetClass(this)" class="ion-android-arrow-up" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-forward" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-down" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-back" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropup" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropup-circle" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropright" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropright-circle" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropdown" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropdown-circle" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropleft" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-arrow-dropleft-circle" data-pack="android" data-tags="chevron, navigation"></li>
              <li onclick="IonSetClass(this)" class="ion-android-add" data-pack="android" data-tags="plus, include, invite"></li>
              <li onclick="IonSetClass(this)" class="ion-android-add-circle" data-pack="android" data-tags="plus, include, invite"></li>
              <li onclick="IonSetClass(this)" class="ion-android-remove" data-pack="android" data-tags="minus, subtract, delete"></li>
              <li onclick="IonSetClass(this)" class="ion-android-remove-circle" data-pack="android" data-tags="minus, subtract, delete"></li>
              <li onclick="IonSetClass(this)" class="ion-android-close" data-pack="android" data-tags="delete, remove"></li>
              <li onclick="IonSetClass(this)" class="ion-android-cancel" data-pack="android" data-tags="delete, remove"></li>
              <li onclick="IonSetClass(this)" class="ion-android-radio-button-off" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-radio-button-on" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-checkmark-circle" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-checkbox-outline-blank" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-checkbox-outline" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-checkbox-blank" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-checkbox" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-done" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-done-all" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-menu" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-more-horizontal" data-pack="android" data-tags="options, menu"></li>
              <li onclick="IonSetClass(this)" class="ion-android-more-vertical" data-pack="android" data-tags="options, menu"></li>
              <li onclick="IonSetClass(this)" class="ion-android-refresh" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-sync" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-wifi" data-pack="android" data-tags="internet,connection, bars"></li>
              <li onclick="IonSetClass(this)" class="ion-android-call" data-pack="android" data-tags="telephone"></li>
              <li onclick="IonSetClass(this)" class="ion-android-apps" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-settings" data-pack="android" data-tags="options"></li>
              <li onclick="IonSetClass(this)" class="ion-android-options" data-pack="android" data-tags="settings, mixer"></li>
              <li onclick="IonSetClass(this)" class="ion-android-funnel" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-search" data-pack="android" data-tags="magnifying glass"></li>
              <li onclick="IonSetClass(this)" class="ion-android-home" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-cloud-outline" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-cloud" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-download" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-upload" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-cloud-done" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-cloud-circle" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-favorite-outline" data-pack="android" data-tags="favorite, like, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-android-favorite" data-pack="android" data-tags="favorite, like, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-android-star-outline" data-pack="android" data-tags="favorite, like, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-android-star-half" data-pack="android" data-tags="favorite, like, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-android-star" data-pack="android" data-tags="favorite, like, rate"></li>
              <li onclick="IonSetClass(this)" class="ion-android-calendar" data-pack="android" data-tags="clock"></li>
              <li onclick="IonSetClass(this)" class="ion-android-alarm-clock" data-pack="android" data-tags="clock"></li>
              <li onclick="IonSetClass(this)" class="ion-android-time" data-pack="android" data-tags="clock"></li>
              <li onclick="IonSetClass(this)" class="ion-android-stopwatch" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-watch" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-locate" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-navigate" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-pin" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-compass" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-map" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-walk" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-bicycle" data-pack="android" data-tags="move, bike, transportation, maps"></li>
              <li onclick="IonSetClass(this)" class="ion-android-car" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-bus" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-subway" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-train" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-boat" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-plane" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-restaurant" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-bar" data-pack="android" data-tags="wine, drink, food, dinner"></li>
              <li onclick="IonSetClass(this)" class="ion-android-cart" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-camera" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-image" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-film" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-color-palette" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-create" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-mail" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-drafts" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-send" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-archive" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-delete" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-attach" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-share" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-share-alt" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-bookmark" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-document" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-clipboard" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-list" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-folder-open" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-folder" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-print" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-open" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-exit" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-contract" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-expand" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-globe" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-chat" data-pack="android" data-tags="talk, text"></li>
              <li onclick="IonSetClass(this)" class="ion-android-textsms" data-pack="android" data-tags="talk, text"></li>
              <li onclick="IonSetClass(this)" class="ion-android-hangout" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-happy" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-sad" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-person" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-people" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-person-add" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-contact" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-contacts" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-playstore" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-lock" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-unlock" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-microphone" data-pack="android" data-tags="recorder, speak, noise, music, sound"></li>
              <li onclick="IonSetClass(this)" class="ion-android-microphone-off" data-pack="android" data-tags="recorder, speak, noise, music, sound, mute"></li>
              <li onclick="IonSetClass(this)" class="ion-android-notifications-none" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-notifications" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-notifications-off" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-volume-mute" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-volume-down" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-volume-up" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-volume-off" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-hand" data-pack="android" data-tags="stop"></li>
              <li onclick="IonSetClass(this)" class="ion-android-desktop" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-laptop" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-phone-portrait" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-phone-landscape" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-bulb" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-sunny" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-alert" data-pack="android" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-android-warning" data-pack="android" data-tags=""></li>


              <p>
              <!--

              End Android-style icons pack.

              Android-style icons originally built by Google’s [Material Design Icons](https://github.com/google/material-design-icons), used under [CC BY](http://creativecommons.org/licenses/by/4.0/) / Modified icons to fit ionicon’s grid from original.

              -->
              </p>


              <li onclick="IonSetClass(this)" class="ion-social-twitter" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-twitter-outline" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-facebook" data-pack="social" data-tags="like, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-facebook-outline" data-pack="social" data-tags="like, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-googleplus" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-googleplus-outline" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-google" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-google-outline" data-pack="social" data-tags="follow, post, share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-dribbble" data-pack="social" data-tags="design"></li>
              <li onclick="IonSetClass(this)" class="ion-social-dribbble-outline" data-pack="social" data-tags="design"></li>
              <li onclick="IonSetClass(this)" class="ion-social-octocat" data-pack="social" data-tags="code, github, fork, merge, clone"></li>
              <li onclick="IonSetClass(this)" class="ion-social-github" data-pack="social" data-tags="code, fork, merge, clone"></li>
              <li onclick="IonSetClass(this)" class="ion-social-github-outline" data-pack="social" data-tags="code, fork, merge, clone"></li>
              <li onclick="IonSetClass(this)" class="ion-social-instagram" data-pack="social" data-tags="photo, camera, facebook"></li>
              <li onclick="IonSetClass(this)" class="ion-social-instagram-outline" data-pack="social" data-tags="photo, camera, facebook"></li>
              <li onclick="IonSetClass(this)" class="ion-social-whatsapp" data-pack="social" data-tags="text, sharing, private, facebook"></li>
              <li onclick="IonSetClass(this)" class="ion-social-whatsapp-outline" data-pack="social" data-tags="text, sharing, private, facebook"></li>
              <li onclick="IonSetClass(this)" class="ion-social-snapchat" data-pack="social" data-tags="photos, app"></li>
              <li onclick="IonSetClass(this)" class="ion-social-snapchat-outline" data-pack="social" data-tags="photos, app"></li>
              <li onclick="IonSetClass(this)" class="ion-social-foursquare" data-pack="social" data-tags="checkin"></li>
              <li onclick="IonSetClass(this)" class="ion-social-foursquare-outline" data-pack="social" data-tags="checkin"></li>
              <li onclick="IonSetClass(this)" class="ion-social-pinterest" data-pack="social" data-tags="social"></li>
              <li onclick="IonSetClass(this)" class="ion-social-pinterest-outline" data-pack="social" data-tags="social"></li>
              <li onclick="IonSetClass(this)" class="ion-social-rss" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-rss-outline" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-tumblr" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-tumblr-outline" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-wordpress" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-wordpress-outline" data-pack="social" data-tags="blogging"></li>
              <li onclick="IonSetClass(this)" class="ion-social-reddit" data-pack="social" data-tags="news, upvotes, karma"></li>
              <li onclick="IonSetClass(this)" class="ion-social-reddit-outline" data-pack="social" data-tags="news, upvotes, karma"></li>
              <li onclick="IonSetClass(this)" class="ion-social-hackernews" data-pack="social" data-tags="discuss, upvotes, karma"></li>
              <li onclick="IonSetClass(this)" class="ion-social-hackernews-outline" data-pack="social" data-tags="discuss, upvotes, karma"></li>
              <li onclick="IonSetClass(this)" class="ion-social-designernews" data-pack="social" data-tags="design, post"></li>
              <li onclick="IonSetClass(this)" class="ion-social-designernews-outline" data-pack="social" data-tags="design, post"></li>
              <li onclick="IonSetClass(this)" class="ion-social-yahoo" data-pack="social" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-social-yahoo-outline" data-pack="social" data-tags=""></li>
              <li onclick="IonSetClass(this)" class="ion-social-buffer" data-pack="social" data-tags="share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-buffer-outline" data-pack="social" data-tags="share"></li>
              <li onclick="IonSetClass(this)" class="ion-social-skype" data-pack="social" data-tags="call"></li>
              <li onclick="IonSetClass(this)" class="ion-social-skype-outline" data-pack="social" data-tags="call"></li>
              <li onclick="IonSetClass(this)" class="ion-social-linkedin" data-pack="social" data-tags="connect"></li>
              <li onclick="IonSetClass(this)" class="ion-social-linkedin-outline" data-pack="social" data-tags="connect"></li>
              <li onclick="IonSetClass(this)" class="ion-social-vimeo" data-pack="social" data-tags="video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-vimeo-outline" data-pack="social" data-tags="video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-twitch" data-pack="social" data-tags="gaming, games, live, streaming, video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-twitch-outline" data-pack="social" data-tags="gaming, games, live, streaming, video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-youtube" data-pack="social" data-tags="video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-youtube-outline" data-pack="social" data-tags="video, watch, share, view"></li>
              <li onclick="IonSetClass(this)" class="ion-social-dropbox" data-pack="social" data-tags="upload"></li>
              <li onclick="IonSetClass(this)" class="ion-social-dropbox-outline" data-pack="social" data-tags="upload"></li>
              <li onclick="IonSetClass(this)" class="ion-social-apple" data-pack="social" data-tags="mac, mobile"></li>
              <li onclick="IonSetClass(this)" class="ion-social-apple-outline" data-pack="social" data-tags="mac, mobile"></li>
              <li onclick="IonSetClass(this)" class="ion-social-android" data-pack="social" data-tags="mobile"></li>
              <li onclick="IonSetClass(this)" class="ion-social-android-outline" data-pack="social" data-tags="mobile"></li>
              <li onclick="IonSetClass(this)" class="ion-social-windows" data-pack="social" data-tags="pc"></li>
              <li onclick="IonSetClass(this)" class="ion-social-windows-outline" data-pack="social" data-tags="pc"></li>
              <li onclick="IonSetClass(this)" class="ion-social-html5" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-html5-outline" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-css3" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-css3-outline" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-javascript" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-javascript-outline" data-pack="social" data-tags="code, html, css, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-angular" data-pack="social" data-tags="code, mobile, js, angularjs, ionic"></li>
              <li onclick="IonSetClass(this)" class="ion-social-angular-outline" data-pack="social" data-tags="code, mobile, js, angularjs, ionic"></li>
              <li onclick="IonSetClass(this)" class="ion-social-nodejs" data-pack="social" data-tags="code, js, javascript, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-sass" data-pack="social" data-tags="code, css"></li>
              <li onclick="IonSetClass(this)" class="ion-social-python" data-pack="social" data-tags="code"></li>
              <li onclick="IonSetClass(this)" class="ion-social-chrome" data-pack="social" data-tags="code, mobile, js, angularjs, ionic"></li>
              <li onclick="IonSetClass(this)" class="ion-social-chrome-outline" data-pack="social" data-tags="code, mobile, js, angularjs, ionic"></li>
              <li onclick="IonSetClass(this)" class="ion-social-codepen" data-pack="social" data-tags="testing, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-codepen-outline" data-pack="social" data-tags="testing, js, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-markdown" data-pack="social" data-tags="code, testing, text, developer"></li>
              <li onclick="IonSetClass(this)" class="ion-social-tux" data-pack="social" data-tags="code, linux, opensource"></li>
              <li onclick="IonSetClass(this)" class="ion-social-freebsd-devil" data-pack="social" data-tags="code, opensource, unix"></li>
              <li onclick="IonSetClass(this)" class="ion-social-usd" data-pack="social" data-tags="currency, trade, money, cash"></li>
              <li onclick="IonSetClass(this)" class="ion-social-usd-outline" data-pack="social" data-tags="currency, trade, money, cash"></li>
              <li onclick="IonSetClass(this)" class="ion-social-bitcoin" data-pack="social" data-tags="currency, trade, money"></li>
              <li onclick="IonSetClass(this)" class="ion-social-bitcoin-outline" data-pack="social" data-tags="currency, trade, money"></li>
              <li onclick="IonSetClass(this)" class="ion-social-yen" data-pack="social" data-tags="currency, trade, money, japanese"></li>
              <li onclick="IonSetClass(this)" class="ion-social-yen-outline" data-pack="social" data-tags="currency, trade, money, japanese"></li>
              <li onclick="IonSetClass(this)" class="ion-social-euro" data-pack="social" data-tags="currency, trade, money, europe"></li>
              <li onclick="IonSetClass(this)" class="ion-social-euro-outline" data-pack="social" data-tags="currency, trade, money, europe"></li>
            </ul>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>


