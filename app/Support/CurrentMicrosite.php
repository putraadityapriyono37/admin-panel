<?php

namespace App\Support;

use App\Models\Microsite;

class CurrentMicrosite
{
    private ?Microsite $microsite = null;

    public function set(Microsite $microsite): void
    {
        $this->microsite = $microsite;
    }

    public function get(): ?Microsite
    {
        return $this->microsite;
    }
}
