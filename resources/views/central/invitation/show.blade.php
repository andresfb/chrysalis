<x-guest-layout>

    @if(!empty($message))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @else
        @if ($errors->has('h-captcha-response'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $errors->first('h-captcha-response') }}</span>
            </div>
        @endif

        <div class="font-weight-bold text-xl mt-4 mb-3">Access to the system is by Invitation only</div>

        <p class="mb-5">Request one below:</p>

        <form id="login-form" class="pt-3" method="POST" action="{{ route('invitation.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!--Price -->
            <div class="mt-4">
                <x-input-label for="price" :value="__('Price you wiling to pay per month?')" />
                <div class="flex items-baseline mb-1">
                    <x-text-input id="price" class="block mt-1 mr-2 w-1/4" type="number" min="1" max="1000" step="0.01" name="price" :value="old('price', 10)" required />
                    <span class="text-gray-500">USD</span>
                </div>
                <small class="small">Make it just right or...</small>
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end pt-4 mt-4">
                @if($hasCaptcha)
                    {!!
                        HCaptcha::displaySubmit(
                            'login-form',
                            __('Request'), [
                                'data-theme' => 'light',
                                'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
                            ]
                        )
                    !!}
                @else
                    <x-primary-button class="ml-4">
                        {{ __('Request') }}
                    </x-primary-button>
                @endif
            </div>

        @if($hasCaptcha)
            <div class="small mt-4">
                <small>
                    This site is protected by hCaptcha and its
                    <a href="https://www.hcaptcha.com/privacy" target="_blank">Privacy Policy</a> and <br>
                    <a href="https://www.hcaptcha.com/terms" target="_blank">Terms of Service</a> apply.
                </small>
            </div>
        @endif

        </form>

        @if($hasCaptcha)
            @push('scripts')
                {!! HCaptcha::renderJs() !!}
            @endpush
        @endif

    @endif
</x-guest-layout>
