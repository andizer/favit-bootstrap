<?php
declare(strict_types=1);

namespace Favit\Bootstrap\Features;

abstract class BaseOption {

	protected array $option;

	protected bool $autoload = false;

	abstract public function get_name(): string;
    abstract protected function get_defaults(): array;

	public function __construct() {
		$this->option = $this->get_option();
	}

	public function __get( $property ) {
		$property = $this->normalize( $property );
		if ( ! isset( $this->$property ) ) {
			return null;
		}

		return $this->option[ $property ];
	}

	public function __set( $property, $value ): void {
		$property = $this->normalize( $property );
		if ( ! isset( $this->$property ) ) {
			return;
		}

		$this->option[ $property] = $value;
	}

	public function __isset( $property ): bool {
		return \array_key_exists( $property, $this->get_defaults() );
	}

	public function save(): void {
		\update_option( $this->get_name() , $this->option, $this->autoload );
	}

	protected function normalize( $property ): array|string {
		return \str_replace( '_', '-', $property );
	}

	private function get_option(): array {
		return \wp_parse_args(
			\get_option( $this->get_name(), [] ),
			$this->get_defaults()
		);
	}
}
