<?php

namespace app\controllers;

use app\models\Upload;
use Yii;
use yii\rest\Controller;
use yii\web\UploadedFile;

class UploadController extends Controller {
	public function behaviors(): array {
		$behaviors = parent::behaviors();
		return $behaviors;
	}

	public function actionIndex() {
		$query = Yii::$app->request->queryParams;
		$model = new Upload();

		if (Yii::$app->request->isPost) {
			$model->load($query, '');
			$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
			return $model->upload();
		} return false;
	}
}
