<?php

declare(strict_types=1);

namespace SeoBakery\Test\SeoObjects;

use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwarePageObject;

class AboutUsSeoPageObject extends SeoAwarePageObject implements SeoAwareInterface
{
    /**
     * returns the template path for the Pages template
     * i.e. /profile/about or /contact
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return '/profile/about';
    }
}
