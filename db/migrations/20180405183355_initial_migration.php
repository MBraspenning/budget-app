<?php


use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
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
            $budget->addColumn('month', 'integer', ['limit' => '11'])
                ->addColumn('year', 'integer', ['limit' => '11'])
                ->addColumn('total_income', 'decimal', ['precision' => 12, 'scale' => 2, 'default' => 0.00])
                ->addColumn('total_expense', 'decimal', ['precision' => 12, 'scale' => 2, 'default' => 0.00])
                ->addColumn('total_budget', 'decimal', ['precision' => 12, 'scale' => 2, 'default' => 0.00])
                ->create();
        
        $income = $this->table('income');
            $income->addColumn('income', 'string', ['limit' => '255'])
                ->addColumn('amount', 'decimal', ['precision' => 12, 'scale' => 2, 'default' => 0.00])
                ->addColumn('added_date', 'date')
                ->create();
        
        $expense = $this->table('expense');
            $expense->addColumn('expense', 'string', ['limit' => '255'])
                ->addColumn('amount', 'decimal', ['precision' => 12, 'scale' => 2, 'default' => 0.00])
                ->addColumn('added_date', 'date')
                ->create();
    }
}
