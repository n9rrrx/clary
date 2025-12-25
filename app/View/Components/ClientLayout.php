<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ClientLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // This tells Laravel: "When I use <x-client-layout>, load 'resources/views/layouts/client.blade.php'"
        return view('layouts.client');
    }
}
