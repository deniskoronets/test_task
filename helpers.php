<?php

use Carbon\Carbon;

/**
 * NOW in utc
 * @return Carbon
 */
function now()
{
    return Carbon::now('UTC');
}

/**
 * Parse in UTC timezne
 * @param $date
 * @return Carbon
 */
function parseDate($date)
{
    return Carbon::parse($date, 'UTC');
}