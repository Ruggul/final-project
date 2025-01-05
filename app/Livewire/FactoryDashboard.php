<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class FactoryDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'kode_barang';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.factory-dashboard', [
            'items' => Item::search($this->search)
                          ->orderBy($this->sortField, $this->sortDirection)
                          ->paginate(10)
        ]);
    }
}