<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQR extends Component
{
    public $qr;

    public function __construct($url)
    {
        $this->qr = new HtmlString(QrCode::size(200)->generate($url));
    }

    public function render()
    {
        return view('components.generate-q-r');
    }
}

