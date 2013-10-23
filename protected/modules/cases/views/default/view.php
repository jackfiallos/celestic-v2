<article class="widget widget-4 data-block cases">
	<header class="widget-head">
		<h3 class="module-title">
			<i class="icon-gear icon-2"></i>
			{{case.case_name}}
		</h3>
		<div class="data-header-actions">
			<?php echo CHtml::link("<i class=\"icon-list\"></i>", $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn btn-primary', 'ng-click'=>'showHome()', 'title'=>Yii::t('cases', 'ListCases'))); ?>
			<?php if (Yii::app()->user->IsManager): ?>
				<?php echo CHtml::link("<i class=\"icon-edit\"></i>", '', array('class'=>'btn btn-primary', 'ng-hide'=>'casesForm', 'ng-click'=>'showUpdate()', 'title'=>Yii::t('cases', 'UpdateCases'))); ?>
			<?php endif; ?>
		</div>
	</header>
	<section class="widget-body">
		<!-- form -->
		<div ng-hide="casesForm">
			<div class="ddescription" ng-bind-html-unsafe="case.case_description"></div>
		</div>
		<hr />
		Secuences:<br />
		<section class="paneltab">
              <header class="paneltab-heading tab-bg-dark-navy-blue ">
                  <ul class="nav nav-tabs">
                      <li class="active">
                          <a data-toggle="tab" href="#normal">Normal</a>
                      </li>
                      <li class="">
                          <a data-toggle="tab" href="#alternative">Alternative</a>
                      </li>
                      <li class="">
                          <a data-toggle="tab" href="#exceptions">Exceptions</a>
                      </li>
                  </ul>
              </header>
              <div class="panel-body">
                  <div class="tab-content">
                      <div id="normal" class="active tab-pane">Normal</div>
                      <div id="alternative" class="tab-pane">Alternative</div>
                      <div id="exceptions" class="tab-pane">Exceptions</div>
                  </div>
              </div>
          </section>
		Validations:<br />
		<hr />
		<h4>Tasks List</h4>
		<div class="input-append">
			<input type="text" class="" placeholder="Filter Search" ng-model="search">
			<i class="add-on icon-search"></i>
		</div>
		<br />
		Filter by: 
		<?php foreach($status as $item): ?>
			<span class="showpointer label label-<?php echo strtolower(str_replace(" ", "", $item->status_name)); ?>" ng-click="status='<?php echo $item->status_name; ?>'">
				<?php echo $item->status_name; ?>
			</span>
		<?php endforeach; ?>
		<span class="label" ng-click="status=''" style="cursor:pointer">
			All
		</span>
		<hr />
		<ul class="tickets">
			<li class="ticket" ng-repeat="task in case.tasks | filter:status||search">
				<a href="{{task.task_url}}">
					<span class="header">
						<span class="title">{{task.task_name}}</span>
					</span>
					<div class="row-fluid">
						<div class="span6">
							<div>By {{task.user}}</div>
							<div class="label {{task.task_priority_class}}">
								{{task.task_priority}}
							</div>
						</div>
						<div class="span6" style="text-align:right">
							<div class="text-muted">Status: <span class="blue label {{task.class_status}}">{{task.status}}</span></div>
							<div>{{task.task_startDate}}</div>
						</div>
					</span>	                                                        
				</a>
			</li>
		</ul>
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