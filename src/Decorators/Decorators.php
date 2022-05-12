<?php

namespace Favit\Bootstrap\Decorators;

use Favit\Bootstrap\Container;
use Favit\Bootstrap\Integrations\Integration;

final class Decorators {

	/**
	 * @var Decorator[]
	 */
	private array $decorators = [];

	private Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	public function add( string $id ): void {
		$this->decorators[ $id ] = $this->container->get( $id );
	}

	public function decorate( Integration $integration ): Integration {
		foreach ( $this->list() as $decorator ) {
			$decorator->decorate( $integration );
		}

		return $integration;
	}

	public function list(): array {
		return array_filter( $this->decorators, [ $this, 'is_decorator' ] );
	}

	private function is_decorator( $integration ): bool {
		return $integration instanceof Decorator;
	}
}
