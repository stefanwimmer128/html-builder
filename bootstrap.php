<?php
/**
 * stefanwimmer128/html-builder - bootstrap.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

use Stefanwimmer128\HtmlBuilder\Components\ElementList;
use Stefanwimmer128\HtmlBuilder\Parser\AbstractParser;
use Stefanwimmer128\HtmlBuilder\Utilities\HtmlBuilderUtility;

if (! function_exists(__NAMESPACE__ . '\h')) {
    /**
     * Create element from input using parser (default: Emmet)
     * @param string $input
     * @param mixed ...$args
     * @return HtmlElement
     * @package Stefanwimmer128\HtmlBuilder
     */
    function h(string $input, ...$args): HtmlElement {
        return AbstractParser::parse($input)->toElement(...$args);
    }
}

if (! function_exists(__NAMESPACE__ . '\tag')) {
    /**
     * Create tag element
     * @param string $tag
     * @param mixed ...$args
     * @return HtmlTag
     * @package Stefanwimmer128\HtmlBuilder
     */
    function tag(string $tag = 'div', ...$args): HtmlTag {
        return new HtmlTag($tag, ...$args);
    }
}

if (! function_exists(__NAMESPACE__ . '\text')) {
    /**
     * Create text element
     * @param string $text
     * @return HtmlText
     * @package Stefanwimmer128\HtmlBuilder
     */
    function text(string $text): HtmlText {
        return new HtmlText($text);
    }
}

if (! function_exists(__NAMESPACE__ . '\raw')) {
    /**
     * Create raw string
     * @param string $value
     * @return RawString
     * @package Stefanwimmer128\HtmlBuilder
     */
    function raw(string $value): RawString {
        return new RawString($value);
    }
}

if (! function_exists(__NAMESPACE__ . '\capture')) {
    /**
     * Captures output (echo) and returns it as raw string
     * @param callable $callable
     * @param mixed ...$args
     * @return RawString
     * @package Stefanwimmer128\HtmlBuilder
     */
    function capture(callable $callable, ...$args): RawString {
        return raw(HtmlBuilderUtility::capture($callable, ...$args));
    }
}

if (! function_exists(__NAMESPACE__ . '\map')) {
    /**
     * array_map with keys
     * @param array $array
     * @param callable $callable
     * @return array
     * @package Stefanwimmer128\HtmlBuilder
     */
    function map(array $array, callable $callable): array {
        return HtmlBuilderUtility::map($array, $callable);
    }
}

if (! function_exists(__NAMESPACE__ . '\render')) {
    /**
     * Render elements as HTML
     * @param mixed ...$elements
     * @return string
     * @package Stefanwimmer128\HtmlBuilder
     */
    function render(...$elements): string {
        return (new ElementList($elements))->render();
    }
}
