<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Image;

class Upload extends Model {
	/**
	 * @var UploadedFile[]
	 */
	public $imageFiles;

	public $book_id;
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['book_id'], 'safe'],
			[['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, webp, webm, mp4', 'maxFiles' => 200],
		];
	}

	/**
	 * @throws Exception
	 */
	public function upload() {
		if ($this->validate()) {
			$imageArray = [];
			$fileDir = 'book_' . str_pad($this->book_id, 3, "0", STR_PAD_LEFT);
			$pathDir = Yii::getAlias('@app') . '/storage/media/' . $fileDir;
			if (!is_dir($pathDir)) {
				FileHelper::createDirectory($pathDir);
			}
			foreach ($this->imageFiles as $file) {
				$model = $this->findOrCreateMedia($this->book_id, $file->name);
				$file->saveAs($pathDir . '/' . $file->name);
				$model->file_name = $file->name;
				$model->path = 'media/' . $fileDir;
				$model->book_id = $this->book_id;
				if ($model->save()) {
					$imageArray[] = $model;
				} else {
					Yii::debug($model);
				}
			}
			return $imageArray;
		} else {
			Yii::debug('validate error');
			return $this->getErrors();
		}
	}

	protected function findOrCreateMedia($book_id, $filename) {
		if (($model = Image::findOne(['book_id' => $book_id, 'file_name' => $filename])) !== null) {
			return $model;
		} else {
			return new Image();
		}
	}
}
