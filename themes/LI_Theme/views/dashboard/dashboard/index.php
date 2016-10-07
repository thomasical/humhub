
<div class="nw-table-row">
    <div class="container">
        <div class="row">
            <div class="col-md-9 layout-content-container">  
                <?php
                
                if (Yii::$app->hasModule('mquestions')) {
                    ?>
                    <?= \modules\mquestions\widgets\Qabord::widget(['location' => 'bord']); ?>
                <?php } ?>
                <?php
                if ($showProfilePostForm) {
                    echo \humhub\modules\post\widgets\Form::widget(['contentContainer' => \Yii::$app->user->getIdentity()]);
                }
                ?>

                <?php
                echo \humhub\modules\content\widgets\Stream::widget([
                    'streamAction' => '//dashboard/dashboard/stream',
                    'showFilters' => false,
                    'messageStreamEmpty' => Yii::t('DashboardModule.views_dashboard_index', '<b>Your dashboard is empty!</b><br>Post something on your profile or join some spaces!'),
                ]);
                ?>
            </div>
            <div class="col-md-3 layout-sidebar-container">
                <?php
                echo \humhub\modules\dashboard\widgets\Sidebar::widget(['widgets' => [
                        [\humhub\modules\activity\widgets\Stream::className(), ['streamAction' => '/dashboard/dashboard/stream'], ['sortOrder' => 150]]
                ]]);
                ?>
            </div>
        </div>
    </div>    
</div>
