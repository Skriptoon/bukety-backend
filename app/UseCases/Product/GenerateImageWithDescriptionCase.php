<?php

declare(strict_types=1);

namespace App\UseCases\Product;

use App\Models\Product;
use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Storage;

class GenerateImageWithDescriptionCase
{
    private const string FONT = 'calibri.ttf';
    private const int FONT_SIZE = 16;
    public function handle(Product $product): string
    {
        $productImage = Image::fromFile(Storage::disk('public')->path($product->image));
        $ingredientsText = $this->generateText('Состав: ' .  $product->ingredients->implode('name', ', '), $productImage->getWidth());
        $ingredientsTextSize = Image::calculateTextBox($ingredientsText, resource_path('fonts/'.self::FONT), self::FONT_SIZE);

        $image = Image::fromBlank(
            $productImage->getWidth(),
            $productImage->getHeight() + 60 + $ingredientsTextSize['height'],
            ImageColor::rgb(0, 0, 0)
        );

        $image->place($productImage);

        $image->ttfText(
            24,
            0,
            0,
            $productImage->getHeight() + 30,
            ImageColor::rgb(255, 255, 255),
            resource_path('fonts/'.self::FONT),
            'Цена: ' . $product->price . 'р',
        );

        $image->ttfText(
            self::FONT_SIZE,
            0,
            0,
            $productImage->getHeight() + 60,
            ImageColor::rgb(255, 255, 255),
            resource_path('fonts/'.self::FONT),
            $this->generateText('Состав: ' .  $product->ingredients->implode('name', ', '), $productImage->getWidth()),
        );

        $filename = 'image-with-description.png';
        $image->save(Storage::path($filename));

        return $filename;
    }

    private function generateText(string $text, int $width): string
    {
        $arr = explode(' ', $text);

        $ret = "";

        foreach ($arr as $word) {
            $tmp_string = $ret.' '.$word;

            $textbox = Image::calculateTextBox($tmp_string, resource_path('fonts/'.self::FONT), self::FONT_SIZE);

            if ($textbox['width'] > $width) {
                $ret .= ($ret == "" ? "" : "\n") . $word;
            } else {
                $ret .= ($ret == "" ? "" : " ") . $word;
            }
        }

        return $ret;
    }
}
