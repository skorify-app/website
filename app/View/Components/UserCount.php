<?php

namespace App\View\Components;

use AllowDynamicProperties;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#[AllowDynamicProperties]
class UserCount extends Component
{
    public function __construct() {}

    public function render(): View|Closure|string
    {
        return view('components.user-count');
    }
}
