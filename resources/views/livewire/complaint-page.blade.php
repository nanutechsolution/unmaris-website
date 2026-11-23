<div>
    <x-ui.page-hero title="Layanan Pengaduan & Aspirasi" eyebrow="Suara Anda Berarti"
        description="Sampaikan aspirasi, kritik, atau keluhan Anda untuk membangun Universitas Stella Maris Sumba menjadi lebih baik."
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengaduan & Aspirasi'],
        ]" />

    <section class="section-y bg-canvas">
        <div class="container-page">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:gap-8">
                <!-- Formulir / sukses -->
                <div class="lg:col-span-8">
                    @if ($isSuccess)
                        <div class="overflow-hidden rounded-3xl border border-leaf/30 bg-surface shadow-[var(--shadow-soft)]">
                            <div class="h-1.5 w-full bg-leaf" aria-hidden="true"></div>
                            <div class="p-6 text-center sm:p-10 md:p-12">
                                <span class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-leaf/10 text-leaf">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <h2 class="mt-5 heading-2">Pengaduan berhasil terkirim</h2>
                                <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-body">
                                    Terima kasih telah menyampaikan aspirasi Anda. Simpan nomor tiket berikut untuk melacak
                                    status tindak lanjut pengaduan.
                                </p>

                                <div class="mx-auto mt-6 inline-block rounded-2xl border border-dashed border-line-strong bg-surface-2 px-6 py-4">
                                    <span class="block text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Nomor Tiket Anda</span>
                                    <span class="mt-1 block font-display text-2xl font-bold tracking-[0.08em] text-brand-ink sm:text-3xl">
                                        {{ $createdTicketNumber }}
                                    </span>
                                </div>

                                <div class="mt-7 flex flex-wrap justify-center gap-3">
                                    <button type="button" wire:click="$set('isSuccess', false)" class="btn-outline">
                                        Kirim Pengaduan Lainnya
                                    </button>
                                    <a href="{{ route('contact') }}" class="btn-ghost">Hubungi Kami</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="overflow-hidden rounded-3xl border border-line bg-surface shadow-[var(--shadow-soft)]">
                            <div class="h-1.5 w-full bg-unmaris-yellow" aria-hidden="true"></div>
                            <div class="p-6 sm:p-8 md:p-10">
                                <span class="eyebrow">Formulir Pengaduan</span>
                                <h2 class="mt-3 heading-2">Sampaikan laporan Anda</h2>
                                <p class="mt-2 text-sm leading-relaxed text-body">
                                    Lengkapi data berikut agar laporan dapat ditindaklanjuti dengan tepat.
                                </p>

                                <form wire:submit.prevent="submit" class="mt-7 space-y-5">
                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="aduan-nama" class="form-label">
                                                Nama Lengkap <span class="text-ember" aria-hidden="true">*</span>
                                            </label>
                                            <input id="aduan-nama" type="text" wire:model="name" autocomplete="name" required
                                                aria-required="true"
                                                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                                aria-describedby="{{ $errors->has('name') ? 'aduan-nama-error' : '' }}"
                                                class="form-input {{ $errors->has('name') ? 'border-ember focus:border-ember' : '' }}"
                                                placeholder="Masukkan nama Anda">
                                            @error('name') <span id="aduan-nama-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="aduan-email" class="form-label">
                                                Alamat Email <span class="text-ember" aria-hidden="true">*</span>
                                            </label>
                                            <input id="aduan-email" type="email" wire:model="email" autocomplete="email" required
                                                aria-required="true"
                                                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                                aria-describedby="{{ $errors->has('email') ? 'aduan-email-error' : '' }}"
                                                class="form-input {{ $errors->has('email') ? 'border-ember focus:border-ember' : '' }}"
                                                placeholder="email@contoh.com">
                                            @error('email') <span id="aduan-email-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="aduan-telepon" class="form-label">Nomor Telepon/WA</label>
                                            <input id="aduan-telepon" type="tel" wire:model="phone" autocomplete="tel"
                                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                                aria-describedby="{{ $errors->has('phone') ? 'aduan-telepon-error' : '' }}"
                                                class="form-input {{ $errors->has('phone') ? 'border-ember focus:border-ember' : '' }}"
                                                placeholder="0812xxxx">
                                            @error('phone') <span id="aduan-telepon-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="aduan-kategori" class="form-label">
                                                Kategori Pengaduan <span class="text-ember" aria-hidden="true">*</span>
                                            </label>
                                            <select id="aduan-kategori" wire:model="category" required aria-required="true"
                                                aria-invalid="{{ $errors->has('category') ? 'true' : 'false' }}"
                                                aria-describedby="{{ $errors->has('category') ? 'aduan-kategori-error' : '' }}"
                                                class="form-input {{ $errors->has('category') ? 'border-ember focus:border-ember' : '' }}">
                                                <option value="">Pilih kategori…</option>
                                                <option value="akademik">Akademik &amp; Perkuliahan</option>
                                                <option value="fasilitas">Fasilitas Kampus</option>
                                                <option value="layanan">Layanan Kemahasiswaan</option>
                                                <option value="keuangan">Administrasi Keuangan</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                            @error('category') <span id="aduan-kategori-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="aduan-subjek" class="form-label">
                                            Perihal / Subjek <span class="text-ember" aria-hidden="true">*</span>
                                        </label>
                                        <input id="aduan-subjek" type="text" wire:model="subject" required
                                            aria-required="true"
                                            aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                                            aria-describedby="{{ $errors->has('subject') ? 'aduan-subjek-error' : '' }}"
                                            class="form-input {{ $errors->has('subject') ? 'border-ember focus:border-ember' : '' }}"
                                            placeholder="Contoh: Proyektor di Ruang A1 Rusak">
                                        @error('subject') <span id="aduan-subjek-error" class="form-error">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="aduan-isi" class="form-label">
                                            Isi Pengaduan <span class="text-ember" aria-hidden="true">*</span>
                                        </label>
                                        <textarea id="aduan-isi" wire:model="content" rows="6" required
                                            aria-required="true"
                                            aria-invalid="{{ $errors->has('content') ? 'true' : 'false' }}"
                                            aria-describedby="{{ $errors->has('content') ? 'aduan-isi-error' : '' }}"
                                            class="form-input resize-y {{ $errors->has('content') ? 'border-ember focus:border-ember' : '' }}"
                                            placeholder="Ceritakan detail keluhan atau aspirasi Anda di sini…"></textarea>
                                        @error('content') <span id="aduan-isi-error" class="form-error">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <span class="form-label" id="aduan-lampiran-label">
                                            Lampiran Bukti <span class="font-normal text-muted">(opsional)</span>
                                        </span>
                                        <div class="flex flex-col gap-3 rounded-xl border border-dashed border-line-strong bg-surface-2/60 p-4 transition has-[:focus-visible]:border-unmaris-blue has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-unmaris-blue/20 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="min-w-0">
                                                <p class="truncate text-[13px] font-semibold text-ink">
                                                    {{ $attachment ? $attachment->getClientOriginalName() : 'Belum ada berkas dipilih' }}
                                                </p>
                                                <p id="aduan-lampiran-bantuan" class="mt-1 text-[11px] leading-relaxed text-muted">
                                                    Maksimal 2MB. Format: JPG, PNG, atau PDF.
                                                </p>
                                            </div>

                                            <div class="flex shrink-0 items-center gap-2">
                                                <label for="aduan-lampiran"
                                                    class="btn-outline btn-sm cursor-pointer">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    Pilih Berkas
                                                </label>

                                                @if ($attachment)
                                                    <button type="button" wire:click="$set('attachment', null)"
                                                        class="btn-ghost btn-sm">Hapus</button>
                                                @endif
                                            </div>

                                            <input id="aduan-lampiran" type="file" wire:model="attachment"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                aria-labelledby="aduan-lampiran-label"
                                                aria-invalid="{{ $errors->has('attachment') ? 'true' : 'false' }}"
                                                aria-describedby="aduan-lampiran-bantuan{{ $errors->has('attachment') ? ' aduan-lampiran-error' : '' }}"
                                                class="sr-only">
                                        </div>

                                        <div wire:loading wire:target="attachment" class="mt-2 text-[13px] font-semibold text-brand-ink" role="status">
                                            Sedang mengunggah berkas…
                                        </div>
                                        @error('attachment') <span id="aduan-lampiran-error" class="form-error">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="space-y-5 border-t border-line pt-5">
                                        <div>
                                            <label for="aduan-captcha" class="form-label">
                                                Verifikasi Keamanan <span class="text-ember" aria-hidden="true">*</span>
                                            </label>
                                            <div class="flex flex-wrap items-center gap-3 sm:flex-nowrap">
                                                <span class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-line bg-surface-2 px-4 text-sm font-bold text-ink sm:w-auto">
                                                    Berapa hasil dari {{ $num1 }} + {{ $num2 }}?
                                                </span>
                                                <input id="aduan-captcha" type="number" wire:model="captcha" required
                                                    aria-required="true"
                                                    aria-invalid="{{ $errors->has('captcha') ? 'true' : 'false' }}"
                                                    aria-describedby="aduan-captcha-bantuan{{ $errors->has('captcha') ? ' aduan-captcha-error' : '' }}"
                                                    class="form-input w-full text-center sm:w-24 {{ $errors->has('captcha') ? 'border-ember focus:border-ember' : '' }}"
                                                    placeholder="?">
                                            </div>
                                            <p id="aduan-captcha-bantuan" class="form-help">Ketikkan angka jawaban untuk membuktikan Anda bukan robot.</p>
                                            @error('captcha') <span id="aduan-captcha-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="aduan-persetujuan"
                                                class="flex cursor-pointer items-start gap-3 rounded-2xl border border-line bg-surface-2/60 p-4 transition hover:border-line-strong">
                                                <input id="aduan-persetujuan" type="checkbox" wire:model="consent"
                                                    aria-required="true"
                                                    aria-invalid="{{ $errors->has('consent') ? 'true' : 'false' }}"
                                                    aria-describedby="{{ $errors->has('consent') ? 'aduan-persetujuan-error' : '' }}"
                                                    class="mt-0.5 h-5 w-5 shrink-0 cursor-pointer rounded border-line-strong accent-unmaris-blue">
                                                <span class="text-[13px] leading-relaxed text-body">
                                                    Saya menyatakan bahwa informasi yang saya berikan adalah benar dan saya
                                                    bertanggung jawab penuh atas isi pengaduan ini sesuai ketentuan yang berlaku.
                                                    <span class="font-bold text-ember" aria-hidden="true">*</span>
                                                </span>
                                            </label>
                                            @error('consent') <span id="aduan-persetujuan-error" class="form-error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3 border-t border-line pt-5 sm:flex-row sm:items-center sm:justify-between">
                                        <p class="text-[11px] leading-relaxed text-muted">
                                            Data diri dan laporan Anda dijaga kerahasiaannya.
                                        </p>

                                        <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn-primary">
                                            <span wire:loading.remove wire:target="submit" class="inline-flex items-center gap-2">
                                                Kirim Pengaduan
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                </svg>
                                            </span>
                                            <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                                                <span class="h-4 w-4 animate-spin rounded-full border-2 border-[#1b0f52]/30 border-t-[#1b0f52] motion-reduce:animate-none" aria-hidden="true"></span>
                                                Memproses…
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Lacak status -->
                <aside class="space-y-5 lg:col-span-4">
                    <div class="relative overflow-hidden rounded-3xl bg-navy-deep p-6 text-white shadow-[var(--shadow-soft)] md:p-7">
                        <div class="pointer-events-none absolute inset-0 hero-grid opacity-60" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-unmaris-yellow/20 blur-2xl" aria-hidden="true"></div>

                        <div class="relative">
                            <span class="eyebrow-light mb-3">Lacak Pengaduan</span>
                            <h2 class="font-display text-xl font-bold leading-tight text-white">Cek status tiket</h2>
                            <p class="mt-2 text-sm leading-relaxed text-white/65">
                                Masukkan nomor tiket untuk melihat perkembangan tindak lanjut pengaduan Anda.
                            </p>

                            <form wire:submit.prevent="checkStatus" class="mt-5">
                                <label for="lacak-tiket" class="sr-only">Nomor tiket pengaduan</label>
                                <input id="lacak-tiket" type="text" wire:model="searchTicket" required
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('searchTicket') ? 'true' : 'false' }}"
                                    aria-describedby="{{ $errors->has('searchTicket') ? 'lacak-tiket-error' : '' }}"
                                    placeholder="Contoh: ADU-2026…"
                                    class="form-input min-h-12 border-white/20 bg-white/10 text-white placeholder:text-white/45 focus:border-unmaris-yellow uppercase">
                                @error('searchTicket') <span id="lacak-tiket-error" class="mt-1.5 block text-[11px] font-semibold text-unmaris-yellow">{{ $message }}</span> @enderror

                                <button type="submit" class="btn-primary mt-3 w-full">Cek Status Tiket</button>
                            </form>

                            @if ($searchError)
                                <div class="mt-4 rounded-xl border border-ember/40 bg-ember/15 p-3 text-[12px] leading-relaxed text-white" role="alert">
                                    {{ $searchError }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($trackedComplaint)
                        <div class="rounded-3xl border border-line bg-surface p-6 shadow-[var(--shadow-soft)]">
                            <div class="flex items-start justify-between gap-3 border-b border-line pb-4">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-muted">Status Tiket</p>
                                    <h3 class="mt-1 break-all font-display text-lg font-bold text-brand-ink">{{ $trackedComplaint->ticket_number }}</h3>
                                </div>

                                @php
                                    $statusMap = [
                                        'pending' => ['label' => 'Pending', 'class' => 'border-line bg-surface-2 text-body'],
                                        'process' => ['label' => 'Diproses', 'class' => 'border-unmaris-yellow/60 bg-unmaris-yellow/20 text-brand-ink'],
                                        'resolved' => ['label' => 'Selesai', 'class' => 'border-leaf/30 bg-leaf/10 text-leaf'],
                                    ];
                                    $statusStyle = $statusMap[$trackedComplaint->status] ?? ['label' => 'Ditolak', 'class' => 'border-ember/30 bg-ember/10 text-ember'];
                                @endphp
                                <span class="shrink-0 rounded-full border px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.06em] {{ $statusStyle['class'] }}">
                                    {{ $statusStyle['label'] }}
                                </span>
                            </div>

                            <dl class="mt-4 space-y-3 text-sm">
                                <div>
                                    <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted">Kategori</dt>
                                    <dd class="mt-0.5 font-semibold capitalize text-ink">{{ $trackedComplaint->category }}</dd>
                                </div>
                                <div>
                                    <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted">Perihal</dt>
                                    <dd class="mt-0.5 font-semibold text-ink">{{ $trackedComplaint->subject }}</dd>
                                </div>
                                <div>
                                    <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted">Tanggal Lapor</dt>
                                    <dd class="mt-0.5 font-semibold text-ink">
                                        {{ $trackedComplaint->created_at->copy()->locale('id')->translatedFormat('d F Y, H:i') }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-5 border-t border-line pt-4">
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-muted">Tanggapan Admin</p>
                                @if ($trackedComplaint->admin_response)
                                    <div class="mt-2 rounded-2xl border border-unmaris-blue/20 bg-unmaris-blue/5 p-4 text-[13px] italic leading-relaxed text-body">
                                        &ldquo;{{ $trackedComplaint->admin_response }}&rdquo;
                                    </div>
                                @else
                                    <div class="mt-2 rounded-2xl border border-dashed border-line-strong bg-surface-2/60 p-4 text-center text-[13px] text-muted">
                                        Belum ada tanggapan untuk tiket ini.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="rounded-3xl border border-line bg-surface p-6">
                        <div class="flex items-center gap-2.5">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-unmaris-yellow text-[#1b0f52]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h2 class="text-sm font-bold text-ink">Keamanan &amp; Privasi</h2>
                        </div>
                        <p class="mt-3 text-[13px] leading-relaxed text-body">
                            Data diri dan laporan Anda akan dijaga kerahasiaannya. Mohon gunakan bahasa yang sopan dan
                            lengkapi dengan bukti valid agar laporan dapat segera ditindaklanjuti.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>
