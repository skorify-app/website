<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorCard extends Component
{
    public function __construct(
        public string $message
    )
    {}

    public function render(): View|Closure|string
    {
        return view('components.error-card');
    }
}
