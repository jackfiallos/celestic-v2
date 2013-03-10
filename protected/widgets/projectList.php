<?php
/**
 * projectList class file
 * 
 * @author		Jackfiallos
 * @link		http://jackfiallos.com
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
