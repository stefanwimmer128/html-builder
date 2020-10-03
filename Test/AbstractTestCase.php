<?php

namespace Stefanwimmer128\HtmlBuilder\Test;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase {
    /**
     * @param $expected
     * @param $actual
     * @param callable|null $onFail
     * @param string $message
     * @see AbstractTestCase::assertEquals()
     */
    public static function assertEqualsCallback($expected, $actual, callable $onFail, string $message = ''): void {
        try {
            self::assertEquals($expected, $actual, $message);
        } catch (ExpectationFailedException $e) {
            if (is_callable($onFail)) {
                $onFail($e);
            }
            throw $e;
        }
    }
}
