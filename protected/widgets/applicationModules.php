<?php
/**
 * modules class file
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 * @property array $htmlOptions
 * @property array $modules
 *
 **/  
class applicationModules extends CWidget
{
	public $htmlOptions;
	public $modules;

	/**
	 * [init description]
	 * @return [type] [description]
	 */
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