<?php


use Phinx\Migration\AbstractMigration;

class LinkUsersToBudgetTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $budget = $this->table('budget');
            $budget->addColumn('user_id', 'integer', ['limit' => '11', 'after' => 'id'])
                ->addForeignKey('user_id', 'users', 'id')
                ->update();
        
        $income = $this->table('income');
            $income->addColumn('user_id', 'integer', ['limit' => '11', 'after' => 'id'])
                ->addForeignKey('user_id', 'users', 'id')
                ->update();
        
        $expense = $this->table('expense');
            $expense->addColumn('user_id', 'integer', ['limit' => '11', 'after' => 'id'])
                ->addForeignKey('user_id', 'users', 'id')
                ->update();
    }
}
