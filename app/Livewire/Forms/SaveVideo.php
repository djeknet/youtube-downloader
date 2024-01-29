<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SaveVideo extends Form
{
    #[Validate('required|min:5')]
    public $url = '';

    #[Validate('required|string')]
    public $file_format = '';
    #[Validate('nullable|string')]
    public $time_from = '';
    #[Validate('nullable|string')]
    public $time_to = '';

}
