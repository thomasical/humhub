<?php
namespace modules\llinkedin\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $module_id
 */
class Llinkedin extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'llinkedin';
    }

    /**
     * @inheritdoc
     */
   
}

