<?php

use humhub\modules\user\models\User;
?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">        
                    <strong>Search </strong>Result
                </div>
                <div class="panel-body">            
                    <ul class="Custom-Profile-list media-list">

                        <?php
                        $dummyvalue=0;
                        foreach ($users as $key => $value) {
                            ?>
                            <li>
                                <div class="media">
                                    <a href="#" class="pull-left" alt="profile pic">
                                        <?php
                                        $guid = User::find()->select(['guid'])->where(['id' => $value['user_id']])->one();
                                        if ($guid == null) {
                                            continue;
                                        }
                                        ?>
                                        <img id="user-account-image" class="img-rounded" src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/profile_image/<?php echo $guid->guid; ?>.jpg" onerror="this.src='<?php echo Yii::$app->request->baseUrl; ?>/img/default_user.jpg'" 
                                             height="50" width="50" alt="50x50" data-src="holder.js/50x50" style="width: 50px; height: 50px;">
                                    </a>
                                    <div class="media-body">
                                        <?php if (!empty($value['firstname'])){ ?> <h5 class="media-heading"><?php $dummyvalue=1; echo $value['firstname']; ?></h5><?php }?>
                                        <?php if (!empty($value['lastname'])){ ?><h5 class="media-heading"><?php  echo $value['lastname']; ?></h5><?php }?>
                                        <?php if (!empty($value['gender'])){ ?><h5 class="media-heading"><?php  echo $value['gender']; ?></h5><?php }?>
                                        <?php if (!empty($value['city'])){ ?><h5 class="media-heading"><?php  echo $value['city']; ?></h5><?php }?>
                                        <?php if (!empty($value['country'])){ ?><h5 class="media-heading"><?php echo $value['country']; ?></h5><?php }?>
                                        <?php if (!empty($value['mobile'])){ ?><h5 class="media-heading"><?php echo $value['mobile']; ?></h5><?php }?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                       if($dummyvalue==0){ echo "No Results";}
                        ?>
                    </ul>
                </div>

            </div>
        </div> 
    </div>
    <div class="col-md-1"></div>
</div>
