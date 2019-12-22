<?php

namespace App\Listeners;

use App\Events\GotNewMessage;
use App\Services\OutgoingMessage;
use App\Services\VkClient;
use Carbon\Carbon;

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

//        if (Str::contains(mb_strtolower($text), '!deadline')) {

        Carbon::setLocale('ru');
        $edgeDate = Carbon::parse('2019-12-26 23:59:59', 'Europe/Moscow');

        $message = 'Подведение итогов ' . $edgeDate->fromNow(null, false, 4);


        $outgoingMessage = new OutgoingMessage($message);
        $outgoingMessage->setPeerId($incomeMessage->getPeerId());

        (new VkClient())->sendMessage($outgoingMessage);
//        }
    }
}
