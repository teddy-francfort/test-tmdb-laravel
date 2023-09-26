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
                    <x-textarea id="overview" class="block mt-1 w-full" type="text" wire:model="form.overview" autofocus />
                    <div>
                        @error('form.overview') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-label for="poster_path" value="{{ __('Poster path') }}" />
                    <x-input id="poster_path" class="block mt-1 w-full" type="text" wire:model="form.poster_path" autofocus />
                    <div>
                        @error('form.poster_path') <span class="error">{{ $message }}</span> @enderror
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
