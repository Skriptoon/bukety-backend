<?php

namespace App\Filters\Category;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Filters\Filter;

class IsMain extends Filter
{
    public function apply(Builder $query): Builder
    {
        $value = $this->values[0] ?? false;

        if ($value) {
            $query->withoutGlobalScope('visible')
                ->where('show_in_main', true);
        }

        return $query;
    }
}
