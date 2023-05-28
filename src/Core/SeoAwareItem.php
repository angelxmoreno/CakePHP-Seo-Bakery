<?php

declare(strict_types=1);

namespace SeoBakery\Core;

use SeoBakery\Shared\InstanceUses;
use UnexpectedValueException;

class SeoAwareItem
{
    public const TYPE_PAGE = 'page';
    public const TYPE_LIST_VIEW = 'listView';
    public const TYPE_ENTITY = 'entity';

    protected string $type;
    protected string $className;
    protected array $actions;
    protected SeoAwareInterface $instance;

    /**
     * @param SeoAwareInterface $instance
     */
    public function __construct(SeoAwareInterface $instance)
    {
        $this->className = get_class($instance);
        $type = null;
        if (is_subclass_of($instance, SeoAwarePageObject::class)) {
            $type = self::TYPE_PAGE;
        } elseif (is_subclass_of($instance, SeoAwareListViewObject::class)) {
            $type = self::TYPE_LIST_VIEW;
        } elseif (InstanceUses::check($instance, SeoAwareEntityTrait::class)) {
            $type = self::TYPE_ENTITY;
        }

        if ($type === null) {
            $message = sprintf('%s is not a valid %s', $this->className, SeoAwareInterface::class);
            throw new UnexpectedValueException($message);
        }

        $this->type = $type;
        $this->actions = $instance->actions();
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return SeoAwareInterface
     */
    public function getInstance(): SeoAwareInterface
    {
        return $this->instance;
    }
}
