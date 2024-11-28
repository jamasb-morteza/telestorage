<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <hr>
    <div class="py-0">
        <div class="max-w mx-auto">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(!$user->user_info->peer_id??null)
                    <a href="{{app('telegram_bot')->generateLink($user)}}">{{__('Start Bot On My Telegram')}}</a><br>
                @endif
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</x-app-layout>
