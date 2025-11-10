<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Yudisium;

class YudisiumUploadTable extends Component
{
    public $requirements = [];
    public ?Yudisium $yudisium = null;

    protected $listeners = ['refreshUploadTable' => '$refresh'];

    public function render()
    {
        return view('livewire.yudisium-upload-table');
    }
}
