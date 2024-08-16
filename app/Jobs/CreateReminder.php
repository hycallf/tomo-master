<?php

namespace App\Jobs;

use App\Models\Perbaikan;
use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $perbaikan;

    public function __construct(Perbaikan $perbaikan)
    {
        $this->perbaikan = $perbaikan;
    }

    public function handle()
    {
        Reminder::create([
            'perbaikan_id' => $this->perbaikan->id,
        ]);
    }
}