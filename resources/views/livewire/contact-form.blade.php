<div>
    @if($successMessage)
        <div class="mb-6 rounded-r-xl border-l-4 border-green-500 bg-green-50 p-6 shadow-sm" role="status" aria-live="polite">
            <div class="flex items-start">
                <svg class="mr-3 h-7 w-7 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-green-800">Pesan Berhasil Terkirim!</h3>
                    <p class="mt-1 text-sm leading-relaxed text-green-700">Terima kasih telah menghubungi kami. Tim UNMARIS akan segera membalas pesan Anda.</p>
                </div>
            </div>
            <button type="button" wire:click="$set('successMessage', false)"
                class="mt-4 text-sm font-semibold text-green-600 underline transition hover:text-green-800">
                Kirim pesan lainnya
            </button>
        </div>
    @else
        <form wire:submit.prevent="submitMessage" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nama -->
                <div>
                    <label for="kontak-nama" class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Lengkap <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-nama" type="text" wire:model.defer="name" required
                        aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('name') ? 'kontak-nama-error' : '' }}"
                        class="w-full rounded-xl border px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-unmaris-blue {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-slate-50' }}"
                        placeholder="Masukkan nama Anda">
                    @error('name')
                        <span id="kontak-nama-error" class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email -->
                <div>
                    <label for="kontak-email" class="mb-2 block text-sm font-semibold text-slate-700">
                        Alamat Email <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-email" type="email" wire:model.defer="email" required
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('email') ? 'kontak-email-error' : '' }}"
                        class="w-full rounded-xl border px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-unmaris-blue {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-slate-50' }}"
                        placeholder="nama@email.com">
                    @error('email')
                        <span id="kontak-email-error" class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Telepon & Subjek -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="kontak-telepon" class="mb-2 block text-sm font-semibold text-slate-700">Nomor Telepon/WA</label>
                    <input id="kontak-telepon" type="tel" wire:model.defer="phone"
                        aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('phone') ? 'kontak-telepon-error' : '' }}"
                        class="w-full rounded-xl border px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-unmaris-blue {{ $errors->has('phone') ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-slate-50' }}"
                        placeholder="08123456789">
                    @error('phone')
                        <span id="kontak-telepon-error" class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kontak-subjek" class="mb-2 block text-sm font-semibold text-slate-700">
                        Subjek <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-subjek" type="text" wire:model.defer="subject" required
                        aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('subject') ? 'kontak-subjek-error' : '' }}"
                        class="w-full rounded-xl border px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-unmaris-blue {{ $errors->has('subject') ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-slate-50' }}"
                        placeholder="Contoh: Informasi Pendaftaran">
                    @error('subject')
                        <span id="kontak-subjek-error" class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Isi Pesan -->
            <div>
                <label for="kontak-pesan" class="mb-2 block text-sm font-semibold text-slate-700">
                    Isi Pesan <span class="text-red-500" aria-hidden="true">*</span>
                </label>
                <textarea id="kontak-pesan" wire:model.defer="content" rows="5" required
                    aria-invalid="{{ $errors->has('content') ? 'true' : 'false' }}"
                    aria-describedby="{{ $errors->has('content') ? 'kontak-pesan-error' : '' }}"
                    class="w-full resize-none rounded-xl border px-4 py-3 outline-none transition focus:border-transparent focus:ring-2 focus:ring-unmaris-blue {{ $errors->has('content') ? 'border-red-500 bg-red-50' : 'border-slate-300 bg-slate-50' }}"
                    placeholder="Tuliskan pesan atau pertanyaan Anda secara detail..."></textarea>
                @error('content')
                    <span id="kontak-pesan-error" class="mt-1 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button dengan Loading State -->
            <div class="text-right">
                <button type="submit"
                    class="btn-navy disabled:opacity-70">
                    <span wire:loading.remove wire:target="submitMessage">Kirim Pesan Sekarang</span>
                    <span wire:loading wire:target="submitMessage" class="flex items-center">
                        <svg class="mr-3 -ml-1 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                        </svg>
                        Mengirim...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
