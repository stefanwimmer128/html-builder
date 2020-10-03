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
     * Create element from emmet
     * @package Stefanwimmer128\HtmlBuilder
     * @param string $input
     * @param mixed ...$args
     * @return HtmlElement
     */
    function h(string $input, ...$args): HtmlElement {
        return AbstractParser::parse($input)->toElement(...$args);
    }
}

if (! function_exists(__NAMESPACE__ . '\tag')) {
    /**
     * Create tag element
     * @package Stefanwimmer128\HtmlBuilder
     * @param string $tag
     * @param array $attributes
     * @param array $children
     * @return HtmlTag
     */
    function tag(string $tag, array $attributes = [], array $children = []): HtmlTag {
        return new HtmlTag($tag, $attributes, $children);
    }
}

if (! function_exists(__NAMESPACE__ . '\text')) {
    /**
     * Create text element
     * @package Stefanwimmer128\HtmlBuilder
     * @param string $text
     * @return HtmlText
     */
    function text(string $text): HtmlText {
        return new HtmlText($text);
    }
}

if (! function_exists(__NAMESPACE__ . '\raw')) {
    /**
     * Create raw element
     * @package Stefanwimmer128\HtmlBuilder
     * @param string $value
     * @return RawString
     */
    function raw(string $value): RawString {
        return new RawString($value);
    }
}

if (! function_exists(__NAMESPACE__ . '\capture')) {
    /**
     * Captures output (echo) and returns it as RawString
     * @package Stefanwimmer128\HtmlBuilder
     * @param callable $callable
     * @param mixed ...$args
     * @return RawString
     */
    function capture(callable $callable, ...$args): RawString {
        return raw(HtmlBuilderUtility::capture($callable, ...$args));
    }
}

if (! function_exists(__NAMESPACE__ . '\map')) {
    /**
     * array_map with keys
     * @package Stefanwimmer128\HtmlBuilder
     * @param array $array
     * @param callable $callable
     * @return array
     */
    function map(array $array, callable $callable): array {
        return HtmlBuilderUtility::map($array, $callable);
    }
}

if (! function_exists(__NAMESPACE__ . '\render')) {
    /**
     * Render elements as HTML
     * @package Stefanwimmer128\HtmlBuilder
     * @param mixed $elements
     * @return string
     */
    function render($elements): string {
        return (new ElementList([$elements]))->render();
    }
}
