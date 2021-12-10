<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $checking;
    public function __construct($checking)
    {
        $this->checking = $checking;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $test = true;
        if($test == true){
            return view('components.alert');
        }
        else{
            return view('components.badalert');
        }
    }
}
