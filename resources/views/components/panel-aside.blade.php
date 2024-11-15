<aside x-data="{ 
    open: false,
    qrCode: null,
    loading: false,
    async startQrLogin() {
        this.loading = true;
        try {
            const response = await fetch('/telegram/qr-login');
            const data = await response.json();
            this.qrCode = data.qrCode;
        } catch (error) {
            console.error('QR login failed:', error);
        } finally {
            this.loading = false;
        }
    }
}" 
    class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg transform transition-transform duration-300"
    :class="{ 'translate-x-0': open, 'translate-x-full': !open }">
    
    <!-- Toggle Button -->
    <button @click="open = !open"
            class="absolute left-0 top-20 -translate-x-10 bg-white p-2 rounded-l-lg shadow-lg">
        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <!-- Aside Content -->
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Telegram Login</h2>
        
        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center my-4">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <!-- QR Code Display -->
        <div x-show="qrCode" class="flex flex-col items-center space-y-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <img :src="qrCode" alt="Telegram QR Code" class="w-48 h-48">
            </div>
            <p class="text-sm text-gray-600 text-center">
                Scan this QR code with your Telegram mobile app to log in
            </p>
        </div>

        <div class="space-y-4 mt-4">
            <!-- QR Code Login -->
            <button @click="startQrLogin()" 
                    :disabled="loading"
                    class="w-full bg-green-500 hover:bg-green-600 disabled:bg-green-300 text-white px-4 py-2 rounded transition">
                <span x-text="qrCode ? 'Refresh QR Code' : 'QR Code Login'"></span>
            </button>

            <!-- Phone Login -->
            <form action="{{ route('telegram.phone-login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="tel" 
                       name="phone" 
                       placeholder="Enter phone number" 
                       class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    Phone Login
                </button>
            </form>
        </div>

        @if (session('error'))
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
</aside>