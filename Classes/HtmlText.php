<?php
/**
 * stefanwimmer128/html-builder - Classes/HtmlText.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

/**
 * Class HtmlText
 * @package Stefanwimmer128\HtmlBuilder
 */
class HtmlText extends HtmlElement {
    protected string $text;
    
    /**
     * Create HtmlText
     * @param string $text
     */
    public function __construct(string $text = '') {
        $this->text = $text;
    }
    
    /**
     * Get text
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }
    
    /**
     * Render element as HTML
     * @return string
     */
    public function render(): string {
        return htmlentities($this->getText());
    }
}
