<?php

namespace Favit\Bootstrap\Conditionals;

interface Conditional {

	/**
	 * Checks if the conditional is met.
	 *
	 * @return bool
	 */
	public function is_met(): bool;

}
