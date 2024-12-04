<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextEditor extends Component
{
    /**
     * Create a new component instance.
     */
    public $name, $label, $value, $others;
    public function __construct($name, $label, $value = null, $others = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->others = explode('|', $others);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-editor');
    }
}
