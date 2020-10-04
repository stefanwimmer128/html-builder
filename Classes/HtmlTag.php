<?php
/**
 * stefanwimmer128/html-builder - Classes/HtmlTag.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

use Stefanwimmer128\HtmlBuilder\Components\AttributeSet;
use Stefanwimmer128\HtmlBuilder\Components\ElementList;
use Stefanwimmer128\HtmlBuilder\Parser\ParserCompatibleElement;

/**
 * Class HtmlTag
 * @package Stefanwimmer128\HtmlBuilder
 */
class HtmlTag extends HtmlElement implements CustomTagElement, ParserCompatibleElement {
    /**
     * @var array|string[] Tags that dont have content and self-close
     */
    public static array $VOID_TAGS = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen',
        'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr',
    ];
    
    protected string $tag;
    protected AttributeSet $attributes;
    protected ElementList $children;
    protected ?bool $isSelfclosing;
    
    /**
     * Create HtmlTag
     * @param string $tag
     * @param mixed ...$args if fist value is an array it is considered to be the tags arguments
     */
    public function __construct(string $tag = 'div', ...$args) {
        $this->setTag($tag);
        $this->setAttributes(count($args) > 0 && is_array($args[0]) ? array_shift($args) : []);
        $this->setChildren($args);
    }
    
    /**
     * Get tag of element
     * @return string
     */
    public function getTag(): string {
        return $this->tag;
    }
    
    /**
     * Set tag of element
     * @param string $tag
     */
    public function setTag(string $tag): void {
        $this->tag = $tag;
    }
    
    /**
     * Get attribute of element
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key) {
        return $this->attributes->getAttribute($key);
    }
    
    /**
     * Set attribute of element
     * @param string $key
     * @param $value
     */
    public function setAttribute(string $key, $value): void {
        $this->attributes->setAttribute($key, $value);
    }
    
    /**
     * Remove attribute from element
     * @param string $key
     */
    public function removeAttribute(string $key): void {
        $this->attributes->removeAttribute($key);
    }
    
    /**
     * Add attributes to element
     * @param array $attributes
     */
    public function addAttributes(array $attributes): void {
        $this->attributes->addAttributes($attributes);
    }
    
    /**
     * Set attributes of element
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void {
        $this->attributes = new AttributeSet($attributes);
    }
    
    /**
     * Get classes of element
     * @return array
     */
    public function getClasses(): array {
        if (preg_match_all('/[\w-]+/', $this->getAttribute('class') ?? '', $classes)) {
            return array_unique($classes[0]);
        }
        
        return [];
    }
    
    /**
     * Set classes of element
     * @param array $classes
     */
    public function setClasses(array $classes): void {
        $this->setAttribute('class', implode(' ', array_unique($classes)));
    }
    
    /**
     * Add classes to element
     * @param array $classes
     */
    public function addClasses(array $classes): void {
        $this->setClasses(array_merge($this->getClasses(), $classes));
    }
    
    /**
     * Add class to element
     * @param string $class
     */
    public function addClass(string $class): void {
        $this->addClasses([$class]);
    }
    
    /**
     * Remove classes from element
     * @param array $classes
     */
    public function removeClasses(array $classes): void {
        $this->setClasses(array_diff($this->getClasses(), $classes));
    }
    
    /**
     * Remove class from element
     * @param string $class
     */
    public function removeClass(string $class): void {
        $this->removeClasses([$class]);
    }
    
    /**
     * Set id of element
     * @param string $id
     */
    public function setId(string $id): void {
        $this->setAttribute('id', $id);
    }
    
    /**
     * Set children of element
     * @param array $children
     */
    public function setChildren(array $children): void {
        $this->children = new ElementList($children);
    }
    
    public function isSelfclosing(): bool {
        return $this->isSelfclosing ?? in_array($this->tag, self::$VOID_TAGS, true);
    }
    
    public function setSelfclosing(?bool $isSelfclosing): void {
        $this->isSelfclosing = $isSelfclosing;
    }
    
    public function renderAttributes(): string {
        return $this->attributes->render();
    }
    
    public function renderChildren(): string {
        return $this->children->render();
    }
    
    public function render(): string {
        if ($this->isSelfclosing()) {
            return sprintf('<%s%s />', $this->tag, $this->renderAttributes());
        }
        
        return sprintf('<%s%s>%s</%1$s>', $this->tag, $this->renderAttributes(), $this->renderChildren());
    }
}
