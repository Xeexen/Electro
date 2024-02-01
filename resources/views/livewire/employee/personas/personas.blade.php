<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Clientes/Proveedores') }}
    </x-slot:title>

    <!-- Page title & actions -->
    <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-medium text-slate-900 dark:text-slate-100">
                {{ __('Clientes/Proveedores') }}
            </h1>
        </div>
        <div class="flex mt-4 sm:mt-0 sm:ml-4">
            <a href="{{ route('employee.persona.crear') }}"
                class="block w-full btn btn-primary order-0 sm:order-1 sm:ml-3">
                {{ __('Añadir Cliente o Proveedor') }}
            </a>
        </div>
    </div>

    <!-- Page content -->
    <div class="p-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-card class="overflow-hidden">
            <x-slot:header>
                <div x-data="{ search: @entangle('search')}"
                    class="relative max-w-sm text-slate-400 focus-within:text-slate-600 dark:focus-within:text-slate-200">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </div>
                    <x-input wire:model.debounce.500ms="search" type="text"
                        class="w-full pl-10 placeholder-slate-500 sm:text-sm focus:placeholder-slate-400 dark:focus:placeholder-slate-600"
                        ::class="{ 'pr-10' : search }" placeholder="{{ __('Filter customers') }}" />
                    <button x-show="search.length" x-on:click="search = ''" type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <x-heroicon-s-x-circle
                            class="w-5 h-5 text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                    </button>
                </div>
            </x-slot:header>
            <x-slot:content class="-mx-4 -my-5 sm:-mx-6">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <div class="relative overflow-hidden">
                            <div wire:loading.delay class="absolute inset-0 z-10 bg-slate-100/50 dark:bg-slate-800/50">
                                <div wire:loading.flex class="items-center justify-center w-screen h-full sm:w-auto">
                                    <div class="flex items-center m-auto space-x-2">
                                        <p class="text-sm dark:text-slate-200">{{ 'Loading customers...' }}</p>
                                    </div>
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                                <thead
                                    class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                                    <tr>
                                        <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                            <x-input wire:model="selectPage" type="checkbox"
                                                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 !rounded !shadow-none sm:left-6" />
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-4 text-sm font-semibold tracking-wide text-left text-slate-900 whitespace-nowrap dark:text-slate-200">
                                            {{ __('Customer name') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-4 text-sm font-semibold tracking-wide text-left text-slate-900 whitespace-nowrap dark:text-slate-200">
                                            {{ __('Orders') }}
                                        </th>
                                        <th scope="col"
                                            class="py-4 pl-3 pr-4 text-sm font-semibold tracking-wide text-right text-slate-900 whitespace-nowrap sm:pr-6 dark:text-slate-200">
                                            {{ __('Amount spent') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                                    @forelse($personas as $customer)
                                    <tr wire:loading.class.delay="opacity-50"
                                        class="relative hover:bg-slate-50 dark:hover:bg-slate-800/75">
                                        <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                            @if(in_array($customer->id, $selected))
                                            <div class="absolute inset-y-0 left-0 w-0.5 bg-sky-500 dark:bg-sky-400">
                                            </div>
                                            @endif
                                            <x-input wire:model="selected" wire:key="checkbox-{{ $customer->id }}"
                                                type="checkbox" value="{{ $customer->id }}"
                                                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 !rounded !shadow-none sm:left-6" />
                                        </td>
                                        <td
                                            class="relative px-3 py-4 text-sm font-medium text-left text-slate-900 whitespace-nowrap dark:text-slate-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="object-cover object-center w-10 h-10 rounded-full bg-slate-200"
                                                        src="{{ $customer->getFirstMediaUrl('avatar') }}"
                                                        alt="{{ $customer->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('employee.customers.detail', $customer) }}"
                                                        class="inline-flex items-center truncate hover:text-sky-600 dark:hover:text-sky-400">
                                                        {{ $customer->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="relative px-3 py-4 text-sm text-left text-slate-500 whitespace-nowrap dark:text-slate-400">
                                            {{ trans_choice(':count order|:count orders', $customer->orders_count) }}
                                        </td>
                                        <td
                                            class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 whitespace-nowrap sm:pr-6 dark:text-slate-400">
                                            <x-money :amount="$customer->orders->sum('total')" />
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-3 py-4 text-sm text-center text-slate-500 whitespace-nowrap dark:text-slate-400"
                                            colspan="4">
                                            <div class="max-w-lg mx-auto text-center">
                                                <x-heroicon-o-magnifying-glass
                                                    class="inline-block w-10 h-10 text-slate-400 dark:text-slate-300" />
                                                <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-200">
                                                    {{ __('No customers found') }}
                                                </h3>
                                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                    {{ __('Try changing the filters or search term') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </x-slot:content>
        </x-card>

        <div class="mt-6">
            {{-- {{ $customers->links() }} --}}
        </div>
    </div>
</div>