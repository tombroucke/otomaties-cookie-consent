<?php

namespace Otomaties\CookieConsent\Contracts;

interface Cookie
{

    public function category() : string;

    public function vendor() : string;

    public function name() : string;

    public function domain() : string;

    public function description() : string;

    public function expiration() : string;

    public function regex() : bool;
}
