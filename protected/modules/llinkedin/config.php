<?php

use humhub\modules\user\models\User;
use humhub\widgets\TopMenu;
use humhub\widgets\NotificationArea;
use humhub\modules\user\widgets\ProfileHeaderControls;
use humhub\modules\admin\widgets\AdminMenu;

return [
    'id' => 'llinkedin',
    'class' => 'modules\llinkedin\Module',
    'namespace' => 'modules\llinkedin',
    'events' => [
        ['class' => AdminMenu::className(), 'event' => AdminMenu::EVENT_INIT, 'callback' => ['modules\llinkedin\Events', 'onAdminMenuInit']],  
    ],
];
?>