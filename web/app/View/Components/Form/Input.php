<?php

namespace App\View\Components\Form;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Input extends Component
{
    protected string $label;

    protected string $small;

    protected string $class;

    protected string $id;

    protected string $id_small;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $label = null, ?string $small = null, ?string $class = null)
    {
        $this->label = $label ?? "";
        $this->small = $small ?? "";
        $this->class = $class ?? "";
        $this->id = Str::random(60);
        $this->id_small = Str::random(60);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input', [
            "label" => $this->label, 
            "small" => $this->small, 
            "class" => $this->class, 
            "id" => $this->id, 
            "id_small" => $this->id_small, 
        ]);
    }
}
