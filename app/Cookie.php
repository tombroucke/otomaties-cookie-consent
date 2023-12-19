<?php

namespace Otomaties\CookieConsent;

class Cookie implements Contracts\Cookie
{
    public function __construct(private array $cookie)
    {
    }

    public function category() : string
    {
        return $this->cookie['Category'];
    }

    public function vendor() : string
    {
        return $this->cookie['Platform'];
    }

    public function name() : string
    {
        $name = $this->cookie['Cookie / Data Key name'];
        if ($this->cookie['Wildcard match'] && substr($name, -1) === '_') {
            $name .= '*';
        }
        return $name;
    }

    public function domain() : string
    {
        return $this->cookie['Domain'];
    }

    public function description() : string
    {
        return $this->cookie['Description'];
    }

    public function expiration() : string
    {
        return $this->cookie['Retention period'];
    }

    public function regex() : bool
    {
        return $this->cookie['Wildcard match'];
    }
}
