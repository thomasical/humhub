<?php

use yii\db\Migration;

class uninstall extends Migration {

    public function up() {

        $this->dropTable('llinkedin');

        // $sSql = "ALTER TABLE user DROP `linkedin_id`";
        // $this->execute($sSql);  
        $sSql = "ALTER TABLE profile DROP `email_linkedin`";
        $this->execute($sSql);
        $sSql = "DELETE FROM profile_field WHERE `internal_name` = 'email_linkedin'";
        $this->execute($sSql);
        $insert_field = array("1" => "headline", "2" => "maiden_name", "3" => "industry", "4" => "current_share", "5" => "num_connections", "6" => "summary", "7" => "specialties", "8" => "positions", "9" => "location", "10" => "formatted_name", "11" => "phonetic_first_name", "12" => "phonetic_last_name", "13" => "formatted_phonetic_name", "14" => "num_connections_capped", "15" => "site_standard_profile_request");
        foreach ($insert_field as $key => $val) {
            $alter_nwfields = "ALTER TABLE profile DROP COLUMN $val";
            $sSql = "DELETE FROM profile_field WHERE `internal_name = '$val'";
            $this->execute($alter_nwfields);
            $this->execute($sSql);
        }
    }

    public function down() {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}
