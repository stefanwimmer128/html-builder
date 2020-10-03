<?php
/**
 * stefanwimmer128/html-builder - Classes/Components/AttributeSet.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Components;

use Stefanwimmer128\HtmlBuilder\Utilities\HtmlBuilderUtility;

/**
 * Class AttributeSet
 * @package Stefanwimmer128\HtmlBuilder\Components
 */
class AttributeSet {
    /**
     * Checks whether the attribute value is empty
     * @param $value
     * @return bool
     */
    public static function isAttributeEmpty($value): bool {
        return $value === null || $value === false || $value === '';
    }
    
    protected array $attributes = [];
    
    /**
     * Create AttributeSet
     * @param array $attributes Attributes to initialize AttributeSet with
     */
    public function __construct(array $attributes) {
        $this->addAttributes($attributes);
    }
    
    /**
     * Get attribute from set
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key) {
        return $this->attributes[$key] ?? null;
    }
    
    /**
     * Set attribute in set
     * @param string $key
     * @param $value
     */
    public function setAttribute(string $key, $value): void {
        if (self::isAttributeEmpty($value)) {
            $this->removeAttribute($key);
        } else {
            $this->attributes[$key] = $value;
        }
    }
    
    /**
     * Remove attribute from set
     * @param string $key
     */
    public function removeAttribute(string $key): void {
        unset($this->attributes[$key]);
    }
    
    /**
     * Add attributes to set
     * @param array $attributes
     */
    public function addAttributes(array $attributes): void {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }
    
    /**
     * Render attributes as HTML
     * @return string starts with a space when attributes are present
     */
    public function render(): string {
        return implode('', HtmlBuilderUtility::map($this->attributes, function ($value, $key) {
            if (self::isAttributeEmpty($value)) {
                return '';
            }
            
            if ($value === true) {
                return sprintf(' %s', $key);
            }
            
            return sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }));
    }
}
