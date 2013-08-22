<?php
/**
 * modules class file
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx
 * @description
 *
 * @property array $htmlOptions
 * @property array $modules
 *
 **/  
class modules extends CWidget
{
	public $htmlOptions;
	public $modules;

	public function init()
	{
		$this->modules = Yii::app()->modules;
	}
	
	/**
	 * Render the main content of the portlet
	 * @return template render
	 */
    public function run()
    {
        $this->render('modules');
    }
}
?>