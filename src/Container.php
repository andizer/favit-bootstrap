<?php

namespace Favit\Bootstrap;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Class Container
 */
final class Container
{

	private static ?self $instance = null;

	protected array $instances = [];

	public static function get_instance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @param      $abstract
	 * @param null $concrete
	 */
	public function set($abstract, $concrete = null)
	{
		if ($concrete === null) {
			$concrete = $abstract;
		}

		$this->instances[$abstract] = $concrete;
	}

	/**
	 * @param       $abstract
	 * @param array $parameters
	 *
	 * @return mixed|null|object
	 * @throws Exception
	 */
	public function get($abstract, array $parameters = [])
	{
		if (!isset($this->instances[$abstract])) {
			$this->set($abstract);
		}

		return $this->resolve($this->instances[$abstract], $parameters);
	}

	/**
	 * resolve single
	 *
	 * @param callable|string $concrete
	 * @param array $parameters
	 *
	 * @return mixed|object
	 * @throws Exception
	 */
	public function resolve($concrete, array $parameters)
	{
		if ($concrete instanceof Closure) {
			return $concrete($this, $parameters);
		}

		$reflector = new ReflectionClass($concrete);
		if (!$reflector->isInstantiable()) {
			throw new Exception("Class {$concrete} is not instantiable");
		}

		// get class constructor
		$constructor = $reflector->getConstructor();
		if (is_null($constructor)) {
			return $reflector->newInstance();
		}

		$parameters   = $constructor->getParameters();
		$dependencies = $this->getDependencies($parameters);

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
	public function getDependencies(array $parameters): array
	{
		try {
			$dependencies = array_map( [ $this, 'getDependency' ], $parameters );
		}
		catch( Exception $e ) {
			throw $e;
		}

		return $dependencies;
	}

	/**
	 * @throws ReflectionException|Exception
	 */
	private function getDependency(ReflectionParameter $parameter ) {
		$dependency = $parameter->getClass();
		if ($dependency !== null) {
			return $this->get($dependency->name);
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
