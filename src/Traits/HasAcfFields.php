<?php
namespace Corcel\Traits;

use Adrenalads\Corcel\Acf\AdvancedCustomFields;

trait HasAcfFields
{
    /**
     * @return AdvancedCustomFields
     */
    public function getAcfAttribute()
    {
        return new AdvancedCustomFields($this);
    }
}
