<div>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{$movie->title}}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
            <form wire:submit="save">
                <div>
                    <x-label for="title" value="{{ __('Name') }}" />
                    <x-input id="title" class="block mt-1 w-full" type="text" wire:model="form.title" required autofocus />
                    <div>
                        @error('form.title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <x-label for="overview" value="{{ __('Overview') }}" />
                    <x-textarea id="overview" class="block mt-1 w-full" type="text" wire:model="form.overview" />
                    <div>
                        @error('form.overview') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <x-label for="poster_path" value="{{ __('Poster path') }}" />
                    <x-input id="poster_path" class="block mt-1 w-full" type="text" wire:model="form.poster_path" />
                    <div>
                        @error('form.poster_path') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <div class="relative flex gap-x-3">
                        <div class="flex h-6 items-center">
                            <x-checkbox id="is_trending_day" wire:model="form.is_trending_day"/>
                        </div>
                        <div class="text-sm leading-6">
                            <label for="is_trending_day" class="font-medium text-gray-900">{{ __('Is trending day') }}</label>
                            <div>
                                @error('form.is_trending_day') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <div class="relative flex gap-x-3">
                        <div class="flex h-6 items-center">
                            <x-checkbox id="is_trending_week" wire:model="form.is_trending_week"/>
                        </div>
                        <div class="text-sm leading-6">
                            <label for="is_trending_week" class="font-medium text-gray-900">{{ __('Is trending week') }}</label>
                            <div>
                                @error('form.is_trending_week') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <x-button class="mt-4">
                    {{ __('Save') }}
                </x-button>
            </form>
            </div>
        </div>
    </div>
</div>

</div>
