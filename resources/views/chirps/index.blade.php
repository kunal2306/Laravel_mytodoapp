<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}" class="mb-4">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                rows="4"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2 text-red-600" />
            <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-md mt-4">
                {{ __('Add New Tasks') }}
            </button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y divide-gray-200">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex flex-col space-y-2">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <span class="text-gray-800 font-semibold">{{ $chirp->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($chirp->created_at->eq($chirp->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                    </div>
                    <p class="text-gray-800">{{ $chirp->message }}</p>
                    @if ($chirp->user->is(auth()->user()))
                        <div class="mt-2 flex justify-start space-x-2">
                            <a href="{{ route('chirps.edit', $chirp) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Edit</a>
                            <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
