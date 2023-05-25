<?php
declare(strict_types=1);

namespace SeoBakery\Test\SeoObjects;

use Cake\ORM\Entity;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareInterface;

class Product extends Entity implements SeoAwareInterface
{
    use SeoAwareEntityTrait;
}
