<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $login = $this->askLogin();
        $pwd = $this->ask("Enter admin password", "admin");

        try {
            $user = User::create([
                'login' => $login,
                'password' => $pwd
            ]);

            $user->assignRole(Role::findByName('admin'));

            $this->info('Admin user successful created!');

            return 0;
        } catch (\Exception $exception) {
            if ($user) {
                $user->forceDelete();
            }
            return 1;
        }

    }

    private function askLogin() {
        $login = $this->ask("Enter admin login", 'admin');

        if (User::where('login', $login)->exists()) {
            $this->error("Current login already exists, try another");
            return $this->askLogin();
        } else {
            return $login;
        }
    }
}
