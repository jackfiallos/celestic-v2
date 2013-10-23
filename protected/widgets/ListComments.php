<?php
/**
 * ListComments class file
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 * @property int $resourceid
 * @property int $moduleid
 *
 **/ 
class ListComments extends CWidget
{
	public $resourceid;
	public $moduleid;
	public $htmlOptions;
	
	/**
	 * Get all comments from module
	 * @param string $moduleName
	 * @return model list of comments
	 */
    public function getComments($moduleName)
    {
		return Comments::model()->findComments($moduleName, $this->resourceid);
    }
	
	/**
	 * Get all files attached to comment
	 * @param int $comment_id
	 * @return model list comments with attach files
	 */
	public function getAttachments($comment_id)
	{
		return Comments::model()->findAttachments($comment_id);
	}
	
	/**
	 * Render the main content of the portlet
	 * @return template render
	 */
    public function run()
    {
        $this->render('ListComments');
    }
}
?>