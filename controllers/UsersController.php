<?php

namespace app\controllers;

use yii\rest\ActiveController;

class UsersController extends ActiveController
{
	public $modelClass = 'app\models\Users';

	public function actionSearch()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return [
			'message' => 'hello world',
			'code' => 100,
		];
	}
}
