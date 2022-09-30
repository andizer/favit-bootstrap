<?php

namespace Favit\Bootstrap\Conditionals;

class FrontendConditional implements Conditional {

	public function is_met(): bool {
		return ! \is_admin();
	}
}
