<?php

namespace Favit\Bootstrap\Conditionals;

class AdminConditional implements Conditional {
	
	/**
	 * @inheritDoc
	 */
	public function is_met(): bool {
		return \is_admin();
	}
}
