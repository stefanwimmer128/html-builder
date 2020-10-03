<?php

namespace Stefanwimmer128\HtmlBuilder\Test;

use JsonException;
use Stefanwimmer128\HtmlBuilder\Parser\ParserException;
use function Stefanwimmer128\HtmlBuilder\capture;
use function Stefanwimmer128\HtmlBuilder\h;
use function Stefanwimmer128\HtmlBuilder\map;
use function Stefanwimmer128\HtmlBuilder\render;

class HtmlBuilderTest extends AbstractTestCase {
    /**
     * @throws JsonException
     */
    public function testBuilder(): void {
        $test = '<p>TEST</p>';
        
        $values = [
            'a' => 0,
            'b' => 1,
            'c' => 2,
        ];
        
        $html = sprintf('<?xml version="1.0" standalone="yes" ?>%s',
            sprintf('<!DOCTYPE html>%s',
                sprintf('<html lang="en">%s%s</html>',
                    sprintf('<head>%s</head>',
                        sprintf('<title>%s</title>', 'Hello World!')
                    ),
                    sprintf('<body>%s%s%s</body>',
                        sprintf('<div class="container container-content" id="container-content-main">%s%s%s</div>',
                            sprintf('<a href="#" disabled>%s</a>', 'LINK'),
                            '&lt;p&gt;TEST&lt;/p&gt;',
                            $test
                        ),
                        '<!-- COMMENT -->',
                        sprintf('<p data-values="%s">%s%s%s%s%s</p>', htmlspecialchars(json_encode($values, JSON_THROW_ON_ERROR)),
                            sprintf('<b>%s</b>', 'LIST:'),
                            '<br />',
                            ...map($values, fn($value, $key) => sprintf('<span data-key="%s">%s</span>', $key, $value))
                        )
                    )
                )
            )
        );
        
        $builder = h('xml[version="1.0"][standalone=yes]', [], [
            h('doctype', 'html', [
                h('html[lang=en]', [], [
                    h('head > title{Hello World!}'),
                    h('body', [], [
                        h('.container.container-content#container-content-main', [], [
                            h('a[href="#" disabled]', 'LINK'),
                            '<p>TEST</p>',
                            capture('printf', '%s', $test)
                        ]),
                        h('comment', 'COMMENT'),
                        h('p', ['data-values' => json_encode($values, JSON_THROW_ON_ERROR)], [
                            h('b', 'LIST:'),
                            h('br'),
                            map($values, fn($value, $key) => h('span', ['data-key' => $key], $value))
                        ])
                    ])
                ])
            ])
        ]);
        
        self::assertEqualsCallback($html, render($builder), function () use ($html, $builder) {
            dump($html);
            dump($builder);
        });
    }
    
    /**
     * @param $tag
     * @param $words
     * @dataProvider loremIpsumProvider
     */
    public function testLoremIpsum($tag, $words): void {
        self::assertEquals($words, str_word_count(render(h($tag))));
    }
    
    public function loremIpsumProvider(): array {
        return [
            'lorem' => ['lorem', 30],
            'lorem10' => ['lorem10', 10],
            'lipsum20' => ['lipsum20', 20],
            'lorem30' => ['lorem30', 30],
            'lipsum40' => ['lipsum40', 40],
        ];
    }
    
    /**
     * @param string $emmet
     * @dataProvider invalidEmmetProvider
     */
    public function testInvalidEmmet(string $emmet): void {
        $this->expectExceptionObject(new ParserException($emmet));
        
        dump(h($emmet));
    }
    
    /**
     * @return array
     */
    public function invalidEmmetProvider(): array {
        return [
            'empty' => [''],
            'empty with child' => ['> #test'],
            'empty with text' => ['{text}'],
            'error in child' => ['test > error?'],
        ];
    }
    
    /**
     * @param string $parent
     * @param string $child
     * @dataProvider emmetImplicitTagsProvider
     */
    public function testEmmetImplicitTags(string $parent, string $child): void {
        self::assertEquals(render(h(sprintf('%s > %s#test', $parent, $child))), render(h(sprintf('%s > #test', $parent))));
    }
    
    public function emmetImplicitTagsProvider(): array {
        return [
            'div' => ['div', 'div'],
            'p' => ['p', 'span'],
            'ul' => ['ul', 'li'],
            'ol' => ['ol', 'li'],
            'table' => ['table', 'tr'],
            'tr' => ['tr', 'td'],
            'tbody' => ['tbody', 'tr'],
            'thead' => ['thead', 'tr'],
            'tfoot' => ['tfoot', 'tr'],
            'colgroup' => ['colgroup', 'col'],
            'select' => ['select', 'option'],
            'optgroup' => ['optgroup', 'option'],
            'audio' => ['audio', 'source'],
            'video' => ['video', 'source'],
            'object' => ['object', 'param'],
            'map' => ['map', 'area'],
        ];
    }
}
