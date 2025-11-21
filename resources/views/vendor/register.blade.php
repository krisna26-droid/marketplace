<x-guest-layout>
    <form method="POST" action="{{ route('vendor.register.submit') }}">
        @csrf

        <h2 class="text-lg font-bold mb-4">Register as Vendor</h2>

        <div class="mb-4">
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" type="text" name="name" required/>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            
        </div>

        <div class="mb-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" required/>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required/>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required/>
        </div>

        <x-primary-button class="mt-4 w-full">
            Submit & Wait Admin Approval
        </x-primary-button>
    </form>
</x-guest-layout>
