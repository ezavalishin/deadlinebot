<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Str;

class OutgoingMessage
{
    private $message;

    private $peerId;
    private $randomId;
    private $attachments = [];

    private $model;

    /**
     * @var VkKeyboard|null
     */
    private $vkKeyboard = null;

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public function setPeerId($peerId) {
        $this->peerId = $peerId;
    }

//    public function setKeyboard(VkKeyboard $vkKeyboard) {
//        $this->vkKeyboard = $vkKeyboard;
//    }

    private function setRandomId($randomId) {
        $this->randomId = $randomId;
    }

    public function toVkRequest() {
        $request = [
            'random_id' => time(),
            'peer_id' => $this->peerId,
            'message' => $this->message
        ];

        if ($this->vkKeyboard) {
            $request['keyboard'] = json_encode($this->vkKeyboard->toArray(), JSON_UNESCAPED_UNICODE);
        }

        if (!empty($this->attachments)) {
            $request['attachment'] = implode(',', $this->attachments);
        }

        return $request;
    }

    public function addAttachment(string $attachment) {
        $this->attachments[] = $attachment;
    }
}
