<?php

namespace Favit\Bootstrap;

use Favit\Bootstrap\Conditionals\Conditionals;
use Favit\Bootstrap\Decorators\Decorators;
use Favit\Bootstrap\Integrations\Integrations;
use League\Container\Container;
use League\Container\ReflectionContainer;

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

	public static function get_container(): Container {
		$container = new Container();
		$container->add( Container::class, $container );
		$container->delegate( new ReflectionContainer( true ) );

		return $container;
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
