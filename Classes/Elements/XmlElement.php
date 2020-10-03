<?php
/**
 * stefanwimmer128/html-builder - Classes/Elements/XmlElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Elements;

use Stefanwimmer128\HtmlBuilder\HtmlTag;

/**
 * Class XmlElement
 * @package Stefanwimmer128\HtmlBuilder\Elements
 */
class XmlElement extends HtmlTag {
    /**
     * Create XmlElement
     * @param array $attributes
     * @param array ...$children
     */
    public function __construct(array $attributes = [], array ...$children) {
        parent::__construct('xml', $attributes, $children);
    }
    
    /**
     * Render xml as HTML
     * @return string
     */
    public function render(): string {
        return sprintf('<?xml%s ?>%s', $this->renderAttributes(), $this->renderChildren());
    }
}
