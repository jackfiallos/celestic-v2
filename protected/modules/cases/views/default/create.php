<article class="data-block cases">
	<header>
		<h1>
			<?php echo Yii::t('cases', 'CreateCases'); ?>
		</h1>
		<div class="data-header-actions">
			<?php echo CHtml::link(Yii::t('cases', 'ListCases'), $this->createUrl('index', array('#'=>'/home')),array('class'=>'button primary')); ?>
		</div>
	</header>
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</article>