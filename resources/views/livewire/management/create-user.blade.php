<div class="p-6">
    {{-- Card Container mirip Filament Dark Mode --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 shadow-xl overflow-hidden p-6">
        
        {{-- Header Section --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-white tracking-tight">Create user</h2>
            <p class="text-gray-400 text-sm mt-1">Add new user details!</p>
        </div>

        <form wire:submit.prevent="save">
            {{-- Grid Layout 2 Kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                {{-- Input Name --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="name" type="text" 
                        class="w-full bg-gray-950 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition placeholder-gray-600"
                        placeholder="John Doe">
                    @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="email" type="email" 
                        class="w-full bg-gray-950 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition placeholder-gray-600"
                        placeholder="admin@example.com">
                    @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Select Role --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select wire:model="role" 
                            class="w-full bg-gray-950 text-white border border-gray-700 rounded-lg px-3 py-2 appearance-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition cursor-pointer">
                            <option value="cashier">Cashier</option>
                            <option value="admin">Admin</option>
                            <option value="other">Other</option>
                        </select>
                        {{-- Panah Dropdown Custom --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </div>
                    @error('role') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input wire:model="password" :type="show ? 'text' : 'password'"
                            class="w-full bg-gray-950 text-white border border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition placeholder-gray-600"
                            placeholder="••••••••">
                        
                        {{-- Tombol Mata (Reveal Password) --}}
                        <button type="button" @click="show = !show" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Action Button (Warna Orange mirip Screenshot) --}}
            <div class="flex items-center gap-4">
                <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    {{-- Icon Sparkles --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                    
                    <span>Submit</span>
                </button>

                {{-- Loading Indicator --}}
                <div wire:loading class="text-amber-500 text-sm animate-pulse">
                    Processing...
                </div>
            </div>
        </form>
    </div>
</div>