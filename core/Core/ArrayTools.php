<?php

namespace                       Core;

/**
 * Fournit des outils pour manipuler les tableaux.
 *
 * Class ArrayTools
 * @package Core
 */
class                           ArrayTools {
    /**
     * Checks if an array is associative.
     *
     * @param array $arr        The array
     *
     * @return bool             TRUE if the array is associative, else FALSE.
     */
    public static function      isAssoc($arr) {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Applies array_merge recursively.
     *
     * @param array $arr1       The first array
     * @param array $arr2       The second array
     * @param string $exclude   The value to exclude
     *
     * @return array            The merged array.
     */
    public static function      recursiveMerge($arr1, $arr2, $exclude = '') {
        $ret = $arr1;
        if (!is_array($ret))
            return $arr2;
        foreach ($arr2 as $k => $v) {
            if (isset($ret[$k])) {
                if (is_array($v)) {
                    if (!self::isAssoc($v))
                        $ret[$k] = array_merge($ret[$k], $v);
                    else
                        $ret[$k] = self::recursiveMerge($ret[$k], $v);
                } elseif ($v !== $exclude)
                    $ret[$k] = $v;
            } else {
                $ret[$k] = $v;
            }
        }
        return $ret;
    }

    /**
     * Returns the value in an array, if $val isn't an array.
     *
     * @param mixed $val        The value
     *
     * @return array            The array
     */
    public static function      getAsArray($val) {
        if (!is_array($val))
            $val = [$val];
        return $val;
    }
}