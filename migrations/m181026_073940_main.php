<?php

use yii\db\Migration;

/**
 * Class m181026_073940_main
 */
class m181026_073940_main extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('graph_datas', [
            'id' => $this->primaryKey(),
            'time' => $this->date()->notNull(),
            'amount' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181026_073940_main cannot be reverted.\n";
        $this->dropTable('graph_datas');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181026_073940_main cannot be reverted.\n";

        return false;
    }
    */
}
