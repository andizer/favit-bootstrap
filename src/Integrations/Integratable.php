<?php
declare(strict_types=1);

namespace Favit\Bootstrap\Integrations;

interface Integratable {

	/** @return string[] */
	public function get_integrations(): array;
}