<?php
/**
 * CommentsFeed class file
 * 
 * @author		Jackfiallos
 * @link		http://jackfiallos.com
 * @description
 *
 * @property int $LineLenght
 * @property array $htmlOptions
 *
 **/ 
class CommentsFeed extends CWidget
{
	public $htmlOptions;
	public $lineLenght = 11;
	public $limit = 10;
	public $title = 'Last Comments';

	/**
	 * Class object initialization
	 */
	public function init()
	{
		$this->title = Yii::t('comments','CommentsTitle');
		parent::init();
	}
	
	public function getActivity()
    {
    	return Comments::model()->findActivity(Yii::app()->user->getState('project_selected'), $this->limit);
    }
    
    public function findModuleTitle($module, $title, $resource)
    {
		$modelClass = new $module();
		return $modelClass::model()->findByPk($resource)->$title;
    }

    public function run()
    {
		$this->render('CommentsFeed');
    }
}
?>