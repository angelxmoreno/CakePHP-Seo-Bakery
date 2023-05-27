<?php
declare(strict_types=1);

namespace SeoBakery\Shared;

class InstanceUses
{
    /**
     * Checks if an object uses a trait
     *
     * @param object $instance the instance to check
     * @param string $trait the trait to check against $instance
     * @return bool returns true if $instance uses $trait
     */
    public static function check(object $instance, string $trait): bool
    {
        return in_array($trait, class_uses($instance), true);
    }
}

