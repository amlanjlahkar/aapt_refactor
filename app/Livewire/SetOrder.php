<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class SetOrder extends Component {
    public $columns = [
        'id' => 'Case ID',
        'created_at' => 'Case Creation Date',
        'updated_at' => 'Case Updation Date',
    ];

    public $sortOrders = [
        'asc' => 'Ascending',
        'desc' => 'Descending',
    ];

    #[Url(as: 'sortBy')]
    public $currentColumn = 'id';

    #[Url(as: 'orderBy')]
    public $currentOrder = 'desc';

    public $case_count;

    public function mount($count = 0): void {
        $this->case_count = $count;
    }

    /**
     * @param  string  $column  Column name to sort the table by
     * @param  'asc'|'desc'  $order  Sorting order
     */
    public function orderBy($column, $order = null): void {
        $this->currentColumn = $column;

        if ($order) {
            $this->currentOrder = $order;
        }

        $this->dispatch('order-updated', column: $this->currentColumn, order: $this->currentOrder);
    }

    public function render(): View {
        return view('livewire.set-order', ['case_count' => $this->case_count]);
    }
}
