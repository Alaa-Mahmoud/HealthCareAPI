<?php

namespace App\Console\Commands;

use App\Invoice;
use App\Notifications\InvoicePending;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class InvoicePendingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:invoice_reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to remind patient with pending invoice';

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
     * @return mixed
     */
    public function handle()
    {
        $invoices = Invoice::where('pending' , true)
            ->where('created_at', '<=', Carbon::now()->subDays(2)->toDateTimeString())
            ->get();
        if (!emptyArray($invoices)) {
            foreach ($invoices as $invoice) {
                $user = User::find($invoice->user_id);
                $user->notify(new InvoicePending());
            }
        }
    }
}
