<?php

use Livewire\Volt\Component;
use App\Models\Professional;
use App\Models\User;

new class extends Component {
    // declare an array of professionals
    public $professionals = [];

    /**
     * mount method
     * 
     * @return void
     **/
    public function mount()
    {
        $this->professionals = User::where('role', 'professional')->get();
        // dd($professionals);
    }

}; ?>

<div>
    @foreach ($professionals as $professional)
        
        <livewire:pages.professional-details :professional="$professional" />
    @endforeach
</div>
