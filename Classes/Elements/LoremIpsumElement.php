<?php
/**
 * stefanwimmer128/html-builder - Classes/Elements/LoremIpsumElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Elements;

use joshtronic\LoremIpsum;
use Stefanwimmer128\HtmlBuilder\CustomTagElement;
use Stefanwimmer128\HtmlBuilder\HtmlText;

/**
 * Class LoremIpsumElement
 * @package Stefanwimmer128\HtmlBuilder\Elements
 */
class LoremIpsumElement extends HtmlText implements CustomTagElement {
    protected static LoremIpsum $loremIpsum;
    
    /**
     * Get LoremIpsum Generator
     * @return LoremIpsum
     */
    public static function getLoremIpsum(): LoremIpsum {
        return self::$loremIpsum ?? self::$loremIpsum = new LoremIpsum();
    }
    
    protected int $words;
    
    /**
     * Create LoremElement
     * @param int $words
     */
    public function __construct(int $words = 30) {
        parent::__construct('');
        
        $this->words = $words;
    }
    
    public function setTag(string $tag): void {
        if (preg_match('/^(?:lorem|lipsum)(\d+)$/', $tag, $matches)) {
            $this->words = (int) $matches[1];
        }
    }
    
    public function getText(): string {
        return self::getLoremIpsum()->words($this->words);
    }
}
