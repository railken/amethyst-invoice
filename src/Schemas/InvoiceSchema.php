<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Attributes as AmethystAttributes;
use Railken\Amethyst\Managers\LegalEntityManager;
use Railken\Amethyst\Managers\TaxManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class InvoiceSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('number')
                ->setUnique(true),
            Attributes\BelongsToAttribute::make('sender_id')
                ->setRelationName('sender')
                ->setRelationManager(LegalEntityManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('recipient_id')
                ->setRelationName('recipient')
                ->setRelationManager(LegalEntityManager::class)
                ->setRequired(true),
            AmethystAttributes\TaxonomyAttribute::make('type_id', Config::get('amethyst.invoice.data.invoice.taxonomy'))
                ->setRelationName('type'),
            AmethystAttributes\CountryAttribute::make('country')
                ->setRequired(true),
            AmethystAttributes\Invoice\CurrencyAttribute::make('currency')
                ->setRequired(true),
            AmethystAttributes\Invoice\LocaleAttribute::make('locale')
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class),
            Attributes\DateTimeAttribute::make('issued_at'),
            Attributes\DateTimeAttribute::make('expires_at'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
