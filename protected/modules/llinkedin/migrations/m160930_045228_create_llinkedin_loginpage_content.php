<?php

use yii\db\Migration;

/**
 * Handles the creation for table `llinkedin_loginpage_content`.
 */
class m160930_045228_create_llinkedin_loginpage_content extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('llinkedin_loginpage_content');
        if ($tableSchema == null) {
            $this->createTable('llinkedin_loginpage_content', [
                'id' => 'pk',
                'content' => 'LONGTEXT',
                'created_at' => 'int(11) NOT NULL',
                'updated_at' => 'int(11) NOT NULL',
            ]);
        }
        $insert_nwfields = "INSERT INTO `llinkedin_loginpage_content`(`created_at`, `updated_at`) VALUES (1,1)";
        $this->execute($insert_nwfields);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('llinkedin_loginpage_content');
    }

}
