<?php

namespace app\modules\api\controllers;

use app\modules\api\models\Image;
use app\modules\api\models\ImageSearch;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
class ImageController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function behaviors() {
		$behaviors = parent::behaviors();

		// remove authentication filter
		$auth = $behaviors['authenticator'];
		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => Cors::class,
		];

		// re-add authentication filter
		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::class,
		];
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		return $behaviors;
	}

	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items',
	];

	/**
	 * Lists all Image models.
	 *
	 * @return \yii\data\ActiveDataProvider
	 */
	public function actionIndex() {
		$searchModel = new ImageSearch();
		return $searchModel->search($this->request->queryParams);
	}

	/**
	 * Displays a single Image model.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Image model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate() {
		$model = new Image();

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Image model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return Image | array
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		$data = $this->request->post();
		$model = $this->findModel($id);
//		Yii::debug(VarDumper::dumpAsString($data));
//		if ($this->request->isPost && $model->renameImage($data['file_name']) && $model->load($this->request->post(), 'Image')) {
//			return $model->save();
//		}
		if ($this->request->isPost && $model->renameImage($data['file_name']) && $model->load($data, '') && $model->save()) {
			return $model;
		}
		Yii::$app->response->setStatusCode(500);
		return ['message' => 'Failed to update image', 'errors' => $model->getErrors()];
	}

	/**
	 * Deletes an existing Image model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return false|int
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		return $this->findModel($id)->delete();
	}
	public function actionDeleteAll($bookId) {
		return Image::deleteAll(['book_id' => $bookId]);
	}

	/**
	 * Finds the Image model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Image the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Image::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
