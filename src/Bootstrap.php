<?php

namespace Favit\Bootstrap;

use Favit\Bootstrap\Conditionals\Conditionals;
use Favit\Bootstrap\Decorators\Decorators;
use Favit\Bootstrap\Integrations\Integrations;

class Bootstrap {

	protected Integrations $integrations;
	protected Decorators $decorators;
	protected Conditionals $conditionals;

	public function __construct( Integrations $integrations, Decorators $decorators, Conditionals $conditionals ) {
		$this->integrations = $integrations;
		$this->decorators   = $decorators;
		$this->conditionals = $conditionals;

		$this->setup();
	}

	protected function initialize(): void {
		$integrations = $this->integrations->list();
		$integrations = array_filter( $integrations, [ $this->conditionals, 'check' ] );
		$integrations = array_map( [$this->decorators, 'decorate'], $integrations );

		array_walk( $integrations, [ $this->integrations, 'integrate' ] );
	}

	protected function setup(): void {

	}
}
