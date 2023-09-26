<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($movies as $movie)
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h2><a href="{{route('movies.show', ['movie' => $movie])}}" wire:navigate>{{$movie->title}}</a></h2>
                    <dl class="divide-y divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dd class="mt-1 text-sm leading-6 text-gray-500 sm:col-span-2 sm:mt-0">{{$movie->release_date->format('m/d/Y')}}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dd class="mt-1 text-sm leading-6 text-gray-500 sm:col-span-2 sm:mt-0">{{$movie->overview}}</dd>
                        </div>
                    </dl>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
