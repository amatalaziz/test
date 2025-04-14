<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SortIcon extends Component
{
    public $direction;

    public function __construct($direction)
    {
        $this->direction = $direction;
    }

    public function render()
    {
        return view('components.sort-icon');
    }
}