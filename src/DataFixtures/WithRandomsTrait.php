<?php

namespace App\DataFixtures;

/**
 * Trait WithRandomsTrait
 *
 * @package App\DataFixtures
 */
trait WithRandomsTrait
{
    /**
     * @param $objects
     *
     * @return mixed
     */
    protected function randomObject($objects)
    {
        return $objects[rand(0, count($objects) - 1)];
    }
}
