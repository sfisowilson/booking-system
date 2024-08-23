<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{mount};
use function Livewire\Volt\{state};

state([
    'professional' => null,
    'name' => '',
    'email' => '',
    'profession' => '',
    'location' => '',
]);

mount(function ($professional) {
    $this->professional = $professional;
    $this->name = $professional->name;
    $this->email = $professional->email;
    $this->profession = $professional->professional->profession;
    $this->location = $professional->professional->location;
});

?>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4" wire:key="{{ $professional->id }}">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl">{{ $professional->name  }}</h3>
            <p>{{ Str::ucfirst($professional->professional?->profession) }}</p>
            <p>{{ Str::ucfirst($professional->professional?->location) }}</p>
            <div class="flex justify-between">
                <span>Email: {{ $professional->email }}</span>
                <a >Set Appointment</a>
            </div>
        </div>
    </div>
</div>
