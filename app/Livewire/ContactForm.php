<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $content;
    public $successMessage = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|numeric|digits_between:9,15',
        'subject' => 'required|min:5|max:255',
        'content' => 'required|min:10',
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi.',
        'email' => 'Format email tidak valid.',
        'numeric' => 'Nomor telepon hanya boleh berisi angka.',
        'min' => ':attribute minimal berisi :min karakter.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama Lengkap',
        'email' => 'Alamat Email',
        'phone' => 'Nomor Telepon',
        'subject' => 'Subjek Pesan',
        'content' => 'Isi Pesan',
    ];

    public function submitMessage()
    {
        $this->validate();

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'content' => $this->content,
            'is_read' => false,
        ]);

        // Reset form dan tampilkan pesan sukses
        $this->reset(['name', 'email', 'phone', 'subject', 'content']);
        $this->successMessage = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}