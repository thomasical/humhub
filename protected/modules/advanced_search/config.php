<?php

use humhub\modules\user\widgets\AccountMenu;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\BaseMenu;
use humhub\widgets\TopMenu;
use humhub\widgets\TopMenuRightStack;

return [
    'id' => 'advanced_search',
    'class' => 'humhub\modules\advanced_search\Module',
    'namespace' => 'humhub\modules\advanced_search',
    'events' => [
        ['class' => TopMenuRightStack::className(), 'event' => TopMenuRightStack::EVENT_INIT, 'callback' => ['humhub\modules\advanced_search\Events', 'onTopMenuRightInit']],
        
    ],
];
?>