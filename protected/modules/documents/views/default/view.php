<article class="data-block documents">
	<header>
		<h3>
			{{document_name}}
		</h3>
		<div class="data-header-actions">
			<?php echo CHtml::link("<i class=\"icon-list\"></i> ".Yii::t('documents', 'ListDocuments'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn', 'ng-click'=>'showHome()')); ?>
			<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('documents', 'CreateDocuments'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn')); ?>
		</div>
	</header>
	<section>
		<div>
			<span>
				<img src="" />
			</span>
			<div class="ddescription">{{document_description}}</div>
			<div class="dfooter">
				Uploaded by <a href="{{userUrl}}">{{userName}}</a> - 
				<span>{{document_uploadDate}}</span>
				<div class="pull-right">
					<a href="{{document_download}}">
						<?php echo Yii::t("documents","downloadFile"); ?>
					</a>
				</div>
			</div>
		</div>
		<hr />
		<div class="result">
			<?php $this->widget('widgets.ListComments',array(
				'resourceid'=>4,
				'moduleid'=>7,
			)); ?>
		</div>
	</section>
</article>