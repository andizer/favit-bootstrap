<?php

namespace Favit\Bootstrap\Integrations;

use League\Container\Container;

final class Integrations {

	/**
	 * @var Integration[]
	 */
	private array $integrations = [];

	/**
	 * @var string[]
	 */
	private array $is_integrated = [];

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
		if ( \in_array( $integration::class, $this->is_integrated ) ) {
			return;
		}

		$this->is_integrated[] = $integration::class;

		$integration->register();
	}

	public function set_integratables( Integratable ...$integratables ): void {
		\array_walk(
			$integratables,
			function( Integratable $integratable ) {
				$this->set_integrations( ...$integratable->get_integrations() );
			}
		);
	}

	public function set_integrations( string ...$integrations ): void {
		\array_walk( $integrations, [ $this, 'add' ] );
	}

	private function is_integration( $integration ): bool {
		return $integration instanceof Integration;
	}
}
