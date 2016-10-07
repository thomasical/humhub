<?php

$config['callback_url']     =   'http://vmn.teogonia.org/index.php?r=llinkedin/llinkedin'; //Your callback UR
$config['Client_ID']        =   '775wr2n8s1f23w'; // Your LinkedIn Application Client ID
$config['Client_Secret']    =   'eMc3043AZxNkEFWX'; // Your LinkedIn Application Client Secret


$ll = modules\llinkedin\models\Llinkedin::find()->where(['var' => 'setup'])->one();

$config['callback_url'] = $ll->url;
$config['Client_ID'] = $ll->client_id;
$config['Client_Secret'] = $ll->client_secret;

?>
