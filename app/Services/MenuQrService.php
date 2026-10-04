<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class MenuQrService
{
    public function itemPayload(array $item): string
    {
        return route('menu.show', ['slug' => $item['slug']]);
    }

    public function paymentPayload(array $item): string
    {
        $shop = config('gad.shop');

        return sprintf(
            'AYAM GEPUK GAD | %s | RM%.2f | DuitNow: %s | %s',
            $item['name'],
            $item['price'],
            $shop['duitnow_id'] ?? '',
            $shop['name'] ?? 'Ayam Gepuk GAD'
        );
    }

    public function png(string $text, int $size = 300, int $margin = 10): string
    {
        $result = (new Builder(
            writer: new PngWriter,
            writerOptions: [],
            validateResult: false,
            data: $text,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: $size,
            margin: $margin,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        ))->build();

        return $result->getString();
    }

    public function dataUri(string $text, int $size = 300): string
    {
        $result = (new Builder(
            writer: new PngWriter,
            writerOptions: [],
            validateResult: false,
            data: $text,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: $size,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        ))->build();

        return $result->getDataUri();
    }

    public function findItem(string $slug): ?array
    {
        foreach (config('gad.menu', []) as $item) {
            if ($item['slug'] === $slug) {
                return $item;
            }
        }

        return null;
    }
}
