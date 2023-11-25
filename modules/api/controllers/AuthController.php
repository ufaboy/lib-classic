<?php

namespace app\modules\api\controllers;

use app\modules\api\models\User;
use Yii;
use yii\filters\Cors;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\Response;
use app\modules\api\models\LoginForm;
use app\models\SignupForm;

class AuthController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		$behaviors = parent::behaviors();

		// remove authentication filter
		$auth = $behaviors['authenticator'];
		unset($behaviors['authenticator']);

		$behaviors['corsFilter'] = [
			'class' => Cors::class,
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		return $behaviors;
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionLogin() {
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post(), '')) {
			$login = $model->login();
			$id = Yii::$app->user->getId();
			$user = User::findOne($id);
			if ($user) {
				return [
					'username' => $user->username,
					'role' => $user->role,
					'token' => $user->getToken()
				];
			}
		}
		Yii::$app->response->setStatusCode(401, 'invalid cred');
		throw new BadRequestHttpException('invalid username or password');
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup() {
		$model = new SignupForm();
		/*		if ($model->load(Yii::$app->request->post()) && $model->signup()) {
					Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
					return $this->goHome();
				}*/

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	/**
	 * @throws \Exception
	 */
	public function actionChallenge() {
		$session = Yii::$app->session;
		$challenge = base64_encode(random_bytes(32));
		$session->set('challenge', $challenge);
		return $challenge;
	}
	public function actionSignin() {
		$session = Yii::$app->session;
		return $session['challenge'];
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
