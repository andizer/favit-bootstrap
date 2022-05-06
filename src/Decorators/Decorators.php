<?php

namespace Favit\Bootstrap\Decorators;

use Favit\Bootstrap\Integrations\Integration;

final class Decorators {

	/**
	 * @var Decorator[]
	 */
	private array $decorators = [];

	public function add( Decorator $decorator ): void {
		$this->decorators[] = $decorator;
	}

	public function decorate( Integration $integration ): Integration {
		foreach ( $this->get() as $decorator ) {
			$decorator->decorate( $integration );
		}

		return $integration;
	}

	private function get(): array {
		return $this->decorators;
	}
}
