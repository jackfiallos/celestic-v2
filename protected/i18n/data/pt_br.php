<?php
/**
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * Extends Locale data for 'pt_BR'.
 * In this file you can put custom locale settings that will be
 * merged with the ones provided by the framework
 * ( that are stored in <framework_dir>/i18n/data/ )
 */

return CMap::mergeArray(
	require(dirname($GLOBALS['yii']).'/i18n/data/'.basename(__FILE__)),
	array(
		'dateFormats' => array(
			'small'=>'dd/MM/yyyy',          // format used for input
			'calendar_small'=>'dd/mm/yy',   // format used for input with calendar widget
			'database'=>Yii::app()->params['database_format']['date'], // yyyy-MM-dd
		),
		'timeFormats' => array(
			'small'=>'HH:mm:ss',          // format used for input
			'database'=>Yii::app()->params['database_format']['time'], // HH:mm:ss
		)
	)
);

?>