<?php

namespace Favit\Bootstrap\Contract;

interface ValidatorInterface {
    public function validate( FormDataInterface $data ): bool;
    public function getErrors(): array;
    public function hasError( string $field ): bool;
    public function hasErrors(): bool;
}