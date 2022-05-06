<?php

namespace Favit\Bootstrap;

use Favit\Bootstrap\Conditionals\Conditionals;
use Favit\Bootstrap\Decorators\Decorators;
use Favit\Bootstrap\Integrations\Integrations;

class Bootstrap {

	protected Integrations $integrations;
	protected Decorators $decorators;
	protected Conditionals $conditionals;

	public function __construct() {
		$this->integrations = new Integrations();
		$this->decorators   = new Decorators();
		$this->conditionals = new Conditionals();
	}

	protected function load() {
		$integrations = $this->integrations->get();
		$integrations = array_filter( $integrations, [ $this->conditionals, 'check' ] );
		$integrations = array_map( [$this->decorators, 'decorate'], $integrations );

		array_walk( $integrations, [ $this->integrations, 'integrate' ] );
	}
}
