<?php
use yii\helpers\Html;
$ll = modules\llinkedin\models\Llinkedin::find()->where(['var' => 'setup'])->one();
Yii::$app->setModule('redactor', ['class' => 'yii\redactor\RedactorModule']);
?>

<div class="panel">
    <div class="panel-heading">
        <strong>Setting</strong>
        <hr>        
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label"> Extract extra information from LinkedIn : </label>
                    <div class="btn-group btn-toggle"> 
                        <button class="btn btn-xs btn-default btn-ln-yes" id="yes">YES</button>
                        <button class="btn btn-xs btn-primary btn-ln-no active" id="no">NO</button>
                    </div>
                    <div>
                        <small>Basic fields First Name, Last Name, LinkedIn URL are mapped to default HumHub fields, and all other available LI
                            Basic fields are mapped to a newly created "Career Information" section.  </small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Your Callback URL:</label>
                    <div>
                        <?php
                        echo yii\helpers\Url::to(Yii::$app->request->baseUrl . '/index.php/llinkedin/llinkedin', true);
                        ?>
                    </div>
                </div>
                <form role="form" id="nw-l-setup">
                    <div class="form-group">
                        <label class="control-label" for="url">Callback URL:</label>
                        <input type="text" class="form-control" id="url" name="url" value="<?= $ll->url ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="client_id">Client ID:</label>
                        <input type="text" class="form-control" id="client_id" name="client_id" value="<?= $ll->client_id ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="client_secret">Client Secret:</label>
                        <input type="text" class="form-control" id="client_secret" name="client_secret" value="<?= $ll->client_secret ?>">
                    </div>                    
                </form>     

                <!--                <div class="btn btn-primary nw-l-save" data-ui-loader=""> SAVE </div>              -->
                <div class="button-holder">    
                    <button class="btn btn-primary nw-l-save">SAVE </button>                
                </div>
                <div class="success-msg" style="display:none; color:#345b1b; font-weight: bold;"></div>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-divider"></div>
                <div class="panel-heading">
                    <strong>Landing Page</strong> Content
                </div>
                <div>
                    Place your content here : 
                    <?php
                    echo \yii\redactor\widgets\Redactor::widget([
                        'name' => 'redactor_text',
                        'value' => $langingpage_content->content,
                        'clientOptions' => [
                            'plugins' => ['clips', 'fontcolor', 'imagemanager', 'fontsize'],
                        ]
                    ]);
                    echo Html::submitButton('Save', ['class' => 'btn btn-primary redactor_save']);
                    ?>
                    <div class="redactor_save_success" style="display:none; color:#345b1b; font-weight: bold;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    base_url = window.location.pathname.split('/')[1];
    $(document).on('click', '.nw-l-save', function () {
        var $this = $(this);
        var loader = '<span class="loader">' + '<span class="sk-spinner sk-spinner-three-bounce">' + '<span class="sk-bounce1 disabled" style="width: 10px; height: 10px; background-color: rgb(255, 255, 255);"></span>' + '<span class="sk-bounce2 disabled" style="width: 10px; height: 10px; background-color: rgb(255, 255, 255);"></span>' + '<span class="sk-bounce3 disabled" style="width: 10px; height: 10px; background-color: rgb(255, 255, 255);"></span></span></span>';
        $this.html(loader);
        var data = $('#nw-l-setup').serialize();
        $.ajax({
            type: 'GET',
            url: '/' + base_url + '/index.php/llinkedin/llinkedin/saves',
            cache: false,
            data: data,
            success: function (data) {
                $this.html('SAVE');
                // $('.button-holder').html(button);
                $('.success-msg').show().html('Settings Saved Successfully').fadeOut(7000);
            }
        });
    });
    $(document).ready(function () {
        $.ajax({
            url: '/' + base_url + '/index.php/llinkedin/llinkedin/extract-data',
            type: 'post',
            success: function (data) {
                $('.btn-toggle').find('.btn').toggleClass('active');
                if (data == 1) {
                    $('.btn-toggle').find('.btn-ln-yes').addClass('active');
                    $('.btn-toggle').find('.btn-ln-no').removeClass('active');
                    $('.btn-toggle').find('.btn-ln-no').removeClass('btn-primary');
                    $('.btn-toggle').find('.btn-ln-yes').addClass('btn-primary');
                } else {
                    $('.btn-toggle').find('.btn-ln-no').addClass('active');
                    $('.btn-toggle').find('.btn-ln-yes').removeClass('active');
                    $('.btn-toggle').find('.btn-ln-yes').removeClass('btn-primary');
                    $('.btn-toggle').find('.btn-ln-no').addClass('btn-primary');
                }
            }
        });
    });

    $('.btn-toggle').click(function () {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        } else {
            $(this).find('.btn').toggleClass('btn-default');
        }
        var status_val = $(this).find('.active').attr('id');
        $.ajax({
            url: '/' + base_url + '/index.php/llinkedin/llinkedin/change-setting',
            type: 'post',
            data: {status_val: status_val},
            success: function () {
            }
        });
    });
    $(document).on('click','.redactor_save', function() {
        value = $('[name=redactor_text]').val();
        $.ajax({
            url: '/'+base_url+'/index.php/llinkedin/llinkedin/login-content-save',
            type: 'post',
            data: {value: value },
            success: function(data) {
            $('.redactor_save_success').show().html('Content Saved Successfully').fadeOut(7000);
            }
        });
    });

</script>