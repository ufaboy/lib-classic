<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Storage;

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
			[['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, webp', 'maxFiles' => 99],
		];
	}

	public function upload() {
		if ($this->validate()) {
			$imageArray = [];
			$fileDir = 'book_' . $this->book_id;
			$pathDir = Yii::getAlias('@app') . '/storage/media/' . $fileDir;
			if (!is_dir($pathDir)) {
				FileHelper::createDirectory($pathDir);
			}
			foreach ($this->imageFiles as $file) {
				$model = $this->findOrCreateStorage($this->book_id, $file->baseName);
				$filename = $file->baseName . '.' . $file->extension;
				$file->saveAs($pathDir . '/' . $filename);
				$imageArray[] = ['name' => $filename, 'url' => '/media/' . $fileDir . '/' . $filename];
				$model->file_name = $file->baseName;
				$model->extension = $file->extension;
				$model->size = $file->size;
				$model->path = 'media/' . $fileDir;
				$model->book_id = $this->book_id;
				if (!$model->save()) {
					Yii::debug($model);
				}
			}
			return $imageArray;
		} else {
			Yii::debug('validate error');
			return $this->imageFiles;
		}
	}

	protected function findOrCreateStorage($book_id, $filename) {
		if (($model = Storage::findOne(['book_id' => $book_id, 'file_name' => $filename])) !== null) {
			return $model;
		} else {
			return new Storage();
		}
	}
}
