<?php

namespace app\controllers;


use Yii;
use yii\rest\Controller;
use app\models\Upload;
use app\models\Media;
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
			$result = $model->upload();
			if ($result) {
				return Media::findAll(['book_id' => $model->book_id]);
			} else return $result;

		} return false;
	}
}
