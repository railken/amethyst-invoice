<?php

namespace Railken\LaraOre\Invoice\Attributes\ExpiresAt\Exceptions;

use Railken\LaraOre\Invoice\Exceptions\InvoiceAttributeException;

class InvoiceExpiresAtNotValidException extends InvoiceAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'expires_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'INVOICE_EXPIRES_AT_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
