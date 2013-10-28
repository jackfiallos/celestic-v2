<?php
$activity = $this->getActivity();
?>
<section class="form paneltab">
	<header class="paneltab-heading last-comments">
		<h5>
			<i class="icon-comments"></i>
			<?php echo $this->title; ?>
		</h5>
	</header>
	<div class="paneltab-body mxscroll" style="background: #fff;">
		<?php foreach($activity as $comment): ?>
		<article class="media">
			<a class="pull-left p-thumb">
				<?php 
					$this->widget('application.extensions.VGGravatarWidget.VGGravatarWidget', 
						array(
							'email' => CHtml::encode(Yii::app()->user->getState('user_email')),
							'hashed' => false,
							'default' => 'http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl.'/images/bg-avatar.png',
							'size' => 50,
							'rating' => 'PG',
							'htmlOptions' => array('class'=>'borderCaption','alt'=>'Gravatar Icon' ),
						)
					);
				?>
			</a>
			<div class="media-body">
				<a class="cmt-head" href="#">
					<?php echo CHtml::link(ECHtml::word_split($comment->comment_text,$this->lineLenght)."...", Yii::app()->createUrl($comment->Module->module_name."/view",array("id"=>$comment->comment_resourceid,'#'=>'comment-'.$comment->comment_id))); ?>
				</a>
				<p>
					<?php echo ECHtml::word_split($this->findModuleTitle($comment->Module->module_className, $comment->Module->module_title, $comment->comment_resourceid),5)."... "; ?>
					<br /><i class="icon-time"></i> 
					<span class="label"><?php echo "<abbr class=\"timeago\" title=\"".CHtml::encode($comment->comment_date)."\">".CHtml::encode(Yii::app()->dateFormatter->format('dd.MM.yyyy', $comment->comment_date))."</abbr>"; ?></span>
				</p>
			</div>
		</article>
		<?php endforeach; ?>
	</div>
</section>