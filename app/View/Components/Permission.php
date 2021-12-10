<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Permission extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $per;
    public $href;
    public function __construct($per, $href)
    {
        $this->href = $href;
        $this->per = $per;//Edit
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $get_permission = null;
        if(Session($this->per) == $this->per || Session::has('Full')){
            $get_permission = $this->per;
        }
        return view('components.permission', compact('get_permission'));
    }
}
