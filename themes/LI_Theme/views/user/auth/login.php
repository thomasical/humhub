<?php

use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use \humhub\compat\CHtml;
use humhub\modules\user\widgets\AuthChoice;

$this->pageTitle = Yii::t('UserModule.views_auth_login', 'Login');
?>

<div class="container" style="text-align: center;">
    <?= humhub\widgets\SiteLogo::widget(['place' => 'login']); ?>
    <br>

    <?php 
     if(Yii::$app->hasModule('llinkedin')){
    ?>    
    <?php 
    $langingpage_content = \app\modules\llinkedin\models\LlinkedinLoginpageContent::find()->one();
    echo $langingpage_content->content;
    ?>
        <div class="panel panel-default animated bounceIn" id="login-form"
             style="max-width: 300px; margin: 0 auto 20px; text-align: left;">
            <div class="panel-body">
                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php/llinkedin/llinkedin" class="nw-linkedin">
                    <div class="btn btn-group-justified btn-success" style="background: #07b;">

                        <div style="text-align: left; float: left;"><strong>In|</strong></div>
                        Sign in with LinkedIn
                       
                    
                    </div>
                </a>
            </div>
        </div>

     <?php } else { ?>
    
    <div class="panel panel-default animated bounceIn" id="login-form"
         style="max-width: 300px; margin: 0 auto 20px; text-align: left;">

        <div class="panel-heading"><?php echo Yii::t('UserModule.views_auth_login', '<strong>Please</strong> sign in'); ?></div>

        <div class="panel-body">

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if(AuthChoice::hasClients()): ?>
                <?= AuthChoice::widget([]) ?>
            <?php else: ?>
                <p><?php echo Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
            <?php endif; ?>
            
            <?php $form = ActiveForm::begin(['id' => 'account-login-form', 'enableClientValidation' => false]); ?>
            <?php echo $form->field($model, 'username')->textInput(['id' => 'login_username', 'placeholder' => $model->getAttributeLabel('username')])->label(false); ?>
            <?php echo $form->field($model, 'password')->passwordInput(['id' => 'login_password', 'placeholder' => $model->getAttributeLabel('password')])->label(false); ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
   
            <?php 
             if(Yii::$app->hasModule('llinkedin')){
            ?>
                <div class="form-group nw-social-networks-block">
                    <a href="index.php?r=llinkedin/llinkedin" class="nw-linkedin">
                        <img src="/img/social/linkedin-signin-button.png" alt="Sign in with LinkedIn" />
                    </a>
                </div>
             <?php } ?>
            <div class="row">
                <div class="col-md-4">
                    <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Sign in'), array('id' => 'login-button', 'data-ui-loader' => "", 'class' => 'btn btn-large btn-primary')); ?>
                </div>
                <div class="col-md-8 text-right">
                    <small>
                        <?php echo Yii::t('UserModule.views_auth_login', 'Forgot your password?'); ?>
                        <a
                            href="<?php echo Url::toRoute('/user/password-recovery'); ?>"><br><?php echo Yii::t('UserModule.views_auth_login', 'Create a new one.') ?></a>
                    </small>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>

    <br> 
    
     <?php } ?>
    
    <div id="nw-form-x" style="display: none;">
            <div class="panel panel-default animated bounceIn" id="login-form"
         style="max-width: 300px; margin: 0 auto 20px; text-align: left;">

        <div class="panel-heading"><?php echo Yii::t('UserModule.views_auth_login', '<strong>Please</strong> sign in'); ?></div>

        <div class="panel-body">

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if(AuthChoice::hasClients()): ?>
                <?= AuthChoice::widget([]) ?>
            <?php else: ?>
                <p><?php echo Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
            <?php endif; ?>
            
            <?php $form = ActiveForm::begin(['id' => 'account-login-form', 'enableClientValidation' => false]); ?>
            <?php echo $form->field($model, 'username')->textInput(['id' => 'login_username', 'placeholder' => $model->getAttributeLabel('username')])->label(false); ?>
            <?php echo $form->field($model, 'password')->passwordInput(['id' => 'login_password', 'placeholder' => $model->getAttributeLabel('password')])->label(false); ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
   

            <div class="row">
                <div class="col-md-4">
                    <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Sign in'), array('id' => 'login-button', 'data-ui-loader' => "", 'class' => 'btn btn-large btn-primary')); ?>
                </div>
                <div class="col-md-8 text-right">

                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
    </div>

</div>

<script type="text/javascript">
    
    $('.nw-x').on('click', function(){
        $('#nw-form-x').toggle(300);
    });
    
    
    $(function () {
        // set cursor to login field
        $('#login_username').focus();
    })

    // Shake panel after wrong validation
<?php if ($model->hasErrors()) { ?>
        $('#login-form').removeClass('bounceIn');
        $('#login-form').addClass('shake');
        $('#register-form').removeClass('bounceInLeft');
        $('#app-title').removeClass('fadeIn');
<?php } ?>

    // Shake panel after wrong validation
<?php if ($invite->hasErrors()) { ?>
        $('#register-form').removeClass('bounceInLeft');
        $('#register-form').addClass('shake');
        $('#login-form').removeClass('bounceIn');
        $('#app-title').removeClass('fadeIn');
<?php } ?>

</script>


