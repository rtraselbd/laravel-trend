<?php

namespace Flowframe\Trend\Adapters;

use Error;

class PgsqlAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval, string $timezone): string
    {
        $format = match ($interval) {
            'minute' => 'YYYY-MM-DD HH24:MI:00',
            'hour' => 'YYYY-MM-DD HH24:00:00',
            'day' => 'YYYY-MM-DD',
            'week' => 'IYYY-IW',
            'month' => 'YYYY-MM',
            'year' => 'YYYY',
            default => throw new Error('Invalid interval.'),
        };

        if ($timezone !== 'UTC') {
            return "to_char(\"{$column}\" AT TIME ZONE 'UTC' AT TIME ZONE '{$timezone}', '{$format}')";
        }

        return "to_char(\"{$column}\", '{$format}')";
    }
}
