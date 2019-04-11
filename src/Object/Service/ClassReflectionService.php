<?php
namespace Object\Service;

/**
 * Class ClassService
 *
 */
class ClassReflectionService
{
    protected static $cache = array();

    /**
     * @param $class
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function parseClass($class) {
        if (isset(self::$cache[$class])) {
            return self::$cache[$class];
        }

        $result = array();
        $result['classname'] = $class;
        $result['class'] = self::parseClassAnnotation($class);

        /** @var \ReflectionClass $reflect */
        $reflect = new \ReflectionClass($class);
        $methods = $reflect->getMethods();
        foreach ($methods as $method) {
            $result['method'][$method->name] = self::parseMethodAnnotation($class, $method->name);
        }

        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            $result['property'][$property->getName()] = self::parsePropertyAnnotation($class, $property->getName());
        }

        self::$cache[$class] = $result;

        return $result;
    }

    /**
     * @param $class
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function parseClassAnnotation($class) {
        $reflect = new \ReflectionClass($class);
        $comments = $reflect->getDocComment();
        preg_match_all('#@(.*?)\n#s', $comments, $annotations);

        return $annotations;
    }

    /**
     * @param $class
     * @param $method
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function parseMethodAnnotation($class, $method) {
        $reflect = new \ReflectionMethod($class, $method);
        $comments = $reflect->getDocComment();
        preg_match_all('#@(.*?)\n#s', $comments, $annotations);

        return $annotations;
    }

    /**
     * @param $class
     * @param $property
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function parsePropertyAnnotation($class, $property) {
        $reflect = new \ReflectionProperty($class, $property);
        $comments = $reflect->getDocComment();
        preg_match_all('#@(.*?)\n#s', $comments, $annotations);

        return $annotations[1];
    }

    /**
     * @param $object
     * @param $methodName
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function convertGetValuesToMethodParameterValues($object, $methodName) {
        return self::convertDataArrayValuesToMethodParameterValues($object, $methodName, $_GET);
    }

    /**
     * @param object $object
     * @param string $methodName
     * @param array $dataArray
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function convertDataArrayValuesToMethodParameterValues($object, $methodName, $dataArray) {
        if(get_class($object) == "Object\Proxy\LazyLoadingSingletonProxy"){
            $object = $object->__getInstance();
        }

        if(method_exists($object,$methodName)) {
            $paramValues = array();

            $reflect = new \ReflectionClass($object);
            $method = $reflect->getMethod($methodName);
            $docComment = $method->getDocComment();
            $annotations = array();
            preg_match_all('#@(.*?)\n#s', $docComment, $annotations);
            foreach ($annotations[0] as $annotation) {
                if (substr(strtolower($annotation), 0, 6) == '@param') {
                    $tokens = preg_split("/[\s]+/", $annotation);
                    $paramValues[] = $dataArray[substr($tokens[2], 1)];
                }
            }

            return $paramValues;
        }
        return array();
    }
}
