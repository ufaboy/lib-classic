<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string|null $file_name
 * @property string|null $path
 * @property int $book_id
 *
 * @property Book $book
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['book_id'], 'integer'],
            [['file_name', 'path'], 'string', 'max' => 255],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'path' => 'Path',
            'book_id' => 'Book ID',
        ];
    }

	static function loadFilesFromFS() {
		$storageDir = Yii::getAlias('@app') . '/storage/media/';
		$dirs_name = array_diff(scandir($storageDir), array('..', '.'));

		foreach ($dirs_name as $dirName) {
			$bookId = str_replace('book_', '', $dirName);
			$book = Book::findOne(['id' => $bookId]);
			$bookFiles = $book ? ArrayHelper::getColumn($book->getMedias()->select(['id', 'file_name'])->all(), 'file_name') : [];
			$tempFiles = array_diff(scandir($storageDir . $dirName), array('..', '.'));
			foreach ($tempFiles as $file) {
				if (!in_array($file, $bookFiles, true )) {
					Yii::debug(VarDumper::dumpAsString($bookFiles));
					$mediaModel = new Media();
					$mediaModel->file_name = $file;
					$mediaModel->path = 'media/' . $dirName;
					$mediaModel->book_id = $bookId;
					$mediaModel->save();
				}

			}
		}
	}

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}
