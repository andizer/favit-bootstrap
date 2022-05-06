<?php

namespace Favit\Bootstrap\Conditionals;

use Favit\Bootstrap\Integrations\Integration;

final class Conditionals {

	/**
	 * Holds the instances of the conditionals.
	 *
	 * @var Conditional[]
	 */
	private static array $conditionals = [];

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

	/**
	 * Retrieves the conditional from internal cache. If not exist instantiate it.
	 *
	 * @param string $conditional The classname to load.
	 *
	 * @return Conditional
	 */
	private function get_conditional(string $conditional): Conditional {
		if( ! array_key_exists( $conditional, self::$conditionals ) ) {
			self::$conditionals[ $conditional ] = new $conditional();
		}

		return self::$conditionals[ $conditional ];
	}
}
