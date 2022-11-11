<?php


namespace App\Libs\Cart;

class CartMessages
{
    private $headMessages = [];
    private $itemMessages = [];

    public function addHeadMessage($message)
    {
        $this->headMessages[] = $message;
    }

    public function addItemMessage($productID, $message)
    {
        if (!array_key_exists($productID, $this->itemMessages)) {
            $this->itemMessages[$productID] = [];
        }
        $this->itemMessages[$productID][] = $message;
    }

    public function getHeadMessages(): array
    {
        return $this->headMessages;
    }

    public function getItemMessages($productID)
    {
        if (array_key_exists($productID, $this->itemMessages)) {
            return $this->itemMessages[$productID];
        }
        return [];
    }
}
