<?php
declare(strict_types=1);

namespace WalleetPivot;

use RuntimeException;

/**
 * A dummy object to hold common secret data
 */
class Secret
{
    protected string $username;

    protected string $password;

    protected bool $favorite;

    protected string $notes;

    protected array $customs;

    protected bool $dirty = false;

    public function __construct(
        protected string $type,
        protected string $title,
        protected string $group,
      ) {}

    /**
     * Generic getter
     *
     * @param  string $name Property name
     * @return mixed
     */
    public function __get($name): mixed
    {
        if (!isset($this->{$name})) {
            throw new RuntimeException("Property {$name} doesn't exists.");
        }

        return $this->{$name};
    }

    /**
     * Generic setter
     *
     * @param string $name  Property name
     * @param mixed  $value Value to property
     */
    public function __set(string $name, $value): void
    {
        if (!isset($this->{$name})) {
            throw new RuntimeException("Property {$name} doesn't exists.");
        }

        $this->{$name} = $value;
        $this->dirty = true;
    }

    /**
     * Is secret changed?
     *
     * @return boolean
     */
    public function isDirty(): bool
    {
        return $this->dirty;
    }
}