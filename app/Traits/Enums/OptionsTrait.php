<?php

declare(strict_types=1);

namespace App\Traits\Enums;

trait OptionsTrait
{
    abstract public function label(): string;

    /**
     * @return array<array<string, string>>
     */
    public static function getOptions(): array
    {
        $cases = self::cases();

        $options = [];
        foreach ($cases as $item) {
            $options[] = [
                'id' => $item->value,
                'name' => $item->label(),
            ];
        }

        return $options;
    }
}
