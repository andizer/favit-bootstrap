<?php
declare(strict_types=1);

namespace Favit\Bootstrap\Integrations;

use Favit\Bootstrap\Conditionals\Conditionable;

interface Integration extends Conditionable {

	public function register(): void;

}
