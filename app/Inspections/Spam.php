<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 24/08/2018
 * Time: 01:29
 */

namespace App\Inspections;

use App\Inspections\InvalidKeywords;
use App\Inspections\KeyHeldDown;

class Spam
{
    /**
     * All registered inspections.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @return bool
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
