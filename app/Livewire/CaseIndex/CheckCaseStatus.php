<?php

namespace App\Livewire\CaseIndex;

use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class CheckCaseStatus extends Component {
    #[Url(as: 'q')]
    public $search = '';

    public $case;

    public function check(): void {
        $this->case = CaseFile::where('filing_number', $this->search)->first();

        if (! $this->case && $this->search) {
            session()->flash('error', 'No case found for specified filing number "' . $this->search . '" (make sure it\'s valid!)');
        }

        // $this->reset('search');
    }

    public function render(): View {
        return view('livewire.case-index.check-case-status');
    }
}
