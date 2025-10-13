<nav class="bg-white shadow-sm border-b border-gray-200 px-4 py-3">
    <div class="flex justify-end items-center">
        @auth
        <div class="flex items-center space-x-3">
            <img src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                 alt="Profile" 
                 class="w-10 h-10 rounded-full object-cover border-2 border-teal-500">
            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
        </div>
        @endauth
        
        @guest
        <div class="flex items-center space-x-3">
            <img src="https://ui-avatars.com/api/?name=Guest" 
                 alt="Guest Profile" 
                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-300">
            <span class="text-sm font-medium text-gray-700">Guest</span>
        </div>
        @endguest
    </div>
</nav>