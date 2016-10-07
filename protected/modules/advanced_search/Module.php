<?php

namespace humhub\modules\advanced_search;

use Yii;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\models\Setting;

/**
 * advanced_search module definition class
 */
class Module extends \humhub\modules\content\components\ContentContainerModule {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\advanced_search\controllers';

    public function getContentContainerTypes() {
        return [
            Space::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    public function disable() {
        

        parent::disable();
    }

    /**

     * @inheritdoc

     */
    public function enable() {

        parent::enable();
    }

    public function getConfigUrl() {
        
    }


}
