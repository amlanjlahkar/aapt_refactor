<?php

namespace App\Livewire;

use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class GetCases extends Component {
    use WithPagination;

    public $cases = [];

    #[Url(as: 'sortBy')]
    public $column = '';

    #[Url(as: 'orderBy')]
    public $order = '';

    public $case_status;

    /**
     * @param  string  $case_status
     */
    public function mount($case_status = null): void {
        $this->case_status = $case_status;
        $this->cases = CaseFile::where('status', $case_status)->orderBy(
            $this->column ? $this->column : 'id',
            $this->order ? $this->order : 'desc'
        )->get();
    }

    /**
     * @param  string  $column  Column name to sort the table by
     * @param  string  $order  Sorting order
     */
    #[On('order-updated')]
    public function updateSortOrder($column, $order): void {
        $this->cases = CaseFile::where('status', $this->case_status)->orderBy($column, $order)->get();
    }

    public function render(): View {
        return view('livewire.get-cases');
    }
}
