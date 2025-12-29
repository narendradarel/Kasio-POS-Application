<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @filamentStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.item icon="shopping-bag" :href="route('pos')" :current="request()->routeIs('pos')"
                wire:navigate>{{ __('POS') }}
            </flux:navlist.item>
            <flux:navlist.group :heading="__('Management')" class="grid">
                <flux:navlist.item icon="users" :href="route('customers.index')"
                    :current="request()->routeIs('customers.index')" wire:navigate>{{ __('Manage Customers') }}
                </flux:navlist.item>
                <flux:navlist.item icon="banknotes" :href="route('payment.method.index')"
                    :current="request()->routeIs('payment.method.index')" wire:navigate>
                    {{ __('Manage Payment Methods') }}
                </flux:navlist.item>
                <flux:navlist.item icon="user-group" :href="route('users.index')"
                    :current="request()->routeIs('users.index')" wire:navigate>{{ __('Manage Users') }}
                </flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.group :heading="__('Inventory Management')" class="grid">
                <flux:navlist.item icon="cube" :href="route('items.index')" :current="request()->routeIs('items.index')"
                    wire:navigate>{{ __('Items') }}</flux:navlist.item>
                <flux:navlist.item icon="queue-list" :href="route('inventories.index')"
                    :current="request()->routeIs('inventories.index')" wire:navigate>{{ __('Inventory') }}
                </flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.group :heading="__('Sales')" class="grid">
                <flux:navlist.item icon="chart-bar" :href="route('sales.index')"
                    :current="request()->routeIs('sales.index')" wire:navigate>{{ __('Sales') }}</flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.group :heading="__('Subscription')" class="grid">
                <flux:navlist.item icon="star" :href="route('membership.index')"
                    :current="request()->routeIs('membership')" wire:navigate>
                    {{ __('Membership') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        {{-- Badge Membership Minimalis --}}
        @php
            $membership = auth()->user()->membershipName();
        @endphp


        <div class="mx-3 mb-4">
            {{-- Badge Tier --}}
            <div class="flex items-center justify-between px-3 py-2 rounded-lg 
         {{ $membership === 'Premium' ? 'bg-gradient-to-r from-amber-500/10 to-orange-500/10' :
    ($membership === 'Basic' ? 'bg-blue-500/10' : 'bg-zinc-100 dark:bg-zinc-800') }}">

                <span class="text-xs text-zinc-500 dark:text-zinc-400">Plan</span>

                <div class="flex items-center gap-1.5">
                    {{-- Icon --}}
                    @if($membership === 'Premium')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-3.5 h-3.5 text-amber-500">
                            <path fill-rule="evenodd"
                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                clip-rule="evenodd" />
                        </svg>
                    @elseif($membership === 'Basic')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-3.5 h-3.5 text-blue-500">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-3.5 h-3.5 text-zinc-400">
                            <path fill-rule="evenodd"
                                d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                clip-rule="evenodd" />
                        </svg>
                    @endif

                    {{-- Text --}}
                    <span class="text-xs font-semibold
                {{ $membership === 'Premium' ? 'text-amber-500' :
    ($membership === 'Basic' ? 'text-blue-500' : 'text-zinc-600 dark:text-zinc-400') }}">
                        {{ $membership }}
                    </span>
                </div>
            </div>

            {{-- Upgrade Link (hanya untuk Free & Basic) --}}
            @if($membership !== 'Premium')
                <a href="{{ route('membership.index')"
                    class="mt-1.5 block text-center text-xs text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors"
                    wire:navigate>
                    Upgrade →
                </a>
            @endif
        </div>




        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @livewire('notifications')
    @filamentScripts
    @fluxScripts
</body>

</html>