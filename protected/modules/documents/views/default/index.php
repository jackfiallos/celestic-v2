<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('documents', 'TitleDocuments');
?>

<div ng-controller="celestic.documents.home.controller">
	<article class="data-block" ng-show="ishome">
		<header>
			<h1>
				<?php echo Yii::t('documents', 'TitleDocuments'); ?>
			</h1>
			<div class="data-header-actions">
				<?php echo CHtml::link(Yii::t('documents', 'CreateDocuments'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'button primary')); ?>
			</div>
		</header>
		<section>
			<?php if($model->ItemsCount > 0):?>
				<?php echo CHtml::link(Yii::t('documents', 'AdvancedSearch'),'#',array('class'=>'search-button')); ?>
				<span style="float:right;">
					<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/listview.png', ''), $this->createUrl('index',array('view'=>'list'))); ?>
					<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/gridview.png', ''), $this->createUrl('index',array('view'=>'grid'))); ?>
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
									'value' =>'CHtml::link($data->document_name, $this->createUrl("view", array("id"=>$data->document_id)))',
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
						No documents has been created, you want to <?php echo CHtml::link(Yii::t('documents','CreateOneDocument'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
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
</div>

<ng-view></ng-view>

<?php
$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.documents.static.js'));

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/documents.module.js', CClientScript::POS_END);
$cs->registerScript('documentsScript', "
	// Celestic.CSRF_Token = '".Yii::app()->request->csrfToken."';
");
?>