<?php

use yii\db\Migration;

class m131023_165591_initial extends Migration {

    public function up() {
        $us = \humhub\modules\user\models\User::find()->where(['id' => 1])->one();
        if (!isset($us->linkedin_id)) {
            $sSql = "ALTER TABLE user ADD `linkedin_id` VARCHAR(250) DEFAULT ''";
            $this->execute($sSql);
        }
        $career_info_exist = \humhub\modules\user\models\ProfileFieldCategory::find()->where(['title' => 'Career Information'])->count();

        if ($career_info_exist) {
            $career_info = $this->careerinfo();
        } else {
            $profilefieldcategorySql = "INSERT INTO `profile_field_category`(title,sort_order, visibility) VALUES ('Career Information', 400, 1)";
            $this->execute($profilefieldcategorySql);
            $career_info = $this->careerinfo();
        }
        $career_id = $career_info->id;
        $insert_field = array("1" => "headline", "2" => "maiden_name", "3" => "industry", "4" => "current_share", "5" => "num_connections", "6" => "summary", "7" => "specialties", "8" => "positions", "9" => "location", "10" => "formatted_name", "11" => "phonetic_first_name", "12" => "phonetic_last_name", "13" => "formatted_phonetic_name", "14" => "num_connections_capped", "15" => "site_standard_profile_request", "16" => "email_linkedin", "17" => "company", "18" => "position_startdate", "19" => "position_enddate", "20" => "is_current", "21" => "position_summary", "22" => "api_standard_profile", "23" => "company_position_type", "24" => "company_position_industry", "25" => "company_position_ticker", "26" => "positions_id", "27" => "public_profile_url","28" => "linkedin_id","29" => "email_address");
        $col_names = array();
        $columns = Yii::$app->db->createCommand("SHOW COLUMNS FROM `profile`")->queryAll();
        foreach ($columns as $key => $value) {
            $col_names[] = $value['Field'];
        }
        foreach ($insert_field as $key => $val) {
            if (array_search($val, $col_names) == false) {
                $title_fields = ucwords($val);
                $title_fields = str_replace('_', ' ', $title_fields);
                $title_fields = ucwords($title_fields);
                $time = date('Y-m-d H:i:s');
                switch ($val) {
                    case 'summary':
                        $alter_nwfields = "ALTER TABLE profile ADD $val LONGTEXT DEFAULT ''";
                        $insert_nwfields = "INSERT INTO `profile_field`(profile_field_category_id, field_type_class, field_type_config, internal_name, title, sort_order, required, show_at_registration, editable, visible, searchable,created_at) VALUES ($career_id, 'humhub\\\\modules\\\\user\\\\models\\\\fieldtype\\\\TextArea', '', '$val', '$title_fields', 300, 0, 0, 1, 1, 1,'$time')";
                        $this->execute($alter_nwfields);
                        $this->execute($insert_nwfields);
                        break;
                    case 'position_summary':
                        $alter_nwfields = "ALTER TABLE profile ADD $val TEXT DEFAULT ''";
                        $insert_nwfields = "INSERT INTO `profile_field`(profile_field_category_id, field_type_class, field_type_config, internal_name, title, sort_order, required, show_at_registration, editable, visible, searchable,created_at) VALUES ($career_id, 'humhub\\\\modules\\\\user\\\\models\\\\fieldtype\\\\TextArea', '', '$val', '$title_fields', 300, 0, 0, 1, 1, 1,'$time')";
                        $this->execute($alter_nwfields);
                        $this->execute($insert_nwfields);
                        break;
                    default :
                        $alter_nwfields = "ALTER TABLE profile ADD $val VARCHAR(250) DEFAULT ''";
                        $insert_nwfields = "INSERT INTO `profile_field`(profile_field_category_id, field_type_class, field_type_config, internal_name, title, sort_order, required, show_at_registration, editable, visible, searchable,created_at) VALUES ($career_id, 'humhub\\\\modules\\\\user\\\\models\\\\fieldtype\\\\Text', '', '$val', '$title_fields', 300, 0, 0, 1, 1, 1,'$time')";
                        $this->execute($alter_nwfields);
                        $this->execute($insert_nwfields);
                }
            }
        }

        $sSql = "CREATE TABLE IF NOT EXISTS `llinkedin`(
	 `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
         `var` varchar(100),        
         `url` varchar(100),
         `client_id` varchar(100),
         `client_secret` varchar(100)         
        )";
        $this->execute($sSql);

        $sSql = "INSERT INTO `llinkedin`(var, url, client_id, client_secret) VALUES ('setup', '', '', '')
	 ";
        $this->execute($sSql);
    }

    public function down() {
        echo "m160618_124424_888_alter_user1 cannot be reverted.\n";


        return true;
    }

    public function careerinfo() {
        $career_info = \humhub\modules\user\models\ProfileFieldCategory::find()->where(['title' => 'Career Information'])->one();
        return $career_info;
    }

}
