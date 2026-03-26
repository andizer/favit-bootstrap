<?php

namespace Favit\Bootstrap\Contract;

interface ValidationInterface {
    public function isValid( mixed $value ): bool;
    public function getMessage(): string;
}