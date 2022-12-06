<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
            $seeds[$i] = [
                'email'     => "john.doe$i@gmail.com",
                'name'      => 'John Doe',
                'password'  => password_hash('password', PASSWORD_BCRYPT),
                'is_active' => random_int(0, 100) < 50 ? true : false,
                'is_admin' => random_int(0, 100) < 20 ? true : false
            ];
        }

        $users = $this->table('users');
        $users->insert($seeds)
              ->saveData();

    }
}
