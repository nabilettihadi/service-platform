<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="bg-gradient-to-b from-blue-500 via-blue-700 to-blue-900 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="block h-9 w-auto fill-current text-gray-800">
                </div>
            </div>
    
            <!-- Hamburger -->
            <div x-data="{ isOpen: false }" class="-me-2 flex items-center sm:hidden">
                <button @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div x-show="isOpen" @click.away="isOpen = false" class="absolute top-16 right-0 mt-2 w-48 bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                    @if(auth()->check())
                        <a href="{{ route('services.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Services</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Register</a>
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login</a>
                    @endif
                </div>
            </div>
    
            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-gray-700">Services</a>
            </div>
    
            <!-- Settings Dropdown -->
            @if(auth()->check())
                <div x-data="{ isOpen: false }" class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="relative">
                        <button @click="isOpen = !isOpen" class="flex items-center space-x-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </div>
                        </button>
    
                        <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700">Register</a>
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 ml-4">Login</a>
                </div>
            @endif
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-white">Explorez Nos Services</h1>

        @if(auth()->check())
            <div class="mb-4 text-right">
                <a href="{{ route('services.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer un Service</a>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($services as $service)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="{{ asset('services.webp') }}" alt="{{ $service->title }}" class="w-full h-48 object-cover object-center">

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-blue-700">{{ $service->title }}</h3>
                        <p class="text-gray-700 mb-2">{{ $service->description }}</p>
                        <p class="text-gray-700 mb-2">Catégorie: {{ $service->category }}</p>
                        <p class="text-gray-700 mb-4">Coût: {{ $service->cost }}</p>
                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="{{ route('services.show', $service->id) }}" class="text-white-300 hover:underline bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block w-[150px]">Détails</a>
                        
                            @if(auth()->check() && $service->user_id == auth()->user()->id)
                                <a href="{{ route('services.edit', $service->id) }}" class="text-white hover: bg-yellow-300 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded inline-block w-[150px]">Modifier</a>
                        
                                <form action="{{ route('services.destroy', $service->id) }}" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded inline-block w-[150px]">Supprimer</button>
                                </form>
                            @endif
                        </div>
                        
                        
                    </div>
                </div>
            @empty
                <p class="text-white text-center">Aucun service disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</body>

</html>
