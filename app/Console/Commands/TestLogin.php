<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\HeadOfFamily;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestLogin extends Command
{
    protected $signature = 'test:login {email} {password}';
    protected $description = 'Test login for both User and HeadOfFamily';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Test User login
        $user = User::where('email', $email)->first();
        if ($user) {
            $this->info("User found: {$user->name}");
            if (Hash::check($password, $user->password)) {
                $this->info("✓ Password matches for User");
            } else {
                $this->error("✗ Password does not match for User");
            }
        } else {
            $this->warn("User with email {$email} not found");
        }

        // Test HeadOfFamily login
        $headOfFamily = HeadOfFamily::where('email', $email)->first();
        if ($headOfFamily) {
            $this->info("HeadOfFamily found: {$headOfFamily->nama}");
            if (Hash::check($password, $headOfFamily->password)) {
                $this->info("✓ Password matches for HeadOfFamily");
            } else {
                $this->error("✗ Password does not match for HeadOfFamily");
            }
        } else {
            $this->warn("HeadOfFamily with email {$email} not found");
        }
    }
}
