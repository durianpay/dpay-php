<?php

namespace Durianpay\Resources;

interface ResourceInterface
{
    public static function getResourceUri(): string;
    public static function getRequiredOptions(string $api): array;
}
