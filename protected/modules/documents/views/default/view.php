<article class="data-block documents">
	<header>
		<h3>
			{{document.name}}
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-list\"></i>", $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn btn-primary', 'ng-click'=>'showHome()', 'title'=>Yii::t('documents', 'ListDocuments'))); ?>
			</div>
			<hr />
		</h3>
	</header>
	<section>
		<div class="details">
			<figure class="media-object">
                <figcaption class="caption clearfix opensans">
                    <div class="news-date left">
                        <img class="icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/UI/calendar.png" alt="">
                        <a href="#">{{document.uploadDate}}</a>
                        <span class="author">by <a href="{{userUrl}}">{{document.userName}}</a></span>
                    </div>
                    <div class="news-comments right" ng-show="document.comments > 0">
                        <img class="icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/UI/speech-bubble-center-2.png" alt="">
                        <a href="#">{{document.comments}} Comment(s)</a>
                    </div>
                </figcaption>
            </figure>
            <span class="icontype">
				<img style="width:64px;height:64px" src="{{document.imageType}}">
			</span>
			<span class="ddescription">{{document.description}}</span>
			<div class="dfooter">
				<div>
					<img class="icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/UI/browser-download.png" alt="">
					<a href="{{document.download}}">
						<?php echo Yii::t("documents","downloadFile"); ?>
					</a>
				</div>
			</div>
		</div>
		<hr />
		<div class="result">
			<?php
			// $this->widget('widgets.ListComments',array(
			// 	'resourceid'=>4,
			// 	'moduleid'=>7,
			// ));
			?>
		</div>
	</section>
</article>