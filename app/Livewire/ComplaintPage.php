<?php

namespace App\Livewire;

use App\Models\Complaint;
use App\Models\User;
use Filament\Actions\Action as ActionsAction;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ComplaintPage extends Component
{
    use WithFileUploads; // Trait penting untuk upload file di Livewire murni

    // Properti Form Pengaduan
    public $name;
    public $email;
    public $phone;
    public $category = '';
    public $subject;
    public $content;
    public $attachment;
    
    // Properti Keamanan
    public $captcha;
    public $consent = false;

    // Angka Dinamis Captcha
    public int $num1;
    public int $num2;

    // State UI Form
    public $isSuccess = false;
    public $createdTicketNumber = '';

    // Properti Pengecekan Status Tiket
    public $searchTicket = '';
    public $trackedComplaint = null;
    public $searchError = '';

    public function mount(): void
    {
        // Generate angka acak saat komponen dimuat pertama kali
        $this->generateCaptcha();
    }

    public function generateCaptcha(): void
    {
        // Acak angka dari 1 sampai 9
        $this->num1 = rand(1, 9);
        $this->num2 = rand(1, 9);
    }

    // Menggunakan method rules() agar bisa mengevaluasi penjumlahan captcha dinamis
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            // Menambahkan rfc,dns agar Laravel mengecek apakah domain email tersebut benar-benar aktif/ada
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:akademik,fasilitas,layanan,keuangan,lainnya',
            'subject' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maks 2MB
            
            // Validasi Captcha Dinamis
            'captcha' => 'required|numeric|in:' . ($this->num1 + $this->num2),
            'consent' => 'accepted', // Wajib dicentang
        ];
    }

    protected $messages = [
        'required' => ':attribute wajib diisi.',
        'email' => 'Format email tidak valid atau domain tidak dapat menerima email.',
        'mimes' => 'Lampiran harus berupa file JPG, PNG, atau PDF.',
        'max' => 'Ukuran file maksimal 2MB.',
        
        // Pesan Error Keamanan
        'captcha.in' => 'Jawaban perhitungan matematika salah.',
        'consent.accepted' => 'Anda harus menyetujui pernyataan ini untuk mengirim laporan.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama Lengkap',
        'category' => 'Kategori',
        'subject' => 'Perihal',
        'content' => 'Isi Pengaduan',
        'attachment' => 'Lampiran',
        'captcha' => 'Verifikasi Keamanan',
        'consent' => 'Persetujuan',
    ];

    public function submit()
    {
        // Jalankan validasi
        $this->validate();

        // Handle File Upload
        $filePath = null;
        if ($this->attachment) {
            $filePath = $this->attachment->store('complaints/attachments', 'public');
        }

        // Simpan ke database (ticket_number otomatis di-generate oleh event model)
        $complaint = Complaint::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'category' => $this->category,
            'subject' => $this->subject,
            'content' => $this->content,
            'attachment' => $filePath,
        ]);

        // 1. Kirim Notifikasi ke Database Admin Filament
        $this->notifyAdmins($complaint);

        // 2. Kirim Notifikasi Email
        $this->sendEmailNotifications($complaint);

        // Set state success untuk merubah UI
        $this->createdTicketNumber = $complaint->ticket_number;
        $this->isSuccess = true;
        
        // Reset form data untuk entri berikutnya
        $this->reset(['name', 'email', 'phone', 'category', 'subject', 'content', 'attachment', 'captcha', 'consent']);
        
        // Acak angka captcha untuk pengguna selanjutnya
        $this->generateCaptcha();
    }

    protected function notifyAdmins(Complaint $complaint)
    {
        // Mengambil semua user admin
        // Jika Anda memiliki sistem role, bisa difilter seperti: User::role('admin')->get()
        $admins = User::all();

        Notification::make()
            ->title('Pengaduan Baru Masuk')
            ->icon('heroicon-o-chat-bubble-left-right')
            ->iconColor('warning')
            ->body("**{$complaint->name}** mengirim pengaduan: *{$complaint->subject}*")
            ->actions([
                ActionsAction::make('view')
                    ->label('Lihat Detail')
                    ->url(route('filament.admin.resources.complaints.view', $complaint))
                    ->button(),
            ])
            ->sendToDatabase($admins);
    }

    protected function sendEmailNotifications(Complaint $complaint)
    {
        try {
            // 1. Kirim Notifikasi ke Admin/Rektorat
            $adminEmail = 'admin@unmarissumba.ac.id'; // Ganti dengan email Rektorat/Admin sebenarnya
            Mail::raw(
                "PEMBERITAHUAN SISTEM PENGADUAN UNMARIS\n\n" .
                "Terdapat pengaduan baru yang masuk dengan rincian sebagai berikut:\n" .
                "- Nomor Tiket: {$complaint->ticket_number}\n" .
                "- Kategori: " . strtoupper($complaint->category) . "\n" .
                "- Nama Pelapor: {$complaint->name} ({$complaint->email})\n" .
                "- Perihal: {$complaint->subject}\n\n" .
                "Silakan login ke panel admin (Filament) untuk membaca detail pengaduan dan memberikan tanggapan resmi.",
                function ($message) use ($complaint, $adminEmail) {
                    $message->to($adminEmail)
                            ->subject('🔔 Pengaduan Baru: ' . $complaint->ticket_number);
                }
            );

            // 2. Kirim Notifikasi/Tanda Terima ke Pelapor
            Mail::raw(
                "Halo {$complaint->name},\n\n" .
                "Terima kasih, aspirasi/pengaduan Anda telah berhasil kami terima di sistem Universitas Stella Maris Sumba.\n\n" .
                "Nomor Tiket Anda adalah: {$complaint->ticket_number}\n\n" .
                "Silakan simpan nomor tiket tersebut dengan baik. Anda dapat menggunakannya untuk mengecek status tindak lanjut pengaduan Anda pada halaman website kami.\n\n" .
                "Salam,\nLayanan Pengaduan & Aspirasi UNMARIS",
                function ($message) use ($complaint) {
                    $message->to($complaint->email)
                            ->subject('Tiket Pengaduan Diterima - UNMARIS');
                }
            );
        } catch (\Exception $e) {
            // Jika SMTP error (belum disetting di .env dll), log errornya saja
            Log::error('Gagal mengirim email notifikasi pengaduan: ' . $e->getMessage());
        }
    }

    public function checkStatus()
    {
        $this->validate(
            ['searchTicket' => 'required|string'],
            ['searchTicket.required' => 'Masukkan nomor tiket terlebih dahulu.']
        );

        // Cari tiket (ignore case)
        $this->trackedComplaint = Complaint::where('ticket_number', strtoupper($this->searchTicket))->first();

        if (!$this->trackedComplaint) {
            $this->searchError = 'Nomor tiket tidak ditemukan. Pastikan Anda memasukkan nomor yang benar (contoh: ADU-20260408-XXXX).';
        } else {
            $this->searchError = '';
        }
    }

    public function render()
    {
        return view('livewire.complaint-page')
            ->layout('layouts.app', [
                'title' => 'Layanan Pengaduan & Aspirasi - UNMARIS',
                'description' => 'Sampaikan aspirasi, kritik, atau keluhan Anda untuk Universitas Stella Maris Sumba yang lebih baik.'
            ]);
    }
}