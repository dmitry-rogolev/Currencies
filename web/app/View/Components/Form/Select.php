<?php

namespace App\View\Components\Form;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    protected string $class;

    protected string $label;

    protected string $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $label = null, ?string $class = null)
    {
        $this->class = $class ?? "";
        $this->label = $label ?? "";
        $this->id = Str::random(60);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select', [
            "class" => $this->class, 
            "label" => $this->label, 
            "id" => $this->id, 
        ]);
    }
}
