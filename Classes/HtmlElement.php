<?php
/**
 * stefanwimmer128/html-builder - Classes/HtmlElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

use Stefanwimmer128\HtmlBuilder\Elements\CommentElement;
use Stefanwimmer128\HtmlBuilder\Elements\DoctypeElement;
use Stefanwimmer128\HtmlBuilder\Elements\LoremIpsumElement;
use Stefanwimmer128\HtmlBuilder\Elements\XmlElement;
use Stringable;

/**
 * Class HtmlElement
 * @package Stefanwimmer128\HtmlBuilder
 */
abstract class HtmlElement implements Stringable {
    /**
     * @var string[] Elements with custom implementation
     */
    public static array $ELEMENTS = [
        'comment' => CommentElement::class,
        'doctype' => DoctypeElement::class,
        'xml' => XmlElement::class,
        '/^(lorem|lipsum)\d*$/' => LoremIpsumElement::class,
    ];
    
    /**
     * Get element class name by tag
     * @param string $tag
     * @return string|null
     */
    public static function getClassName(string $tag): ?string {
        foreach (array_keys(self::$ELEMENTS) as $key) {
            if ($key[0] === '/' && preg_match($key, $tag)) {
                return self::$ELEMENTS[$key];
            }
            
            if ($key === $tag) {
                return self::$ELEMENTS[$key];
            }
        }
        
        return null;
    }
    
    /**
     * Create element by tag
     * @param string $tag
     * @param mixed ...$args
     * @return HtmlElement
     */
    public static function create(string $tag, ...$args): HtmlElement {
        $element = ($className = self::getClassName($tag)) && class_exists($className) ? new $className(...$args) : new HtmlTag($tag, ...$args);
        
        if ($element instanceof CustomTagElement) {
            $element->setTag($tag);
        }
        
        return $element;
    }
    
    /**
     * Render the element as HTML
     * @return string
     */
    abstract public function render(): string;
    
    /**
     * Alias for render()
     * @see HtmlElement::render()
     * @return string
     */
    public function __toString() {
        return $this->render();
    }
}
