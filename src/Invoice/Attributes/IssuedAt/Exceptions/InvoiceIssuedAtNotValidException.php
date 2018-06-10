<?php

namespace Railken\LaraOre\Invoice\Attributes\IssuedAt\Exceptions;

use Railken\LaraOre\Invoice\Exceptions\InvoiceAttributeException;

class InvoiceIssuedAtNotValidException extends InvoiceAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'issued_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'INVOICE_ISSUED_AT_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}