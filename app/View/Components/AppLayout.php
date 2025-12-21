<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Alat;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $alatList = Alat::where('jumlah_alat', '>', 0)->get();
        return view('layouts.app',[
            'alatList' => $alatList
        ]);
    }
}
