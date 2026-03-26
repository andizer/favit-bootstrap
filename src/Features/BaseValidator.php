<?php

namespace Favit\Bootstrap\Features;

use Favit\Bootstrap\Contract\FormDataInterface;
use Favit\Bootstrap\Contract\ValidationInterface;
use Favit\Bootstrap\Contract\ValidatorInterface;

abstract class BaseValidator implements ValidatorInterface {
    protected array $errors = [];

    abstract protected function getRules(): array;

    public function validate( FormDataInterface $data ): bool
    {
        $this->errors = [];

        foreach ( $this->getRules() as $field => $validations ) {
            $value = $data->get($field);

            foreach ( $validations as $validation ) {
                if ( ! $validation->isValid($value ) ) {
                    $this->addError( $field, $validation );
                    break;
                }
            }
        }

        return !$this->hasErrors();
    }

    protected function addError( string $field, ValidationInterface $validation ): void
    {
        $this->errors[$field][] = $validation->getMessage();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasError(string $field): bool
    {
        return !empty( $this->errors[$field] );
    }

    public function hasErrors(): bool
    {
        return !empty( $this->errors );
    }
}