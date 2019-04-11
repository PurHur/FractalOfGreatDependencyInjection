<?php
namespace Object\Manager;

/**
 * Class ObjectManager
 *
 * @todo make singleton or not static!
 */
class ObjectManager implements ObjectManagerInterface
{
	public static function get($className) {
       // $className = self::mapClass($className);

		$instance = self::getInstanceVariable($className);

		if (method_exists($instance, '__inject')) {
            self::injectDependencies($instance);
        }

		return $instance;
	}

	/**
	 * @param string $className
	 *
	 * @return object
	 */
	private static function getInstanceVariable($className) {
        $objectFactory = self::getFactoryForClass($className);
        
        $instance = $objectFactory->getObjectInstance($className);

		return $instance;
	}

	/**
	 * @param $instance
	 */
	public static function injectDependencies($instance) {
		$classDefinition = self::getClassDefinition(get_class($instance));

		if(isset($classDefinition['property']) && is_array($classDefinition['property'])) {
			foreach ($classDefinition['property'] as $propertyName => $annotations) {
				$injectProperty = false;
				$class = false;
				foreach ($annotations as $annotation) {
					$tokens = preg_split('/\s+/', $annotation);
					if (count($tokens) >= 2 && strtolower($tokens[0]) == 'var') {
						$class = $tokens[1];
					}
					if (strtolower($tokens[0]) == 'inject') {
						$injectProperty = true;
					}
					if ($injectProperty && strlen($class)) {
						break;
					}
				}

				if ($injectProperty) {
					$instance->__inject($propertyName, self::get($class));
				}
			}
		}
	}

	private static function getClassDefinition($className) {
		return \Object\Service\ClassReflectionService::parseClass($className);
	}

    /**
     * @param $class
     * @return mixed
     */
	public static function mapClass($class) {
	    $class = trim($class,'\\');
	    $class = str_replace('\\\\','\\',$class);


        $classMapper = \Object\Manager\ObjectManager::get(
            \Object\Mapper\ClassMapper::class
        );
        $classMapping = $classMapper->getClassMapping($class);

        if (strlen($classMapping)) {
            return $classMapping;
        }

        return $class;
	}

    /**
     * @param $className
     * @return \Object\Factory\NaiveObjectFactory|\Object\Factory\SingletonObjectFactory|\Object\Traits\Singleton
     */
    public static function getFactoryForClass($className)
    {
        if (method_exists($className, 'getInstance')) {
            $objectFactory = \Object\Factory\SingletonObjectFactory::getInstance();
        } else {
            $objectFactory = \Object\Factory\NaiveObjectFactory::getInstance();
        }
        return $objectFactory;
    }
}
