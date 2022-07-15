<?php

namespace Durianpay\Resources;

/**
 * Resource Interface
 * 
 * @category Interface
 */
interface ResourceInterface
{
    public static function getResourceUri(): string;
    public static function getRequiredOptions(string $api): array;
}
