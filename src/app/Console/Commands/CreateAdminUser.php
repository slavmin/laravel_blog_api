<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\Roles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Console\Traits\AskWithValidation;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateAdminUser extends Command
{
    use AskWithValidation;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create-admin {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->option('name') ?? $this->askWithValidation('Name', ['string', 'min:6'], 'name');
        $email = $this->option('email') ?? $this->askWithValidation('Email', ['string', 'email'], 'name');
        $password = $this->option('password') ?? $this->askWithValidation('Password', ['string', 'min:8'], 'password', true);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole(Roles::ADMIN->value);

        $this->info('Admin created successfully');

        return CommandAlias::SUCCESS;
    }
}
