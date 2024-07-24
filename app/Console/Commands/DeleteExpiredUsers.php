<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;

class DeleteExpiredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired Users';

    /**
     * Execute the console command.
     */
        public function handle(){
        // Get the current date and time in UTC
        $currentDateTime = Carbon::now();

        // Convert the current date and time to the Philippines timezone
        $currentDateTime->setTimezone('Asia/Manila');

        $expiredUsers = User::where('dateTime', '<=', $currentDateTime)->get();
        $expiredUsersCount = $expiredUsers->count();

        // Debug statements
        $this->info("Current date/time in UTC: " . Carbon::now());
        $this->info("Current date/time in Manila timezone: " . $currentDateTime);
        $this->info("Expired users count: $expiredUsersCount");

        foreach ($expiredUsers as $user) {
            $this->info("Deleting user: $user->id");
            $user->isDeleted = true; // Mark user as deleted
            $user->save(); // Save changes to database
        }

        $this->info("Deleted $expiredUsersCount expired users.");
    }

}
