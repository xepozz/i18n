<?php

namespace Yii\I18n\Tests;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Yiisoft\I18n\Event\MissingTranslationEvent;
use Yiisoft\I18n\TranslationsLoaderInterface;
use Yiisoft\I18n\Translator;
use Yiisoft\I18n\TranslatorInterface;

class TranslatorTest extends TestCase
{
    /**
     * @dataProvider getTranslations
     * @param $message
     * @param $translate
     */
    public function testTranslation($message, $translate)
    {
        $translationsLoader = $this->getMockBuilder(TranslationsLoaderInterface::class)
            ->setMethods(['loadMessages'])
            ->getMock();

        $translator = $this->getMockBuilder(Translator::class)
            ->setConstructorArgs([
                $this->createMock(EventDispatcherInterface::class),
                $translationsLoader,
            ])
            ->enableProxyingToOriginalMethods()
            ->setMethods(['translate'])
            ->getMock();

        $translationsLoader->expects($this->once())
            ->method('loadMessages')
            ->willReturn([$message => $translate]);

        $this->assertEquals($translate, $translator->translate($message));
    }

    public function testMissingEventTriggered()
    {
        $category = 'test';
        $language = 'en';
        $message = 'Message';

        $eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $translator = $this->getMockBuilder(Translator::class)
            ->setConstructorArgs([
                $eventDispatcher,
                $this->createMock(TranslationsLoaderInterface::class),
            ])
            ->enableProxyingToOriginalMethods()
            ->getMock();

        $eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(new MissingTranslationEvent($category, $language, $message));

        $translator->translate($message, $category, $language);
    }

    private function getTranslator(): TranslatorInterface
    {
        return $this->createMock(Translator::class);
    }

    public function getTranslations(): array
    {
        return [
            [null, null],
            [1, 1],
            ['test', 'test'],
        ];
    }
}