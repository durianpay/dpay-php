<?php

namespace Durianpay\Resources;

use \Durianpay\Resources\ResourceInterface as ResourceInterface;

class Payment implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri(): string
    {
        return 'payments';
    }

    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'create':
                return [];
            default:
                return [];
        }
    }
}
