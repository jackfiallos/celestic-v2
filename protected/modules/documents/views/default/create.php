<article class="data-block documents">
	<header>
		<h1>
			<?php echo Yii::t('documents', 'CreateDocuments'); ?>
		</h1>
		<div class="data-header-actions">
			<?php echo CHtml::link("<i class=\"icon-list\"></i> ".Yii::t('documents', 'ListDocuments'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn', 'ng-click'=>'showHome()')); ?>
		</div>
	</header>
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</article>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/bootstrap-filestyle.min.js', CClientScript::POS_END);
?>