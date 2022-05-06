<?php

namespace Favit\Bootstrap\Integrations;

use Favit\Bootstrap\Conditionals\Conditionals;

final class Integrations {

	/**
	 * Represents the integrations.
	 *
	 * @var Integration[]
	 */
	private array $integrations = [];

	/**
	 * Adds a new integration.
	 *
	 * @param Integration $integration The integration to add.
	 */
	public function add( Integration $integration ): void {
		$this->integrations[] = $integration;
	}

	/**
	 * Retrieves the set integrations.
	 *
	 * @return Integration[]
	 */
	public function get(): array {
		return $this->integrations;
	}

	/**
	 * Loads the integration by registering it.
	 *
	 * @param Integration $integration Integration to check.
	 */
	public function integrate( Integration $integration ): void {
		$integration->register();
	}
}
