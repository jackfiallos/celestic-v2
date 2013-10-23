<?php
/**
 * projectList class file
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 **/
class projectList extends CWidget
{
	public $htmlOptions;
	
	/**
	 * Execute the widget
	 * @return template render
	 */
	public function run()
    {
		$this->render('projectList');
    }
}
?>
