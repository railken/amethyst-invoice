<?php

namespace Railken\LaraOre\InvoiceTax\Attributes\UpdatedAt;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class UpdatedAtAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'updated_at';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\InvoiceTaxUpdatedAtNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\InvoiceTaxUpdatedAtNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\InvoiceTaxUpdatedAtNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\InvoiceTaxUpdatedAtNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'invoicetax.attributes.updated_at.fill',
        Tokens::PERMISSION_SHOW => 'invoicetax.attributes.updated_at.show',
    ];

    /**
     * Is a value valid ?
     *
     * @param EntityContract $entity
     * @param mixed          $value
     *
     * @return bool
     */
    public function valid(EntityContract $entity, $value)
    {
        return v::length(1, 255)->validate($value);
    }
}