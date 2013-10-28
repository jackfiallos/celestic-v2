<section class="form paneltab">
	<header class="paneltab-heading announcement">
		<h5>
			<i class="icon-bullhorn"></i>
			<?php echo $this->title; ?>
		</h5>
	</header>
	<div class="paneltab-body mxscroll" style="background: #fff;">
		<?php foreach($this->getActivity($this->moduleid) as $log): ?>
			<article class="media">
				<a class="pull-left p-thumb">
					<span><?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format("dd", $log->log_date))); ?></span><br />
					<span><?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format("MM/yy", $log->log_date))); ?></span>
				</a>
				<div class="media-body">
					<?php
						$output = "";
						// Si no es comentario el enlace
						if ($log->log_commentid == 0)
						{
							// Si no es del tipo controllerConcepts
							if (strpos($log->Module->module_name, "concepts") === false)
							{
								$output .= CHtml::link(Yii::t('logs',$log->log_activity), Yii::app()->controller->createUrl($log->Module->module_name."/view",array("id"=>$log->log_resourceid))) . " ".Yii::t('site','by')." ";
							}
							else
							{
								$output .= CHtml::link(Yii::t('logs',$log->log_activity), Yii::app()->controller->createUrl($log->Module->module_name."/index",array("owner"=>$log->log_resourceid))) . " ".Yii::t('site','by')." ";
							}
						}
						else
						{
							$output .= CHtml::link(Yii::t('logs',$log->log_activity), Yii::app()->controller->createUrl($log->Module->module_name."/view",array("id"=>$log->log_resourceid,"#"=>"comment-".$log->log_commentid))) . " ".Yii::t('site','by')." ";
						}
						
						$output .= CHtml::link(CHtml::encode($log->User->completeName), Yii::app()->controller->createUrl("users/view",array("id"=>$log->User->user_id)))." ";
						
						if (strpos($log->Module->module_name, "concepts") === false)
						{
							$output .= " ".Yii::t('logs','in')." ".CHtml::link(ECHtml::word_split($log->getTitleFromLogItem($log->log_resourceid, $log->Module->module_className, $log->Module->module_title),8), Yii::app()->controller->createUrl($log->Module->module_name."/view",array("id"=>$log->log_resourceid)))."&nbsp;";
						}
						else
						{
							$output .= " ".Yii::t('logs','in')." ".CHtml::link(ECHtml::word_split($log->getTitleFromLogItem($log->log_resourceid, $log->Module->module_className, $log->Module->module_title),8), Yii::app()->controller->createUrl($log->Module->module_name."/index",array("owner"=>$log->log_resourceid)))."&nbsp;";
						}

						echo $output;
					?>
					</a>
					<p>
						<?php echo "<span class=\"label pull-right\"><abbr class=\"timeago\" title=\"".CHtml::encode($log->log_date)."\">".CHtml::encode(Yii::app()->dateFormatter->format('dd.MM.yyyy', $log->log_date))."</abbr></span>"; ?>
					</p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>