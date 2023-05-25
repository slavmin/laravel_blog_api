<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Console\Traits\AskWithValidation;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateUser extends Command
{
    use AskWithValidation;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create-user {--name=} {--email=} {--password=}';

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

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        $this->info('Demo user created successfully.');

        return CommandAlias::SUCCESS;
    }
}
