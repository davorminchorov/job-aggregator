<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('positions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Positions
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Position Header -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        @if($position->company->logo)
                            <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-16 w-16 rounded-lg object-cover mr-6">
                        @else
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=818CF8&color=fff&size=64&bold=true"
                                alt="{{ $position->company->name }}"
                                class="h-16 w-16 rounded-lg object-cover mr-6"
                            >
                        @endif
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $position->title }}</h1>
                            <div class="mt-2">
                                <p class="text-lg text-gray-600">{{ $position->company->name }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $position->location }}</p>
                            </div>
                        </div>
                    </div>
                    <button wire:click="apply" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply Now
                    </button>
                </div>

                <!-- Position Meta -->
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Position Type</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ ucfirst($position->type) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Salary Range</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($position->salary_min && $position->salary_max)
                                    ${{ number_format($position->salary_min) }} - ${{ number_format($position->salary_max) }}
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Category</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $position->category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Position Description -->
        <div class="mt-8 bg-white rounded-lg shadow-sm">
            <div class="p-6 sm:p-8">
                <h2 class="text-lg font-medium text-gray-900">Position Description</h2>
                <div class="mt-4 prose max-w-none">
                    {!! $position->description !!}
                </div>

                @if($position->requirements)
                    <h2 class="mt-8 text-lg font-medium text-gray-900">Requirements</h2>
                    <div class="mt-4 prose max-w-none">
                        {!! $position->requirements !!}
                    </div>
                @endif

                @if($position->benefits)
                    <h2 class="mt-8 text-lg font-medium text-gray-900">Benefits</h2>
                    <div class="mt-4 prose max-w-none">
                        {!! $position->benefits !!}
                    </div>
                @endif
            </div>
        </div>

        <!-- Company Information -->
        <div class="mt-8 bg-white rounded-lg shadow-sm">
            <div class="p-6 sm:p-8">
                <h2 class="text-lg font-medium text-gray-900">About {{ $position->company->name }}</h2>
                <div class="mt-4 prose max-w-none">
                    {!! $position->company->description !!}
                </div>
                @if($position->company->website)
                    <a href="{{ $position->company->website }}" target="_blank" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                        Visit company website
                        <svg class="ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Apply Button (Bottom) -->
        <div class="mt-8 flex justify-center">
            <button wire:click="apply" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Apply for this Position
            </button>
        </div>
    </div>
</div>
