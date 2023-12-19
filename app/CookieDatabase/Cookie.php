<?php

namespace Otomaties\CookieConsent\CookieDatabase;

class Cookie implements \Otomaties\CookieConsent\Contracts\Cookie
{
    public function __construct(private array $cookie)
    {
    }

    public function category() : string
    {
        $mapping = [
            'functional' => 'necessary',
            'analytics' => 'analytics',
            'marketing' => 'advertising',
        ];
        return $mapping[strtolower($this->cookie['Category'])];
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
        return $this->cookie['Domain'] ?: $_SERVER['SERVER_NAME'] ?: '/';
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
