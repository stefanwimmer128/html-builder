<?php
/**
 * stefanwimmer128/html-builder - Classes/Utilities/HtmlBuilderUtility.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Utilities;

/**
 * Class HtmlBuilderUtility
 * @package Stefanwimmer128\HtmlBuilder\Utilities
 */
class HtmlBuilderUtility {
    /**
     * Captures output (echo) and returns it
     * @param callable $callable
     * @param mixed ...$args
     * @return string
     */
    public static function capture(callable $callable, ...$args): string {
        ob_start();
        $callable(...$args);
        return ob_get_clean();
    }
    
    /**
     * array_map with key
     * @param array $array
     * @param callable $callable
     * @return array
     */
    public static function map(array $array, callable $callable): array {
        return array_map($callable, array_values($array), array_keys($array));
    }
}
