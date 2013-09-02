<ul>
	<li class="heading">
		<span>Modules</span>
	</li>
	<li class="glyphicons home <?php echo (!isset(Yii::app()->controller->module->id)) ? 'active' : ''; ?>">
		<a href="<?php echo Yii::app()->createUrl('site/index'); ?>">
			<i></i><span>Dashboard</span>
		</a>
	</li>
	<li class="glyphicons book projectlnk">
		<a href="<?php echo Yii::app()->createUrl('site/projects'); ?>">
			<i></i><span>Projects</span>
		</a>
		<div class="projectlist">
			<?php foreach(Yii::app()->user->getProjects() as $project): ?>
				<a href="<?php echo Yii::app()->createUrl('site/index', array('infoproject'=>$project->project_id)); ?>"><?php echo $project->project_name; ?></a>
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
						echo "<li class=\"glyphicons ".$active." ".Yii::app()->params['modules'][$module]['iconClass']."\"><a href=\"".Yii::app()->createUrl($module)."\"><i></i><span>".Yii::app()->params['modules'][$module]['title']."</span></a></li>";
					}
				}
			}
		}
	?>
	<li class="glyphicons logout"><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><i></i><span>Logout</span></a></li>
</ul>