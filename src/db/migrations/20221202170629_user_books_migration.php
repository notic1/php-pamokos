<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserBooksMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('user_books');

        $table->addColumn('user_id', 'integer', ['signed' => false])
                ->addColumn('book_id', 'integer', ['signed' => false])
                ->addColumn('created_at', 'datetime')
                ->addColumn('deleted_at', 'datetime')
                ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
                ->addForeignKey('book_id', 'books', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION']);

        $table->create();
    }
}
