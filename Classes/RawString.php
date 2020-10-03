<?php
/**
 * stefanwimmer128/html-builder - Classes/RawString.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

/**
 * Class RawString
 * @package Stefanwimmer128\HtmlBuilder
 */
class RawString extends HtmlElement {
    protected string $value;
    
    /**
     * Create RawString
     * @param string $value
     */
    public function __construct(string $value) {
        $this->value = $value;
    }
    
    /**
     * Get value
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }
    
    /**
     * Render element as HTML
     * @return string
     */
    public function render(): string {
        return $this->getValue();
    }
}
