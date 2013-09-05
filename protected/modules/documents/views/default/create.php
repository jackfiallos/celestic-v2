<article class="data-block">
	<header>
		<h1>
			<?php echo Yii::t('documents', 'CreateDocuments'); ?>
		</h1>
		<div class="data-header-actions">
			<?php echo CHtml::link(Yii::t('documents', 'ListDocuments'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'button primary', 'ng-click'=>'showHome()')); ?>
		</div>
	</header>
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</article>