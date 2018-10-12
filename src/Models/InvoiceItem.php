<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use MathParser\Interpreting\Evaluator;
use MathParser\StdMathParser;
use Money\Currency;
use Money\Money;
use Railken\Amethyst\Schemas\InvoiceItemSchema;
use Railken\Lem\Contracts\EntityContract;

/**
 * @property string  $name
 * @property string  $description
 * @property float   $price
 * @property float   $quantity
 * @property Invoice $invoice
 * @property Tax     $tax
 */
class InvoiceItem extends Model implements EntityContract
{
    use SoftDeletes;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('amethyst.invoice.managers.invoice-item.table');
        $this->fillable = (new InvoiceItemSchema())->getNameFillableAttributes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * Readable price.
     *
     * @param Money $price
     *
     * @return string
     */
    public function formatPrice(Money $price)
    {
        return $this->invoice->formatPrice($price);
    }

    /**
     * Calculate the price tax.
     *
     * @return Money
     */
    public function calculatePriceTax()
    {
        $expression = $this->tax->calculator;

        $parser = new StdMathParser();
        $AST = $parser->parse($this->tax->calculator);
        $evaluator = new Evaluator();
        $evaluator->setVariables(['x' => $this->calculatePriceTaxable()->getAmount() / 100]);
        $value = $AST->accept($evaluator);
        $money = new Money(round($value, 2, PHP_ROUND_HALF_UP) * 100, new Currency($this->invoice->currency));

        return $money;
    }

    /**
     * Calculate the price taxed.
     *
     * @return Money
     */
    public function calculatePriceTaxed()
    {
        return $this->calculatePriceTaxable()->add($this->calculatePriceTax());
    }

    /**
     * Calculate the price taxable.
     *
     * @return Money
     */
    public function calculatePriceTaxable()
    {
        $money = new Money(round($this->price, 2, PHP_ROUND_HALF_UP) * 100, new Currency($this->invoice->currency));

        return $money;
    }
}