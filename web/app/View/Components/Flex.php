<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Flex extends Component
{
    protected string $class;

    protected string $flex;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $class = null, ?string $flex = null)
    {
        $this->class = $class ?? "";
        $this->flex = $flex ?? "";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.flex', [
            "class" => $this->class, 
            "flex" => $this->flex, 
        ]);
    }
}
