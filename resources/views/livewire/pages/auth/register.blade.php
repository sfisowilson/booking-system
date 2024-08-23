<?php

use App\Models\User;
use App\Models\Professional;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';
    public ?string $location = null;
    public ?string $profession = null;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:professional,client'],
        ]);

        if ($this->role === 'professional') {
            $validated['location'] = ['required', 'string', 'max:255'];
            $validated['profession'] = ['required', 'string', 'max:255'];
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if ($this->role === 'professional') {
            Professional::create([
                'user_id' => $user->id,
                'location' => $this->location,
                'profession' => $this->profession,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
    
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />

            <x-select-input :selectItems="['professional', 'client']"
                wire:model.live="role" id="role" name="role" class="block mt-1 w-full" required/>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        <!-- Location (visible if role is professional) -->
        @if ($role === 'professional')
            <div class="mt-4">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" name="location" required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
        @endif

        <!-- Profession (visible if role is professional) -->
        @if ($role === 'professional')
            <div class="mt-4">
                <x-input-label for="profession" :value="__('Profession')" />
                <x-text-input wire:model="profession" id="profession" class="block mt-1 w-full" type="text" name="profession" required />
                <x-input-error :messages="$errors->get('profession')" class="mt-2" />
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
