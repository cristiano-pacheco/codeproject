<?php
namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectNoteValidator extends LaravelValidator
{
    protected $rules = [
        'title' => 'required|max:255',
        'note' => 'required|max:500'
    ];
}