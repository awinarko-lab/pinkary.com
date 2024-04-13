<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\UserMailPreference;
use App\Mail\PendingNotifications;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendWeeklyEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weekly-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the weekly emails to the users.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::where('mail_preference_time', UserMailPreference::Weekly)
            ->whereHas('notifications')
            ->each(fn (User $user) => Mail::to($user)->queue(new PendingNotifications($user)));
    }
}
