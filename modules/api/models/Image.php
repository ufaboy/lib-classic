<?php

namespace app\modules\api\models;

use Yii;
use yii\helpers\VarDumper;

class Image extends \app\common\models\Image {
	public function renameImage($newName) {
		$dirPath = Yii::getAlias('@app') . '/storage/' . $this->path . '/';
//		Yii::debug(VarDumper::dumpAsString($dirPath, $newName));
		return rename($dirPath . $this->file_name, $dirPath . $newName);
	}
}
