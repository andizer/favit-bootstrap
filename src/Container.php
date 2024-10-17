<?php

namespace Favit\Bootstrap;

use League\Container\Container as LeagueContainer;

class Container extends LeagueContainer {
	public function addResolver( string|Resolvable $resolvable ): void {
		$this->add( $resolvable::resolves(), $this->get( $resolvable ) );
	}
}
