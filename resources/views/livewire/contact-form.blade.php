<div>
    @if($successMessage)
        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-xl shadow-sm mb-6 transform transition-all duration-500">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="text-lg font-bold text-green-800">Pesan Berhasil Terkirim!</h3>
                    <p class="text-green-700 mt-1">Terima kasih telah menghubungi kami. Tim UNMARIS akan segera membalas pesan Anda.</p>
                </div>
            </div>
            <button wire:click="$set('successMessage', false)" class="mt-4 text-sm font-semibold text-green-600 hover:text-green-800 underline">Kirim pesan lainnya</button>
        </div>
    @else
        <form wire:submit.prevent="submitMessage" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.defer="name" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} focus:ring-2 focus:ring-unmaris-blue focus:border-transparent transition-all outline-none" placeholder="Masukkan nama Anda">
                    @error('name') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" wire:model.defer="email" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} focus:ring-2 focus:ring-unmaris-blue focus:border-transparent transition-all outline-none" placeholder="nama@email.com">
                    @error('email') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Telepon & Subjek -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon/WA</label>
                    <input type="text" wire:model.defer="phone" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('phone') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} focus:ring-2 focus:ring-unmaris-blue focus:border-transparent transition-all outline-none" placeholder="08123456789">
                    @error('phone') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.defer="subject" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('subject') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} focus:ring-2 focus:ring-unmaris-blue focus:border-transparent transition-all outline-none" placeholder="Contoh: Informasi Pendaftaran">
                    @error('subject') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Isi Pesan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pesan <span class="text-red-500">*</span></label>
                <textarea wire:model.defer="content" rows="5" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('content') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} focus:ring-2 focus:ring-unmaris-blue focus:border-transparent transition-all outline-none resize-none" placeholder="Tuliskan pesan atau pertanyaan Anda secara detail..."></textarea>
                @error('content') <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button dengan Loading State -->
            <div class="text-right">
                <button type="submit" class="inline-flex items-center justify-center bg-unmaris-blue text-white font-bold py-3 px-8 rounded-full hover:bg-opacity-90 transition-all shadow-md focus:outline-none focus:ring-4 focus:ring-unmaris-blue/30 disabled:opacity-70">
                    <span wire:loading.remove wire:target="submitMessage">Kirim Pesan Sekarang</span>
                    <span wire:loading wire:target="submitMessage" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Mengirim...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
