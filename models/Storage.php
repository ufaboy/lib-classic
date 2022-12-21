<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "storage".
 *
 * @property int $id
 * @property string|null $file_name
 * @property string|null $extension
 * @property int|null $size
 * @property string|null $path
 * @property int $book_id
 *
 * @property Book $book
 */
class Storage extends ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'storage';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['size', 'book_id'], 'integer'],
			[['book_id'], 'required'],
			[['file_name', 'extension', 'path'], 'string', 'max' => 255],
			[['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'file_name' => 'File Name',
			'extension' => 'Extension',
			'size' => 'Size',
			'path' => 'Path',
			'book_id' => 'Book ID',
		];
	}

	static function getFiles() {
		$storageDir = Yii::getAlias('@app') . '/storage/media/';
		$dirs_name = array_diff(scandir($storageDir), array('..', '.'));
		$mainArray = [];
		function findFileByName($name, $array) {
			foreach ($array as $element) {
				if ($name === $element->full_name) {
					return $element->id;
				}
			}
			return null;
		}

		foreach ($dirs_name as $dirName) {
			$bookId = str_replace('book_', '', $dirName);
			$book = Book::findOne(['id' => $bookId]);
			$bookFiles = $book ? $book->files : [];

			$tempFiles = array_diff(scandir($storageDir . $dirName), array('..', '.'));
			$files = [];
			foreach ($tempFiles as $file) {
				$fileId = findFileByName($file, $bookFiles);
				$files[] = ['full_name' => $file, 'id' => $fileId, 'type' => mime_content_type($storageDir . $dirName . '/' . $file), 'url' => 'media/' . $dirName . '/' . $file];
			}
			$mainArray[] = ['dir_name' => $dirName, 'bookId' => (int)$bookId, 'files' => $files];
		}
		return $mainArray;
	}

	/**
	 * Gets query for [[Book]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBook() {
		return $this->hasOne(Book::class, ['id' => 'book_id']);
	}
}
