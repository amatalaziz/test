<?php

namespace App\Http\Livewire\Requests;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $priority = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'priority' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage',
    ];
  
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'priority', 'status']);
    }

    public function render()
    {
           $requests = Request::query()
        ->when(!auth()->user()->isAdmin(), function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->when($this->search, fn ($query) => $query->where('title', 'like', '%'.$this->search.'%'))
            ->when($this->priority, fn ($query) => $query->where('priority', $this->priority))
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.requests.index', [
            'requests' => $requests,
            'priorities' => RequestPriority::cases(),
            'statuses' => RequestStatus::cases(),
      
         
        ]);
    }
}