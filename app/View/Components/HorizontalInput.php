<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HorizontalInput extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $type, $name, $label, $labelSpan, $placeholder, $required, $value, $other;
    public function __construct($id, $type, $name, $label, $placeholder = null, $labelSpan = 3, $required = true, $value = null, $other = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->labelSpan = $labelSpan;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->value = $value;
        $this->other = explode('|', $other);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.horizontal-input');
    }
}
