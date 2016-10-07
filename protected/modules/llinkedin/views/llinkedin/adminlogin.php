<?php

use \yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="topbar-actions">
                        <a href="<?php echo Url::toRoute('/user/auth/login'); ?>" class="btn btn-primary" data-target="#globalModal">Sign in / up</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-1"></div>
    </div>
</div>
