<?php

namespace Favit\Bootstrap\Integrations;

use League\Container\Container;

final class Integrations {

	/**
	 * @var Integration[]
	 */
	private array $integrations = [];

	private Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	public function add( string $id ): void {
		$this->integrations[ $id ] = $this->container->get( $id );
	}

	public function list(): array {
		return array_filter( $this->integrations, [ $this, 'is_integration' ] );
	}

	public function integrate( Integration $integration ): void {
		$integration->register();
	}

	private function is_integration( $integration ): bool {
		return $integration instanceof Integration;
	}
}
