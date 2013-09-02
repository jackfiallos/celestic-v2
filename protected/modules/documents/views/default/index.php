<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	Yii::t('documents', 'TitleDocuments'),
);
$this->pageTitle = Yii::app()->name." - ".Yii::t('documents', 'TitleDocuments');
?>

<article class="data-block">
	<header>
		<h1>
			<?php echo Yii::t('documents', 'TitleDocuments'); ?>
		</h1>
		<div class="data-header-actions">
			<?php echo CHtml::link(Yii::t('documents', 'CreateDocuments'), Yii::app()->controller->createUrl('create'), array('class'=>'button primary')); ?>
		</div>
	</header>
	<section>
		<?php if($model->ItemsCount > 0):?>
			<?php echo CHtml::link(Yii::t('documents', 'AdvancedSearch'),'#',array('class'=>'search-button')); ?>
			<span style="float:right;">
				<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/listview.png', ''), Yii::app()->controller->createUrl('index',array('view'=>'list'))); ?>
				<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/gridview.png', ''), Yii::app()->controller->createUrl('index',array('view'=>'grid'))); ?>
			</span>
			<div class="search-form corners" style="display:none;">
			<?php
				$this->renderPartial('_search',array(
					'model'=>$model,
				));
			?>
			</div>
			<?php
				if (Yii::app()->user->getState('view') == 'grid')
				{
					$this->widget('zii.widgets.grid.CGridView', array(
						'dataProvider'=>$model->search(),
						'id'=>'document-grid',
						'cssFile'=>'css/screen.css',
						'summaryText'=>Yii::t('site','summaryText'),
						'emptyText'=>Yii::t('site','emptyText'),
						'columns'=>array(
							array(
								'name'=>'document_name',
								'type'=>'raw',
								'value' =>'CHtml::link($data->document_name, Yii::app()->createUrl("documents/view", array("id"=>$data->document_id)))',
							),
							array(
								'name'=>'document_description',
								'type'=>'raw',
								'value'=>'Yii::app()->format->html(nl2br(ECHtml::createLinkFromString(CHtml::encode($data->document_description))))',
							),
						),
					));
				}
				else
				{
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$model->search(),
						'itemView'=>'_view',
						'summaryText'=>Yii::t('site','summaryText'),
					));
				}
			?>
		<?php else: ?>
			<div class="aboutModule">
				<p class="aboutModuleTitle">
					No documents has been created, you want to <?php echo CHtml::link(Yii::t('documents','CreateOneDocument'), Yii::app()->controller->createUrl('create')); ?> ?
				</p>
				<div class="aboutModuleInformation shadow corners">
					<h3 class="aboutModuleInformationBoxTitle">
						<?php echo Yii::t('documents','AboutDocuments'); ?>
					</h3>
					<ul class="aboutModuleInformationList">
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l1'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l1'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l2'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l2'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l3'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l3'); ?></span>
						</li>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	</section>
</article>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
");
?>