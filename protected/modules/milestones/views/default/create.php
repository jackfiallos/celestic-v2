<article class="data-block milestones">
	<header>
		<h1>
			<?php echo Yii::t('milestones', 'CreateMilestones'); ?>
		</h1>
		<div class="data-header-actions">
			<?php echo CHtml::link(Yii::t('milestones', 'ListMilestones'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'button primary', 'ng-click'=>'showHome()')); ?>
		</div>
	</header>
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model, 'users'=>$users)); ?>
	</section>
</article>