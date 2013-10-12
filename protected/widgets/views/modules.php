<ul>
	<li class="glyph home <?php echo (!isset(Yii::app()->controller->module->id)) ? 'active' : ''; ?>">
		<a href="<?php echo Yii::app()->createUrl('site'); ?>">
			<i></i>
		</a>
	</li>
	<li class="glyph projects projectlnk">
		<a href="<?php echo Yii::app()->createUrl('site/projects'); ?>">
			<i></i>
		</a>
		<div class="projectlist">
			<?php foreach(Yii::app()->user->getProjects() as $project): ?>
				<a href="<?php echo Yii::app()->createUrl('site', array('infoproject'=>$project->project_id)); ?>"><?php echo $project->project_name; ?></a>
			<?php endforeach; ?>
		</div>
	</li>
	<?php
		$selected = null;
		if (!Yii::app()->user->isGuest)
		{			
			$selected = Yii::app()->user->getState('project_selected');
			if (isset($selected))
			{
				foreach($this->modules as $SystemModules)
				{
					$string = $SystemModules['class'];
					$pos = strripos($string, ".");
					$module = substr($string, 0, $pos);
					if (array_key_exists($module, Yii::app()->params['modules']))
					{
						if (!isset(Yii::app()->controller->module->id))
						{
							$active = '';
						}
						else 
						{
							$active = ((Yii::app()->controller->module->id == $module) ? 'active' : '');
						}
						echo "<li title=\"".Yii::app()->params['modules'][$module]['title']."\" class=\"glyph ".$active." ".Yii::app()->params['modules'][$module]['iconClass']."\"><a href=\"".Yii::app()->createUrl($module.'/default/index')."\"><i></i></a></li>";
					}
				}
			}
		}
	?>
	<li class="glyph logout"><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><i></i></a></li>
</ul>