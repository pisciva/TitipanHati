@extends('layouts.app')

@section('title', 'Bantuan & Dukungan - TitipanHati')

@section('content')
    <div class="bg-gradient-to-b from-blue-50 to-white">
        {{-- Hero Section --}}
        <div class="container mx-auto px-4 py-12 lg:py-16">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Pusat Bantuan <span class="text-[#FF4400]">TitipanHati</span>
                </h1>
                <p class="text-gray-600 text-lg">
                    Temukan jawaban untuk pertanyaan Anda atau hubungi tim kami untuk bantuan lebih lanjut
                </p>
            </div>

            {{-- Quick Navigation --}}
            <div class="mt-12 grid grid-cols-2 md:grid-cols-5 gap-4 max-w-5xl mx-auto">
                <a href="#faq"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div
                        class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#FF4400] transition-colors duration-300">
                        <i
                            class="fas fa-question-circle text-2xl text-blue-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="font-semibold text-gray-900 text-center">FAQ</span>
                </a>

                <a href="#syarat-ketentuan"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div
                        class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#FF4400] transition-colors duration-300">
                        <i
                            class="fas fa-file-contract text-2xl text-green-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="font-semibold text-gray-900 text-center">Syarat & Ketentuan</span>
                </a>

                <a href="#kebijakan-privasi"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div
                        class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#FF4400] transition-colors duration-300">
                        <i
                            class="fas fa-shield-alt text-2xl text-purple-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="font-semibold text-gray-900 text-center">Kebijakan Privasi</span>
                </a>

                <a href="#hubungi-kami"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div
                        class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#FF4400] transition-colors duration-300">
                        <i
                            class="fas fa-headset text-2xl text-orange-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="font-semibold text-gray-900 text-center">Hubungi Kami</span>
                </a>

                <a href="{{ route('home') }}"
                    class="flex flex-col items-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div
                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#FF4400] transition-colors duration-300">
                        <i
                            class="fas fa-home text-2xl text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="font-semibold text-gray-900 text-center">Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-6xl">
        {{-- FAQ Section --}}
        <section id="faq" class="scroll-mt-20 mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-question-circle text-3xl text-blue-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600">Pertanyaan yang sering diajukan tentang TitipanHati</p>
            </div>

            <div class="space-y-4" x-data="{ activeIndex: null }">
                {{-- FAQ 1 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 1 ? null : 1"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Apa itu TitipanHati?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 1}"></i>
                    </button>
                    <div x-show="activeIndex === 1" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed">
                            TitipanHati adalah platform donasi yang menghubungkan para donatur dengan yayasan-yayasan yang
                            membutuhkan bantuan berupa pakaian layak pakai. Kami memfasilitasi proses donasi dari
                            pengumpulan hingga penyaluran kepada yang membutuhkan.
                        </p>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 2 ? null : 2"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Bagaimana cara berdonasi?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 2}"></i>
                    </button>
                    <div x-show="activeIndex === 2" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <ol class="text-gray-600 leading-relaxed space-y-2 list-decimal list-inside">
                            <li>Pilih campaign yang ingin Anda dukung</li>
                            <li>Klik tombol "Donasi Sekarang"</li>
                            <li>Isi formulir donasi dengan lengkap</li>
                            <li>Tentukan jadwal penjemputan barang</li>
                            <li>Tim kami akan menjemput donasi Anda sesuai jadwal</li>
                        </ol>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 3 ? null : 3"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Apa saja syarat barang yang bisa didonasikan?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 3}"></i>
                    </button>
                    <div x-show="activeIndex === 3" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed mb-3">
                            Barang yang dapat didonasikan:
                        </p>
                        <ul class="text-gray-600 leading-relaxed space-y-1 list-disc list-inside">
                            <li>Pakaian dalam kondisi bersih dan layak pakai</li>
                            <li>Tidak rusak, robek, atau bernoda parah</li>
                            <li>Masih memiliki fungsi yang baik (resleting, kancing, dll)</li>
                            <li>Sudah dicuci dan dibersihkan</li>
                        </ul>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 4 ? null : 4"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Apakah ada biaya untuk berdonasi?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 4}"></i>
                    </button>
                    <div x-show="activeIndex === 4" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed">
                            Tidak ada biaya sama sekali untuk berdonasi. Layanan penjemputan donasi juga gratis. Kami ingin
                            memudahkan proses berbagi kebaikan tanpa beban biaya apapun.
                        </p>
                    </div>
                </div>

                {{-- FAQ 5 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 5 ? null : 5"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Bagaimana cara melacak donasi saya?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 5}"></i>
                    </button>
                    <div x-show="activeIndex === 5" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed">
                            Anda dapat melacak status donasi melalui menu "Riwayat Donasi" di dashboard Anda. Setiap
                            perubahan status akan dinotifikasikan melalui email yang terdaftar.
                        </p>
                    </div>
                </div>

                {{-- FAQ 6 --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button @click="activeIndex = activeIndex === 6 ? null : 6"
                        class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                        <span class="font-semibold text-gray-900 pr-4">Berapa lama proses penjemputan?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                            :class="{'rotate-180': activeIndex === 6}"></i>
                    </button>
                    <div x-show="activeIndex === 6" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed">
                            Penjemputan dapat dijadwalkan minimal 3 hari dari tanggal pengajuan donasi. Anda dapat memilih
                            waktu penjemputan yang sesuai dengan ketersediaan Anda pada saat mengisi formulir donasi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Syarat & Ketentuan Section --}}
        <section id="syarat-ketentuan" class="scroll-mt-20 mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-file-contract text-3xl text-green-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h2>
                <p class="text-gray-600">Ketentuan penggunaan platform TitipanHati</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-8 lg:p-12">
                <div class="prose max-w-none">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">1. Ketentuan Umum</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Dengan mengakses dan menggunakan platform TitipanHati, Anda menyetujui untuk terikat oleh syarat dan
                        ketentuan berikut. Jika Anda tidak menyetujui sebagian atau seluruh ketentuan ini, mohon untuk tidak
                        menggunakan layanan kami.
                    </p>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">2. Registrasi dan Akun</h3>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Pengguna wajib memberikan informasi yang akurat dan terkini saat mendaftar</li>
                        <li>Setiap pengguna bertanggung jawab atas keamanan akun mereka</li>
                        <li>Pengguna tidak diperkenankan berbagi akses akun dengan pihak lain</li>
                        <li>TitipanHati berhak menangguhkan akun yang melanggar ketentuan</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">3. Donasi</h3>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Semua donasi bersifat sukarela dan tidak dapat dikembalikan</li>
                        <li>Barang donasi harus dalam kondisi layak pakai dan bersih</li>
                        <li>Donatur bertanggung jawab atas keakuratan informasi yang diberikan</li>
                        <li>TitipanHati berhak menolak barang yang tidak memenuhi standar</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">4. Penjemputan</h3>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Jadwal penjemputan dapat diubah dengan pemberitahuan minimal 1 hari sebelumnya</li>
                        <li>Donatur wajib menyiapkan barang pada waktu yang telah disepakati</li>
                        <li>TitipanHati tidak bertanggung jawab atas keterlambatan di luar kendali kami</li>
                        <li>Pembatalan berulang dapat mengakibatkan pembatasan layanan</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">5. Hak Kekayaan Intelektual</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Seluruh konten, logo, dan merek dagang di platform ini adalah milik TitipanHati. Penggunaan tanpa
                        izin tertulis dilarang keras.
                    </p>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">6. Pembatasan Tanggung Jawab</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        TitipanHati tidak bertanggung jawab atas kerugian langsung atau tidak langsung yang timbul dari
                        penggunaan platform ini. Kami berusaha memberikan layanan terbaik namun tidak menjamin ketiadaan
                        kesalahan atau gangguan layanan.
                    </p>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">7. Perubahan Ketentuan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        TitipanHati berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diumumkan melalui
                        platform dan dianggap efektif setelah publikasi. Penggunaan berkelanjutan setelah perubahan dianggap
                        sebagai persetujuan atas ketentuan baru.
                    </p>
                </div>

                <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Terakhir diperbarui: {{ date('d F Y') }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Kebijakan Privasi Section --}}
        <section id="kebijakan-privasi" class="scroll-mt-20 mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                    <i class="fas fa-shield-alt text-3xl text-purple-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kebijakan Privasi</h2>
                <p class="text-gray-600">Bagaimana kami melindungi data pribadi Anda</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-8 lg:p-12">
                <div class="prose max-w-none">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">1. Informasi yang Kami Kumpulkan</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Kami mengumpulkan informasi berikut untuk memberikan layanan terbaik:
                    </p>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Informasi pribadi (nama, email, nomor telepon)</li>
                        <li>Alamat untuk keperluan penjemputan donasi</li>
                        <li>Riwayat donasi dan aktivitas di platform</li>
                        <li>Data teknis (IP address, browser, perangkat)</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">2. Penggunaan Informasi</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Data yang kami kumpulkan digunakan untuk:
                    </p>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Memproses dan mengelola donasi Anda</li>
                        <li>Menghubungi Anda terkait jadwal penjemputan</li>
                        <li>Mengirimkan update dan notifikasi penting</li>
                        <li>Meningkatkan kualitas layanan kami</li>
                        <li>Kepatuhan terhadap kewajiban hukum</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">3. Keamanan Data</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data pribadi Anda
                        dari akses tidak sah, kehilangan, atau penyalahgunaan. Data Anda dienkripsi dan disimpan di server
                        yang aman.
                    </p>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">4. Pembagian Informasi</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kami tidak akan menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak ketiga
                        tanpa persetujuan Anda, kecuali:
                    </p>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Untuk memfasilitasi layanan penjemputan donasi</li>
                        <li>Jika diwajibkan oleh hukum atau proses hukum</li>
                        <li>Untuk melindungi hak dan keamanan TitipanHati</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">5. Cookie</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Website kami menggunakan cookie untuk meningkatkan pengalaman pengguna. Cookie membantu kami
                        mengingat preferensi Anda dan menganalisis penggunaan website. Anda dapat mengatur browser untuk
                        menolak cookie, namun beberapa fitur mungkin tidak berfungsi optimal.
                    </p>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">6. Hak Pengguna</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Anda memiliki hak untuk:
                    </p>
                    <ul class="text-gray-600 mb-6 space-y-2 list-disc list-inside">
                        <li>Mengakses data pribadi Anda</li>
                        <li>Meminta koreksi data yang tidak akurat</li>
                        <li>Meminta penghapusan data Anda</li>
                        <li>Menarik persetujuan penggunaan data</li>
                        <li>Mengajukan keluhan terkait pengelolaan data</li>
                    </ul>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">7. Kontak</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Untuk pertanyaan terkait kebijakan privasi atau pengelolaan data Anda, silakan hubungi kami di: <a
                            href="mailto:cs@titipanhati.com" class="text-[#FF4400] hover:underline">cs@titipanhati.com</a>
                    </p>
                </div>

                <div class="mt-8 p-4 bg-purple-50 border-l-4 border-purple-500 rounded">
                    <p class="text-sm text-purple-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Terakhir diperbarui: {{ date('d F Y') }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Hubungi Kami Section --}}
        <section id="hubungi-kami" class="scroll-mt-20 mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                    <i class="fas fa-headset text-3xl text-orange-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                <p class="text-gray-600">Kami siap membantu Anda kapan saja</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                {{-- Contact Cards --}}
                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600 text-sm mb-3">Kirim email kepada kami</p>
                    <a href="mailto:cs@titipanhati.com" class="text-[#FF4400] hover:underline font-medium">
                        cs@titipanhati.com
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-whatsapp text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">WhatsApp</h3>
                    <p class="text-gray-600 text-sm mb-3">Chat dengan tim support</p>
                    <a href="https://wa.me/6285155110751" target="_blank"
                        class="text-[#FF4400] hover:underline font-medium">
                        +62 851-5511-0751
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl text-red-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-gray-600 text-sm mb-3">Kunjungi kantor kami</p>
                    <a href="https://maps.app.goo.gl/38EgcdggLQPaSxLY6" target="_blank"
                        class="text-[#FF4400] hover:underline font-medium">
                        Jl. Kebon Jeruk Raya No. 27, Kebon Jeruk, Jakarta Barat 11530
                    </a>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-white rounded-xl shadow-md p-8 lg:p-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6"> 
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2"> Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                            placeholder="Masukkan nama Anda">
                    </div>
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                            placeholder="Masukkan email Anda">
                    </div>
                    {{-- Pesan --}}
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pesan
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF4400] focus:border-transparent"
                            placeholder="Tulis pesan Anda"></textarea>
                    </div>
                    <button type="submit"
                        class="bg-[#FF4400] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#e03e00] transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </section>
    </div>

@endsection