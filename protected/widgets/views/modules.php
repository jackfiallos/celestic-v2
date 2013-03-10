<ul>
	<li class="heading"><span>Modules</span></li>
	<li class="glyphicons home active">
		<a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>">
			<i></i><span>Dashboard</span>
		</a>
	</li>
	<?php
	foreach($this->modules as $SystemModules)
	{
		$string = $SystemModules['class'];
		$pos = strripos($string, ".");
		$module = substr($string, 0, $pos);
		if(array_key_exists($module, Yii::app()->params['modules']))
			echo "<li class=\"glyphicons ".Yii::app()->params['modules'][$module]['iconClass']."\"><a href=\"".Yii::app()->createUrl($module)."\"><i></i><span>".Yii::app()->params['modules'][$module]['title']."</span></a></li>";
	}
	?>
	<li class="glyphicons logout"><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><i></i><span>Logout</span></a></li>
</ul>