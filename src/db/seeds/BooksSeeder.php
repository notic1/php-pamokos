<?php


use Phinx\Seed\AbstractSeed;

class BooksSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $seeds = [];
        for($i = 0; $i < 10; $i++) {
            $date = new DateTime(random_int(1900, 2022) . '-' . random_int(1, 12) . '-' . random_int(1, 30));
            $seeds[$i] = [
                'author'     => 'John Doe',
                'title'      => 'Lorem ipsum',
                'year_released'  => $date->format('Y-m-d'),
                'quantity' => random_int(0, 100)
            ];
        }

        $users = $this->table('books');
        $users->insert($seeds)
              ->saveData();
    }
}
