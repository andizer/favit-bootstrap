<?php

namespace Favit\Bootstrap\Decorators;

use Favit\Bootstrap\Integrations\Integration;

interface Decorator {

	public function decorate( Integration $integration ): Integration;

}
