<?php
namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectTaskValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'required|max:255',
    ];
}