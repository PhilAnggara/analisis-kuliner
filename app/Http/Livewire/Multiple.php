<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class Multiple extends Component
{
    public $categories;

    public $selectedCategory;
    public $partisi;

    public $success;

    public function mount()
    {
        $this->categories = Category::all();
        $this->selectedCategory = '';
        $this->partisi = '';
        $this->success = false;
    }

    public function process()
    {
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.multiple');
    }
}
