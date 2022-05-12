<?php

namespace Favit\Bootstrap\Conditionals;

use Favit\Bootstrap\Integrations\Integration;
use League\Container\Container;

final class Conditionals {

	/**
	 * @var Conditional[]
	 */
	private static array $conditionals = [];

	private Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Checks the conditionals.
	 *
	 * @param Integration $integration The integration to check.
	 *
	 * @return bool
	 */
	public function check( Integration $integration ): bool {
		foreach ( $integration->get_conditionals() as $conditional ) {
			$instance = $this->get_conditional( $conditional );
			if ( ! $instance->is_met() ) {
				return false;
			}
		}

		return true;
	}

	public function has( $id ): bool {
		return array_key_exists( $id, self::$conditionals );
	}

	/**
	 * Retrieves the conditional from internal cache. If not exist instantiate it.
	 *
	 * @param string $conditional The classname to load.
	 *
	 * @return Conditional
	 */
	private function get_conditional( string $conditional ): Conditional {
		if ( ! $this->has( $conditional )  ) {
			self::$conditionals[ $conditional ] = $this->container->get( $conditional );
		}

		return self::$conditionals[ $conditional ];
	}
}
