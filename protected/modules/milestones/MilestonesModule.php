<?php
/**
 *
 * MilestonesModule
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 */
class MilestonesModule extends CWebModule
{
	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'milestones.models.*',
			'milestones.components.*',
		));
	}

	/**
	 * [beforeControllerAction description]
	 * @param  [type] $controller [description]
	 * @param  [type] $action     [description]
	 * @return [type]             [description]
	 */
	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
