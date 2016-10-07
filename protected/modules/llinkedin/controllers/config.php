<?php

$config['callback_url']     =   ''; //Your callback UR
$config['Client_ID']        =   ''; // Your LinkedIn Application Client ID
$config['Client_Secret']    =   ''; // Your LinkedIn Application Client Secret


$ll = modules\llinkedin\models\Llinkedin::find()->where(['var' => 'setup'])->one();

$config['callback_url'] = $ll->url;
$config['Client_ID'] = $ll->client_id;
$config['Client_Secret'] = $ll->client_secret;

?>
