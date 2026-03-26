<?php

namespace Favit\Bootstrap\Features;

use Favit\Bootstrap\Contract\FormDataInterface;

abstract class BaseFormData implements FormDataInterface {

    public function __construct( protected array $data = [] ) {

    }

    public function get( string $key, mixed $default = null ): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function has( string $key ): bool
    {
        return \array_key_exists( $key, $this->data );
    }

    public function all(): array
    {
        return $this->data;
    }
}