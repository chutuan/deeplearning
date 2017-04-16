<?php
namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ReviewValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'rating' => 'required|numeric|min:0|max:5',
            'content' => 'required|min:5',
        ],
        ValidatorInterface::RULE_UPDATE => [
        ]
    ];
}