<?php

namespace humhub\modules\advanced_search;

use Yii;
use yii\helpers\Url;
use humhub\models\Setting;

/**
 * Advance search Events
 *
 * 
 */
class Events extends \yii\base\Object {

    public static function onTopMenuRightInit($event)
    {
        $event->sender->addWidget(widgets\SearchMenu::className());
    }
    

}
