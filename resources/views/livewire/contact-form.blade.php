<div>
    @if ($successMessage)
        <div class="rounded-2xl border border-leaf/30 bg-leaf/10 p-5 md:p-6" role="status" aria-live="polite">
            <div class="flex items-start gap-3">
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-leaf/15 text-leaf">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <h3 class="font-display text-lg font-bold text-ink">Pesan berhasil terkirim</h3>
                    <p class="mt-1 text-sm leading-relaxed text-body">
                        Terima kasih telah menghubungi kami. Tim UNMARIS akan segera membalas pesan Anda.
                    </p>
                    <button type="button" wire:click="$set('successMessage', false)"
                        class="focus-navy mt-4 inline-flex min-h-11 items-center rounded-full text-[13px] font-bold text-brand-ink underline decoration-unmaris-yellow decoration-2 underline-offset-2 transition hover:text-unmaris-blue">
                        Kirim pesan lainnya
                    </button>
                </div>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submitMessage" class="space-y-5">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="kontak-nama" class="form-label">
                        Nama Lengkap <span class="text-ember" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-nama" type="text" wire:model.defer="name" required autocomplete="name"
                        aria-required="true"
                        aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('name') ? 'kontak-nama-error' : '' }}"
                        class="form-input {{ $errors->has('name') ? 'border-ember focus:border-ember' : '' }}"
                        placeholder="Masukkan nama Anda">
                    @error('name')
                        <span id="kontak-nama-error" class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="kontak-email" class="form-label">
                        Alamat Email <span class="text-ember" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-email" type="email" wire:model.defer="email" required autocomplete="email"
                        aria-required="true"
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('email') ? 'kontak-email-error' : '' }}"
                        class="form-input {{ $errors->has('email') ? 'border-ember focus:border-ember' : '' }}"
                        placeholder="nama@email.com">
                    @error('email')
                        <span id="kontak-email-error" class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="kontak-telepon" class="form-label">Nomor Telepon/WA</label>
                    <input id="kontak-telepon" type="tel" wire:model.defer="phone" autocomplete="tel"
                        aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('phone') ? 'kontak-telepon-error' : '' }}"
                        class="form-input {{ $errors->has('phone') ? 'border-ember focus:border-ember' : '' }}"
                        placeholder="08123456789">
                    @error('phone')
                        <span id="kontak-telepon-error" class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="kontak-subjek" class="form-label">
                        Subjek <span class="text-ember" aria-hidden="true">*</span>
                    </label>
                    <input id="kontak-subjek" type="text" wire:model.defer="subject" required
                        aria-required="true"
                        aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('subject') ? 'kontak-subjek-error' : '' }}"
                        class="form-input {{ $errors->has('subject') ? 'border-ember focus:border-ember' : '' }}"
                        placeholder="Contoh: Informasi Pendaftaran">
                    @error('subject')
                        <span id="kontak-subjek-error" class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="kontak-pesan" class="form-label">
                    Isi Pesan <span class="text-ember" aria-hidden="true">*</span>
                </label>
                <textarea id="kontak-pesan" wire:model.defer="content" rows="5" required
                    aria-required="true"
                    aria-invalid="{{ $errors->has('content') ? 'true' : 'false' }}"
                    aria-describedby="{{ $errors->has('content') ? 'kontak-pesan-error' : '' }}"
                    class="form-input resize-none {{ $errors->has('content') ? 'border-ember focus:border-ember' : '' }}"
                    placeholder="Tuliskan pesan atau pertanyaan Anda secara detail…"></textarea>
                @error('content')
                    <span id="kontak-pesan-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-3 border-t border-line pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[11px] leading-relaxed text-muted">
                    Kolom bertanda <span class="font-bold text-ember">*</span> wajib diisi.
                </p>

                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="submitMessage">
                    <span wire:loading.remove wire:target="submitMessage" class="inline-flex items-center gap-2">
                        Kirim Pesan
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="submitMessage" class="inline-flex items-center gap-2">
                        <span class="h-4 w-4 animate-spin rounded-full border-2 border-[#1b0f52]/30 border-t-[#1b0f52] motion-reduce:animate-none" aria-hidden="true"></span>
                        Mengirim…
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
