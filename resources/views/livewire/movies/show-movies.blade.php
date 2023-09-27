<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? __('Movies') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit="searchMovies">
                <input type="text" wire:model="search">

                <x-button>{{__('Search')}}</x-button>
            </form>
            @foreach ($movies as $movie)
                <div wire:key="{{ $movie->id }}" class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 flex flex-row">
                    <div class="p-4">
                        <img src="{{$movie->poster_url}}" class="min-w-[100px] max-w-[100px]">
                    </div>
                    <div>
                        <h2><a href="{{route('movies.show', ['movie' => $movie])}}" wire:navigate>{{$movie->title}}</a></h2>
                        <dl class="divide-y divide-gray-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dd class="mt-1 text-sm leading-6 text-gray-500 sm:col-span-2 sm:mt-0">{{$movie->release_date->format('d/m/Y')}}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dd class="mt-1 text-sm leading-6 text-gray-500 sm:col-span-2 sm:mt-0">{{$movie->overview}}</dd>
                            </div>
                        </dl>
                        @auth
                            <div>
                                <a href="{{route('movies.edit', ['movie' => $movie])}}" wire:navigate class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
