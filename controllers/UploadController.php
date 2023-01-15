<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use app\models\Upload;
use app\models\UploadSingle;
use app\models\Image;
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
				return Image::findAll(['book_id' => $model->book_id]);
			} else return $result;

		} return false;
	}
	public function actionSingle($id) {
		$model = new UploadSingle();

		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstanceByName('imageFile');;
			return $model->upload($id);
		} return false;
	}
}
