<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MMInput extends Component
{
    public function __construct(
        public ?string $id = null,
        public string $name = '',
        public ?string $error_name = null,
        public ?string $placeholder = null,
        public string $label = '',
        public string $type = 'text',
        public mixed $value = null,
        public bool $required = false,
        public bool $autofocus = false,
        public string $label_tooltip = '',
        public string $rootClasses = '',
    ) {
        $this->value ??= old($this->name);
    }

    public function render(): View|Closure|string
    {
        return view('components.mm-input');
    }
}
