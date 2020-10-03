<?php
/**
 * stefanwimmer128/html-builder - Classes/Elements/DoctypeElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Elements;

use Stefanwimmer128\HtmlBuilder\HtmlTag;

/**
 * Class DoctypeElement
 * @package Stefanwimmer128\HtmlBuilder\Elements
 */
class DoctypeElement extends HtmlTag {
    protected string $doctype;
    
    /**
     * Create DoctypeElement
     * @param string $doctype
     * @param mixed ...$children
     */
    public function __construct(string $doctype, ...$children) {
        parent::__construct('doctype', [], ...$children);
        
        $this->doctype = $doctype;
    }
    
    /**
     * Get doctype
     * @return string
     */
    public function getDoctype(): string {
        return $this->doctype;
    }
    
    /**
     * Render doctype as HTML
     * @return string
     */
    public function render(): string {
        return sprintf('<!DOCTYPE %s>%s', $this->getDoctype(), $this->renderChildren());
    }
}
