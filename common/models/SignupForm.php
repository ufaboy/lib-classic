<?php

namespace app\common\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model {
	public $username;
	public $password;

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			['username', 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['password', 'required'],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return bool whether the creating new account was successful
	 */
	public function signup(): ?bool {
		if (!$this->validate()) {
			return null;
		}

		$user = new User();
		$user->username = $this->username;
		$user->setPassword($this->password);
		$user->generateAuthKey();

		return $user->save();
	}
}