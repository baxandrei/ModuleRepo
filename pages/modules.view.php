<!DOCTYPE html>
<html lang="<?php echo (defined('HTML_LANG') ? HTML_LANG : 'en'); ?>" <?php if(defined('HTML_RTL') && HTML_RTL === true) echo ' dir="rtl"'; ?>>
  <head>
    <!-- Standard Meta -->
    <meta charset="<?php echo (defined('LANG_CHARSET') ? LANG_CHARSET : 'utf-8'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<?php
	$title = $language->get('admin', 'admin_cp');
	require(ROOT_PATH . '/core/templates/admin_header.php');
	?>

  </head>
  <body>
    <?php require(ROOT_PATH . '/modules/Core/pages/admin/navbar.php'); ?>
	<div class="container">
	  <div class="row">
	    <div class="col-md-3">
		  <?php require(ROOT_PATH . '/modules/Core/pages/admin/sidebar.php'); ?>
		</div>
		<div class="col-md-9">
		  <div class="card">
		    <div class="card-block">
			  <h3 style="display:inline;"><?php echo $language->get('admin', 'modules'); ?></h3>
			  <span class="pull-right">
			    <a class="btn btn-secondary" href="<?php echo URL::build('/admin/modulerepo/'); ?>"><?php echo $modulerepo_language->get('language', 'install_via_modulerepo'); ?></a>
			    <a class="btn btn-primary" href="<?php echo URL::build('/admin/modules/', 'action=install'); ?>"><?php echo $language->get('admin', 'install'); ?></a>
			  </span>
			  <br />
			  <hr />
			  <?php
			  if(Session::exists('admin_modules')){
				  echo Session::flash('admin_modules');
			  }

			  // Get all modules
			  $modules = $queries->getWhere('modules', array('id', '<>', 0));

			  foreach($modules as $module){
				  if(isset($module_author)) unset($module_author);
				  if(isset($module_version)) unset($module_version);
				  if(isset($nameless_version)) unset($nameless_version);

				  if(file_exists(ROOT_PATH . '/modules/' . $module->name . '/module.php')) require(ROOT_PATH . '/modules/' . $module->name . '/module.php');
			  ?>
			  <div class="row">
			    <div class="col-md-9">
			      <strong><?php if (file_exists(ROOT_PATH . '/modules/' . $module->name . '/modulerepo.json')) {
			          echo '<span class="label label-warning"><i class="fa fa-check-square" data-container="body" data-toggle="popover" data-placement="top" title="' . $modulerepo_language->get('language', 'modulerepo_title') . '" data-content="' . str_replace(array('{x}', '{x2}'), array(Output::getClean($nl_template_version), NAMELESS_VERSION), $modulerepo_language->get('language', 'installed_with_modulerepo')) . '"></i></span> ';
			      } ?><?php echo htmlspecialchars($module->name); ?></strong> <?php if(isset($module_version)){ ?><small><?php echo $module_version; ?></small><?php } ?>
				  <?php if(isset($module_author)){ ?></br><small><?php echo $language->get('admin', 'author'); ?> <?php echo $module_author; ?></small><?php } ?>
				</div>
				<div class="col-md-3">
				  <span class="pull-right">
				    <?php
					if($module->id == 1){
					?>
				    <a href="#" class="btn btn-info disabled"><i class="fa fa-lock" aria-hidden="true"></i></a>
					<!--<a href="<?php //echo URL::build('/admin/modules/', 'action=edit&m=' . $module->id); ?>" class="btn btn-primary"><i class="fa fa-cogs" aria-hidden="true"></i></a>-->
					<?php
					} else {
						if($module->enabled == 1){
					?>
					<a href="<?php echo URL::build('/admin/modules/', 'action=disable&m=' . $module->id); ?>" class="btn btn-warning"><?php echo $language->get('admin', 'disable'); ?></a>
					<!--<a href="<?php //echo URL::build('/admin/modules/', 'action=edit&m=' . $module->id); ?>" class="btn btn-primary"><i class="fa fa-cogs" aria-hidden="true"></i></a>-->
					<?php
						} else {
					?>
					<?php if (file_exists(ROOT_PATH . '/modules/' . $module->name . '/modulerepo.json')) { ?>
			        <a href="<?php echo URL::build('/admin/modules/', 'action=delete&m=' . $module->id); ?>" class="btn btn-danger"><?php echo $modulerepo_language->get('language', 'delete'); ?></a>
			        <?php } ?>
					<a href="<?php echo URL::build('/admin/modules/', 'action=enable&m=' . $module->id); ?>" class="btn btn-success"><?php echo $language->get('admin', 'enable'); ?></a>
					<?php
						}
					}
					?>
				  </span>
				</div>
			  </div>
			  <hr />
			  <?php
			  }
			  ?>
		    </div>
		  </div>
		</div>
	  </div>
    </div>

		<?php require(ROOT_PATH . '/modules/Core/pages/admin/footer.php'); ?>

    <?php require(ROOT_PATH . '/modules/Core/pages/admin/scripts.php'); ?>

  </body>
</html>