<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomerAppLayout extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View
    {
        return view('components.customer-app-layout');
    }
}