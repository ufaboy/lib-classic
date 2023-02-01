<?php

namespace app\modules\api\models;

class Book extends \app\common\models\Book {
	public function extraFields()
	{
		return ['images'];
	}
}
