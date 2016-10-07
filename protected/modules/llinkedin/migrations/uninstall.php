<?php

use yii\db\Migration;

class uninstall extends Migration {

    public function up() {

        $this->dropTable('llinkedin');
        $this->dropTable('llinkedin_loginpage_content');
  
        $sSql = "ALTER TABLE profile DROP `email_linkedin`";
        $this->execute($sSql);
        $sSql = "DELETE FROM profile_field WHERE `internal_name` = 'email_linkedin'";
        $this->execute($sSql);
        $insert_field = array("1" => "headline", "2" => "maiden_name", "3" => "industry", "4" => "current_share", "5" => "num_connections", "6" => "summary", "7" => "specialties", "8" => "positions", "9" => "location", "10" => "formatted_name", "11" => "phonetic_first_name", "12" => "phonetic_last_name", "13" => "formatted_phonetic_name", "14" => "num_connections_capped", "15" => "site_standard_profile_request", "16" => "email_linkedin", "17" => "company", "18" => "position_startdate", "19" => "position_enddate", "20" => "is_current", "21" => "position_summary", "22" => "api_standard_profile", "23" => "company_position_type", "24" => "company_position_industry", "25" => "company_position_ticker", "26" => "positions_id", "27" => "public_profile_url","28" => "linkedin_id","29" => "email_address");
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
