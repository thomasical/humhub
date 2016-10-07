<?php

namespace modules\llinkedin;
use humhub\models\Setting;

/**
 * Llinkedin humhub Module allows the administrator to authenticate the users with their linkedin profile
 *
 *
 */
class Module extends \humhub\components\Module {

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null) {
        if ($contentContainer !== null && $contentContainer instanceof \humhub\modules\user\models\User) {
            return [
                new permissions\SendMail()
            ];
        }

        return [];
    }

    public function disable() {
        $result = \Yii::$app->db->createCommand("TRUNCATE TABLE `llinkedin`")->execute();
        $result = \Yii::$app->db->createCommand("TRUNCATE TABLE `linkedin_loginpage_content`")->execute();
        parent::disable();
    }

    public function enable() {

        parent::enable();

        Setting::Set('extract_linkedin_data', 1, 'llinkedin');
    }

}
