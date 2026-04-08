<div>
    <!-- Hero Banner -->
    <div class="bg-[#1B1464] text-white py-12 md:py-16 border-b-4 border-[#FDE01A] relative overflow-hidden">
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="currentColor" points="100,100 0,0 100,0" />
            </svg>
        </div>
        
        <div class="container mx-auto px-4 relative z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#FDE01A] mb-4">Layanan Pengaduan & Aspirasi</h1>
            <p class="text-gray-300 max-w-2xl text-base md:text-lg">
                Suara Anda sangat berarti bagi kami. Sampaikan aspirasi, kritik, atau keluhan Anda untuk membangun Universitas Stella Maris Sumba menjadi lebih baik.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- KOLOM KIRI: FORMULIR -->
            <div class="lg:col-span-2">
                @if($isSuccess)
                    <!-- Tampilan Sukses -->
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center shadow-sm">
                        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pengaduan Berhasil Terkirim!</h2>
                        <p class="text-gray-600 mb-6">Terima kasih telah menyampaikan aspirasi Anda. Silakan simpan nomor tiket di bawah ini untuk melacak status pengaduan Anda.</p>
                        
                        <div class="inline-block bg-white border-2 border-dashed border-gray-300 px-6 py-4 rounded-xl mb-8">
                            <span class="block text-sm text-gray-500 font-medium mb-1">Nomor Tiket Anda:</span>
                            <span class="block text-3xl font-black text-[#1B1464] tracking-wider">{{ $createdTicketNumber }}</span>
                        </div>

                        <div>
                            <button wire:click="$set('isSuccess', false)" class="text-[#1B1464] font-bold hover:underline">
                                Kirim Pengaduan Lainnya
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Tampilan Formulir -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Formulir Pengaduan</h2>
                        
                        <form wire:submit.prevent="submit" class="space-y-6">
                            <!-- Data Diri -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="name" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all" placeholder="Masukkan nama Anda">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                                    <input type="email" wire:model="email" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all" placeholder="email@contoh.com">
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon/WA</label>
                                    <input type="tel" wire:model="phone" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all" placeholder="0812xxxx">
                                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Pengaduan <span class="text-red-500">*</span></label>
                                    <select wire:model="category" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all cursor-pointer">
                                        <option value="">Pilih Kategori...</option>
                                        <option value="akademik">Akademik & Perkuliahan</option>
                                        <option value="fasilitas">Fasilitas Kampus</option>
                                        <option value="layanan">Layanan Kemahasiswaan</option>
                                        <option value="keuangan">Administrasi Keuangan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Detail Pengaduan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Perihal / Subjek <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="subject" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all" placeholder="Singkat dan jelas (Contoh: Proyektor di Ruang A1 Rusak)">
                                @error('subject') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pengaduan <span class="text-red-500">*</span></label>
                                <textarea wire:model="content" rows="6" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all" placeholder="Ceritakan detail keluhan atau aspirasi Anda di sini..."></textarea>
                                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Lampiran Bukti <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="file" wire:model="attachment" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1B1464] hover:file:bg-blue-100 transition-colors cursor-pointer border border-dashed border-gray-300 p-2 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mt-2">Maksimal 2MB. Format: JPG, PNG, atau PDF.</p>
                                @error('attachment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                
                                <div wire:loading wire:target="attachment" class="text-sm text-[#1B1464] font-medium mt-2">
                                    Sedang mengunggah file...
                                </div>
                            </div>

                            <!-- Keamanan & Validasi -->
                            <div class="space-y-6 pt-6 border-t border-gray-100">
                                
                                <!-- Simple Math Captcha -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Verifikasi Keamanan <span class="text-red-500">*</span></label>
                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                                        <span class="bg-gray-100 border border-gray-300 text-gray-800 font-bold px-4 py-3 rounded-xl select-none w-full sm:w-auto text-center sm:text-left">
                                            Berapa hasil dari {{ $num1 }} + {{ $num2 }} ?
                                        </span>
                                        <input type="number" wire:model="captcha" class="w-full sm:w-24 rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-800 shadow-sm outline-none focus:border-[#1B1464] focus:ring-2 focus:ring-[#1B1464]/20 transition-all text-center" placeholder="?">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Ketikkan angka jawaban Anda untuk membuktikan Anda bukan robot.</p>
                                    @error('captcha') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Checkbox Persetujuan (Fix Visual & Area Klik) -->
                                <div>
                                    <label class="flex items-start gap-4 p-4 md:p-5 border border-gray-200 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all w-full cursor-pointer">
                                        <div class="flex items-center mt-0.5 shrink-0">
                                            <!-- Menggunakan accent-color agar otomatis rapi tanpa plugin form -->
                                            <input type="checkbox" wire:model="consent" class="w-6 h-6 cursor-pointer accent-[#1B1464]">
                                        </div>
                                        <div class="text-sm md:text-base text-gray-700 hover:text-gray-900 leading-relaxed w-full select-none">
                                            Saya menyatakan bahwa informasi yang saya berikan adalah benar dan saya bertanggung jawab penuh atas isi pengaduan ini sesuai ketentuan yang berlaku. <span class="text-red-500 font-bold">*</span>
                                        </div>
                                    </label>
                                    @error('consent') <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> @enderror
                                </div>
                                
                            </div>

                            <div class="pt-6">
                                <button type="submit" wire:loading.attr="disabled" class="w-full md:w-auto px-8 py-3 bg-[#1B1464] text-white font-bold rounded-xl shadow-lg hover:bg-blue-900 outline-none focus:ring-4 focus:ring-blue-300 transition-all disabled:opacity-70 flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="submit">Kirim Pengaduan</span>
                                    <span wire:loading wire:target="submit">Memproses...</span>
                                    <svg wire:loading.remove wire:target="submit" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- KOLOM KANAN: LACAK STATUS -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Widget Cek Status -->
                <div class="bg-gradient-to-br from-[#1B1464] to-blue-900 rounded-2xl shadow-xl p-6 md:p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </div>

                    <h3 class="text-xl font-bold mb-2 relative z-10 text-[#FDE01A]">Lacak Pengaduan</h3>
                    <p class="text-sm text-blue-100 mb-6 relative z-10">Masukkan nomor tiket untuk melihat perkembangan tindak lanjut pengaduan Anda.</p>

                    <form wire:submit.prevent="checkStatus" class="relative z-10">
                        <div class="mb-4">
                            <input type="text" wire:model="searchTicket" placeholder="Contoh: ADU-2026..." class="w-full px-4 py-3 rounded-xl bg-white text-gray-900 outline-none focus:ring-4 focus:ring-[#FDE01A]/50 transition-all uppercase shadow-inner">
                            @error('searchTicket') <span class="text-red-300 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full bg-[#FDE01A] text-[#1B1464] font-black py-3 rounded-xl hover:bg-yellow-400 outline-none focus:ring-4 focus:ring-yellow-500/50 transition-all shadow-md">
                            Cek Status Tiket
                        </button>
                    </form>

                    <!-- Error Alert -->
                    @if($searchError)
                        <div class="mt-4 bg-red-500/20 border border-red-400/50 rounded-xl p-3 text-sm text-white">
                            {{ $searchError }}
                        </div>
                    @endif
                </div>

                <!-- Hasil Lacak -->
                @if($trackedComplaint)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-start mb-4 border-b pb-4">
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Status Tiket</p>
                                <h4 class="text-lg font-bold text-[#1B1464]">{{ $trackedComplaint->ticket_number }}</h4>
                            </div>
                            
                            <!-- Badges Status -->
                            @if($trackedComplaint->status === 'pending')
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200">Pending</span>
                            @elseif($trackedComplaint->status === 'process')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold border border-yellow-200">Diproses</span>
                            @elseif($trackedComplaint->status === 'resolved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                            @endif
                        </div>

                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-500 block">Kategori:</span>
                                <span class="font-semibold text-gray-800 capitalize">{{ $trackedComplaint->category }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Perihal:</span>
                                <span class="font-semibold text-gray-800">{{ $trackedComplaint->subject }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Tanggal Lapor:</span>
                                <span class="font-semibold text-gray-800">{{ $trackedComplaint->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <!-- Balasan Admin -->
                        <div class="mt-6 pt-4 border-t">
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wider block mb-2">Tanggapan Rektorat / Admin:</span>
                            @if($trackedComplaint->admin_response)
                                <div class="bg-blue-50 p-4 rounded-xl text-sm text-gray-700 border border-blue-100 italic">
                                    "{{ $trackedComplaint->admin_response }}"
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-xl text-sm text-gray-500 border border-gray-100 text-center">
                                    Belum ada tanggapan untuk tiket ini.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Keamanan & Privasi
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Data diri dan laporan Anda akan dijaga kerahasiaannya. Mohon gunakan bahasa yang sopan dan lengkapi dengan bukti valid agar laporan Anda dapat segera ditindaklanjuti.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>