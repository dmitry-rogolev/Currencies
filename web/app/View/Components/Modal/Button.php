<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Button extends Component
{
    protected string $target;

    protected string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $target = null, ?string $class = null)
    {
        $this->target = $target ?? "";
        $this->class = $class ?? "";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.button', [
            "target" => $this->target, 
            "class" => $this->class, 
        ]);
    }
}
