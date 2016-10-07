<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\advanced_search\Assets;

Assets::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php
                    $form = ActiveForm::begin([
                                'action' => ['whole-search'],
                                'method' => 'post',
                    ]);
                    ?>
                    <div class="input-group" style="margin-bottom: 10px;">
                        <?= Html::input('text', 'search_box', '', ['class' => 'form-control', 'placeholder' => 'Search all profile fields']) ?>
                        <span class="input-group-btn">
                            <?= Html::submitButton('Go', ['class' => 'btn btn-primary']) ?>
                        </span>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <strong>Find</strong> members where
                </div>                
                <div class="panel-body">
                    <?php
                    $form = ActiveForm::begin([
                                'action' => ['search'],
                                'method' => 'post',
                    ]);
                    ?>
                    <div class="search-btn-button">
                        <?php
                        echo Html::submitButton('Search', ['class' => 'btn btn-primary']);
                        ?>
                    </div>
                    <?php
                    foreach ($field_category as $category_value) {
                        ?>
                        <p><strong>Category: <?= $category_value->title; ?></strong></p>
                        <?php
                        foreach ($profile_fields as $profile_field) {
                            if ($profile_field->profile_field_category_id == $category_value->id) {
                                ?>
                                <div class="row">
                                    <div class="col-md-4">    
                                        <div class="form-label"><strong><?= $profile_field->title; ?></strong>                                    
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span><?= Html::dropDownList('operator[]', '', ["OR", "AND"], ['class' => 'form-control',]) ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <span><?= Html::dropDownList('condition[]', '', ["contains", "does not contain"], ['class' => 'form-control',]) ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group field-profile-firstname required">
                                            <?= Html::input('text', 'prof_field[]', '', ['class' => 'form-control']) ?>
                                        </div>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary pull-right']) ?>
                    <?php ActiveForm::end(); ?>
                </div> 
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>