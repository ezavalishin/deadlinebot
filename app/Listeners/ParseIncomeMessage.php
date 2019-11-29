<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\GotNewMessage;
use App\Services\OutgoingMessage;
use App\Services\VkClient;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class ParseIncomeMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param GotNewMessage $event
     * @return void
     */
    public function handle(GotNewMessage $event)
    {
        $incomeMessage = $event->incomeMessage;

        $text = $incomeMessage->getText();

        if (Str::contains(mb_strtolower($text), '!deadline')) {

            Carbon::setLocale('ru');
            $edgeDate = Carbon::parse('2019-12-21 23:59:59', 'Europe/Moscow');

            $message = "Приём заявок закроется "  . $edgeDate->fromNow(null, false, 4);


            $outgoingMessage = new OutgoingMessage($message);
            $outgoingMessage->setPeerId($incomeMessage->getPeerId());

            (new VkClient())->sendMessage($outgoingMessage);
        }
    }
}
