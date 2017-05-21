<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\DiagnoseHistory;
use App\Symptom;

class HistoryTransformer extends TransformerAbstract
{
    public function transform(DiagnoseHistory $history)
    {
        return [
            'symptoms' => $this->getSymptoms($history->symptoms),
            'message' => $history->message,
            'advice' => $history->advice,
            'per_cent' => $history->per_cent,
            'created_at' => $history->created_at->format('c'),
         ];
    }

    public function getSymptoms($symptoms)
    {
        $result = [];
        $symptoms = explode(",", $symptoms);
        foreach(Symptom::whereNull('symptom_id')->get() as $index => $parent)
        {
            if(isset($symptoms[$index]) && $symptoms[$index] > 0)
            {
                foreach($parent->symptoms as $symptom)
                {
                    if($symptom->sort == $symptoms[$index])
                    {
                        array_push($result, $symptom->content);
                        break;
                    }
                }
            }
        }

        return $result;
    }
}