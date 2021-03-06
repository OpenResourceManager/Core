<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\State;

class StateTransformer extends TransformerAbstract
{

    /**
     * @param State $item
     * @return array
     */
    public function transform(State $item)
    {
        $countryTrans = new CountryTransformer();

        $country = $countryTrans->transform($item->country);

        return [
            'id' => (int)$item->id,
            'label' => $item->label,
            'code' => $item->code,
            'country' => $country,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}