<?php

namespace Favit\Bootstrap\Integrations;

interface Integration {

	public function register(): void;

	public function get_conditionals(): array;

}
