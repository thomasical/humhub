<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace modules\llinkedin;

use Yii;
use yii\helpers\Url;



class Events extends \yii\base\Object
{

    /**
     * On User delete, also delete all comments
     *
     * @param type $event
     */
    public static function onUserDelete($event)
    {

        return true;
    }
    public static function onAdminMenuInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->addItem(array(
            'label' => 'Sign in with LinkedIn mod',
            'url' => Url::to(['/llinkedin/llinkedin/setup']),
            'icon' => '<i class="fa fa-linkedin-square" aria-hidden="true"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'llinkedin'),
            'sortOrder' => 900,
        ));
    }


}
