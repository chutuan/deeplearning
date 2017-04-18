<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Symptom;

class SymptomTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'attributes'
    ];

    public function transform(Symptom $symptom)
    {
        return [
             'content' => $symptom->content,
             'value' => $symptom->sort
        ];
    }

    public function includeAttributes(Symptom $symptom)
    {
        return $this->collection($symptom->symptoms, new SymptomTransformer, 'attributes');
    }
}