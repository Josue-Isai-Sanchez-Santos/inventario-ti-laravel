<?php

namespace App\Support;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

class QrGenerator
{
    public static function generarParaActivo(string $token): string
    {
        $publicUrl = rtrim(env('APP_PUBLIC_URL', config('app.url')), '/').'/a/'.$token;

        $qrCode = new QrCode(
            data: $publicUrl,
            size: 300,
            margin: 10
        );

        $writer = new SvgWriter;
        $result = $writer->write($qrCode);

        $fileName = 'qrs/'.$token.'.svg';
        $fullPath = storage_path('app/public/'.$fileName);

        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $result->saveToFile($fullPath);

        return $fileName;
    }
}
