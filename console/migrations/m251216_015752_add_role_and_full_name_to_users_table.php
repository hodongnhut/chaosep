<?php

use yii\db\Migration;

class m251216_015752_add_role_and_full_name_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'full_name', $this->string(100)->null()->after('username')->comment('Họ và tên đầy đủ'));

        // Add column role
        $this->addColumn('{{%user}}', 'role', $this->smallInteger()->notNull()->defaultValue(10)->after('full_name')->comment('Vai trò: 10=Agent, 20=Manager, 30=Admin'));
        
        $this->createIndex('idx-users-role', '{{%user}}', 'role');

        $this->update('{{%user}}', ['role' => 30], ['username' => 'admin']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropIndex('idx-users-role', '{{%user}}');

        // Drop columns in reverse order
        $this->dropColumn('{{%user}}', 'role');
        $this->dropColumn('{{%user}}', 'full_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251216_015752_add_role_and_full_name_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
