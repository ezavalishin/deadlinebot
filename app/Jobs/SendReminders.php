<?php

namespace App\Jobs;

use App\Services\OutgoingMessage;
use App\Services\VkClient;
use Carbon\Carbon;

class SendReminders extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $peerIds = [''];

        foreach ($peerIds as $peerId) {
            Carbon::setLocale('ru');
            $edgeDate = Carbon::parse('2019-12-21 23:59:59', 'Europe/Moscow');

            $message = "Приём заявок закроется "  . $edgeDate->fromNow(null, false, 4);

            $outgoingMessage = new OutgoingMessage($message);
            $outgoingMessage->setPeerId($peerId);

            (new VkClient())->sendMessage($outgoingMessage);
        }
    }
}
