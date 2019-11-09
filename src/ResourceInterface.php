<?php
namespace Yiisoft\I18n;

interface ResourceInterface extends MessageReaderInterface, MessageWriterInterface
{
    public function sourceLanguage(): ?string;
    public function targetLanguage(): string;
}
