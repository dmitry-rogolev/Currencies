<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    protected string $labelledby;

    protected string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $labelledby = null, ?string $class = null)
    {
        $this->labelledby = $labelledby ?? "";
        $this->class = $class ?? "";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal', [
            "labelledby" => $this->labelledby, 
            "class" => $this->class, 
        ]);
    }
}
