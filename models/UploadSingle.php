<?php

namespace app\models;


use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Image;

class UploadSingle extends Model {
	/**
	 * @var UploadedFile
	 */
	public $imageFile;
	public $book_id;
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['book_id'], 'safe'],
			[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, webp'],
		];
	}

	/**
	 * @throws Exception
	 */
	public function upload($id) {
		{
			if (true) {
				Yii::debug('imagefilename: ' . $this->imageFile->name);
				$imageModel = Image::findOne($id);
				$fileDir = 'book_' . str_pad($imageModel->book_id, 3, "0", STR_PAD_LEFT);
				$pathDir = Yii::getAlias('@app') . '/storage/' . $imageModel->path;
				$this->imageFile->saveAs($pathDir . '/' . $this->imageFile->name);
				$imageModel->file_name = $this->imageFile->name;
				$imageModel->path = 'media/' . $fileDir;
				return $imageModel->save();
			} else {
				Yii::debug('image error validate');
				return false;
			}
		}
	}
}
