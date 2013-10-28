<?php
/**
 * ListLogs class file
 * 
 * @author		Jackfiallos
 * @link		http://jackfiallos.com
 * @description
 *
 * @property int $moduleid
 * @property boolean $userExtended
 * @property array $htmlOptions
 *
 **/ 

class ListLogs extends CWidget
{
	public $moduleid;
	public $userExtended;
	public $htmlOptions;
	public $title = 'Announcements';

	/**
	 * Class object initialization
	 */
    public function init()
	{
		$this->title = Yii::t('portlet', 'RecentActivityTitle');
		parent::init();
	}
 
	/**
	 * Get all project activity
	 * @param string $moduleName
	 * @return model list of log activity
	 */
    public function getActivity($moduleName)
    {
		$project_idSelected = Yii::app()->user->getState('project_selected');
		
		if (empty($project_idSelected))
		{
			$projectList = array();
			$Projects = Yii::app()->user->getProjects();
			foreach($Projects as $project)
			{
				array_push($projectList,$project->project_id);
			}
		}
		
		return Logs::model()->findActivity(
			$moduleName, 
			(!empty($project_idSelected)?array($project_idSelected):$projectList)
		);
    }
 
    public function run()
    {
		($this->userExtended) ? $this->render('ListLogsExtended') : $this->render('ListLogs');
    }
}
?>