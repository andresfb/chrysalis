<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lets you create the Administrator user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::where("email", "admin@app.com")->first();
        if (!$user) {
            echo "\n\033[0;31mSetup was run for this App already\033[0m\n\n";
            exit();
        }

        list($email, $name, $password) = $this->getUserInfo();

        try {
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
        } catch (\Exception $e) {
            echo "\n\033[0;31mError Saving the User info:\n";
            echo "\n\033[0;31m" . $e->getMessage() . "\033[0m\n\n";
            exit();
        }

        echo "\n\033[0;32mSuccess\033[0m\n\n";
        return true;
    }

    /**
     * @return array
     */
    public function getUserInfo()
    {
        echo PHP_EOL;
        echo "\033[0;35mThis program will let you create an Administrator user. Please folow the instructions:\033[0m\n\n";

        if (!defined("STDIN")) {
            define("STDIN", fopen('php://stdin','rb'));
        }

        echo "Enter the Email Address: ";
        $email = trim(fread(STDIN, 100));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "\n\033[0;31mEmail address is invalid. Try again\033[0m\n\n";
            fclose(STDIN);
            exit();
        }
        $user = User::where("email", $email)->first();
        if ($user) {
            echo "\n\033[0;31mEmail already exists. Try again\033[0m\n\n";
            fclose(STDIN);
            exit();
        }
        echo "\nUsing \033[0;32m{$email}\033[0m for Email/Username\n\n";

        echo "Enter the Full Name: ";
        $name = trim(fread(STDIN, 200));
        if (empty(trim($name))) {
            echo "\n\033[0;31mFull Name cannot be empty. Try again\033[0m\n\n";
            fclose(STDIN);
            exit();
        }

        echo "Enter the Password (min 8, max 200 chars): \033[0;30m\033[40m";
        $password = trim(fread(STDIN, 200));
        echo "\033[0m";
        if (strlen($password) < 8) {
            echo "\n\033[0;31mPasswords is too short. Try again\033[0m\n\n";
            fclose(STDIN);
            exit();
        }

        echo "Confirm Password: \033[0;30m\033[40m";
        $confpass = trim(fread(STDIN, 200));
        echo "\033[0m";
        if ($password !== $confpass) {
            echo "\n\033[0;31mPasswords don't match. Try again\033[0m\n\n";
            fclose(STDIN);
            exit();
        }
        fclose(STDIN);
        echo "\n\033[0;32mPasswords Match. Creating the user...\033[0m\n";

        return [$email, $name, $password];
    }
}
