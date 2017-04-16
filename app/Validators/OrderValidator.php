<?php
namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'address' => 'required',
            'images' => 'required',
            'pickup_at' => 'required|date_format:"Y-m-d H:i:s"'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'address' => 'required'
        ]
    ];
}