<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\modules\api\models\Book;
use app\modules\api\models\BookSearch;
use app\modules\api\models\Upload;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller {
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
	 * Lists all Book models.
	 *
	 * @return \yii\data\ActiveDataProvider
	 */
	public function actionIndex() {
		$searchModel = new BookSearch();
		return $searchModel->search($this->request->queryParams);
	}

	/**
	 * @throws NotFoundHttpException
	 */
	public function actionView($id): Book|array {
		$book = $this->findModel($id);
		if ($book) {
			/*			if (\Yii::$app->user->identity->role !== 'librarian') {
							Yii::$app->response->setStatusCode(403);
							return ['message' => 'You do not have permissions', 'errors' => $book->getErrors()];
						}*/
			$book->updateCounters(['view_count' => 1]);
			$book->touch('last_read');
			return $book;
		}
		Yii::$app->response->setStatusCode(500);
		return ['message' => 'The requested book does not exist', 'errors' => $book->getErrors()];
	}

	/**
	 * Creates a new Book model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return array|Book
	 */
	public function actionCreate(): Book|array {
		$model = new Book();
		$params = Yii::$app->request->bodyParams;
		$upload = new Upload();
		$upload->imageFiles = UploadedFile::getInstances($upload, 'imageFiles');
		if ($model->load($params, '') && $model->save(false)) {
			$upload->book_id = $model->id;
			$upload->upload();
			return $model;
		}
		Yii::$app->response->setStatusCode(500);
		return ['message' => 'Failed to update book', 'errors' => $model->getErrors()];
	}

	/**
	 * Updates an existing Book model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return array | Book
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		$params = Yii::$app->request->bodyParams;
		$model = $this->findModel($id);
		$upload = new Upload();
//		Yii::debug(VarDumper::dumpAsString(UploadedFile::getInstances($upload, 'imageFiles')));
		$upload->imageFiles = UploadedFile::getInstances($upload, 'imageFiles');
		if ($model->load($params, '') && $model->save(false)) {
			$upload->book_id = $model->id;
			$upload->upload();
			return $model;
		}
		Yii::$app->response->setStatusCode(500);
		return ['message' => 'Failed to update book', 'errors' => $model->getErrors()];
	}

	/**
	 * Deletes an existing Book model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return false|int
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		return $this->findModel($id)->delete();
	}

	/**
	 * Finds the Book model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Book the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Book::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');


/*		protected function handlePostSave(Book $model)
		{
			if ($model->load(Yii::$app->request->post())) {
				$upload = new Upload();
				$upload->imageFiles = UploadedFile::getInstance($model, 'upload');

				if ($model->validate()) {
					if ($model->upload) {
						$filePath = 'uploads/' . $model->upload->baseName . '.' . $model->upload->extension;
						if ($model->upload->saveAs($filePath)) {
							$model->image = $filePath;
						}
					}

					if ($model->save(false)) {
						$upload->book_id = $model->id;
						$upload->upload();
					}
						return $model;
					}
				}
			}*/
		}
}
