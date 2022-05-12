<?php

namespace Favit\Bootstrap;

use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Class Container
 */
final class Container implements ContainerInterface
{

	protected array $instances = [];

	public function has(string $id): bool {
		return isset($this->instances[$id]);
	}

	/**
	 * @param      $abstract
	 * @param null $concrete
	 */
	public function set( $abstract, $concrete = null ) {
		if ($concrete === null) {
			$concrete = $abstract;
		}

		$this->instances[$abstract] = $this->resolve( $concrete );
	}

	/**
	 * @throws Exception
	 */
	public function get( string $id )
	{
		if ( ! $this->has( $id ) ) {
			$this->set( $id );
		}

		return $this->instances[$id];
	}

	/**
	 * resolve single
	 *
	 * @param string $concrete
	 *
	 * @return mixed|object
	 * @throws Exception
	 */
	private function resolve( $concrete )
	{
		$reflector = new ReflectionClass($concrete);
		if ( ! $reflector->isInstantiable()) {
			throw new Exception("Class {$concrete} is not instantiable");
		}

		$constructor = $reflector->getConstructor();
		if (is_null($constructor)) {
			return $reflector->newInstance();
		}

		$parameters   = $constructor->getParameters();
		$dependencies = $this->resolve_dependencies($parameters);

		return $reflector->newInstanceArgs($dependencies);
	}

	/**
	 * get all dependencies resolved
	 *
	 * @param ReflectionParameter[] $parameters
	 *
	 * @return array
	 * @throws Exception
	 */
	private function resolve_dependencies(array $parameters): array
	{
		try {
			$dependencies = array_map( [ $this, 'get_dependency' ], $parameters );
		}
		catch( Exception $e ) {
			throw $e;
		}

		return $dependencies;
	}

	/**
	 * @throws ReflectionException|Exception
	 */
	private function get_dependency( ReflectionParameter $parameter ) {
		$dependency = $parameter->getClass();
		if ( $dependency !== null ) {
			return $this->get( $dependency->name );
		}

		if ( $parameter->isDefaultValueAvailable() ) {
			try {
				return $parameter->getDefaultValue();
			}
			catch ( ReflectionException $e ) {
				throw $e;
			}
		}

		throw new Exception("Can not resolve class dependency {$parameter->name}");
	}
}
