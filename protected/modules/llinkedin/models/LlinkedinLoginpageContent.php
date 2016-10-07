<?php

namespace app\modules\llinkedin\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "llinkedin_loginpage_content".
 *
 * @property integer $id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class LlinkedinLoginpageContent extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'llinkedin_loginpage_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
