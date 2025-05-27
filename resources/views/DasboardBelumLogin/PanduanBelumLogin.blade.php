@extends('DasboardBelumLogin.Template.Template')
@section('title', 'Kinggg')

@section('content')

<section class="container mx-auto py-8 md:py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8 md:mb-12">Alur Pengaduan</h2>
    <div class="w-full h-1 bg-kuning mb-4 sm:mb-6"></div>
    <div class="relative space-y-8 md:space-y-16">
        <!-- Vertical line with progress animation -->
        <div class="absolute left-1/2 h-full w-1 bg-gray-200 hidden md:block -translate-x-1/2 overflow-hidden">
            <div id="progressLine" class="h-0 w-full bg-yellow-400 transition-all duration-500"></div>
        </div>

        <!-- Step 1 -->
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <!-- Mobile circle indicator -->
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">1</span> {{-- Ditambahkan --}}
            </div>

            <div class="flex justify-start md:justify-end w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/register.svg" alt="Registrasi" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                    {{-- Desktop circle - Added leading-none to span --}}
                    <div class="absolute -left-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">1</span>
                    </div>
                </div>
            </div>
            <div class="md:mt-0 mt-2 pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Registrasi</h3>
                <p class="text-sm md:text-base text-gray-600">Sebelum mengirim laporan, kamu perlu membuat akun terlebih dahulu. Tenang, prosesnya cepat dan gampang kok! Dengan akun ini, kamu bisa akses semua fitur, mulai dari kirim laporan, pantau prosesnya, sampai kasih ulasan. Satu akun, banyak manfaat!</p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <!-- Mobile circle indicator -->
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">2</span> {{-- Ditambahkan --}}
            </div>

            <div class="order-1 md:order-2 flex justify-start md:justify-start w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/lapor.svg" alt="Wear Jewelry" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                     {{-- Desktop circle - Added leading-none to span --}}
                    <div class="absolute -right-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">2</span>
                    </div>
                </div>
            </div>
            <div class="order-2 md:order-1 md:text-right pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Tulis Laporan</h3>
                <p class="text-sm md:text-base text-gray-600">Setelah login, saatnya kamu mengisi form pengaduan. Ceritakan keluhanmu secara lengkap dan jelas ya! Jangan lupa tambahkan bukti pendukung seperti foto atau dokumen agar tim kami bisa memahami situasi dengan lebih akurat. Semakin detail, semakin cepat ditindak!</p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <!-- Mobile circle indicator -->
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">3</span> {{-- Ditambahkan --}}
            </div>

            <div class="flex justify-start md:justify-end w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/verifikasi.svg" alt="File Claim" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                     {{-- Desktop circle - Added leading-none to span --}}
                     <div class="absolute -left-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">3</span>
                    </div>
                </div>
            </div>
            <div class="pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Proses Verifikasi</h3>
                <p class="text-sm md:text-base text-gray-600">Laporan yang masuk akan diverifikasi dulu oleh tim verifikator. Proses ini maksimal memakan waktu 7×24 jam. Kami akan pastikan semua informasi yang kamu sampaikan valid, agar bisa diteruskan ke pihak yang tepat untuk ditindaklanjuti. Intinya: laporanmu nggak akan dibiarkan begitu saja!</p>
            </div>
        </div>

        {{-- Step 4 - Updated color, size, and added number --}}
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <!-- Mobile circle indicator -->
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">4</span> {{-- Ditambahkan --}}
            </div>

            <div class="order-1 md:order-2 flex justify-start md:justify-start w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/menunggu.svg" alt="Tindak Lanjut" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                    {{-- Desktop circle - Added leading-none to span --}}
                    <div class="absolute -right-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">4</span>
                    </div>
                </div>
            </div>
            <div class="order-2 md:order-1 md:text-right pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-hitam mb-2">Tindak Lanjut</h3>
                <p class="text-sm md:text-base text-gray-600">Setelah lolos verifikasi, laporanmu akan langsung dikirim ke instansi atau pihak terkait yang bisa menangani masalahmu. Kamu bisa terus memantau progresnya lewat dashboard. Jadi, kamu tahu persis laporanmu lagi diproses sampai tahap mana.</p>
            </div>
        </div>

        <!-- Step 5 - Updated color, size, and added number -->
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <!-- Mobile circle indicator -->
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">5</span> {{-- Ditambahkan --}}
            </div>

            <div class="flex justify-start md:justify-end w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/laporanselesai.svg" alt="Laporan Selesai" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                     {{-- Desktop circle - Added leading-none to span --}}
                    <div class="absolute -left-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">5</span>
                    </div>
                </div>
            </div>
            <div class="pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-hitam mb-2">Laporan Selesai</h3>
                <p class="text-sm md:text-base text-gray-600">Jika laporanmu sudah ditangani hingga tuntas, kamu akan langsung dapat notifikasi. Kami ingin kamu selalu merasa dilibatkan dan tahu apa yang sedang terjadi. Transparan dan bisa dipercaya.</p>
            </div>
        </div>

        <!-- Step 6 - Updated color, size, and added number -->
        <div class="flex flex-col md:grid md:grid-cols-2 items-center gap-6 md:gap-8 relative timeline-step">
            <div class="w-10 h-10 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center absolute left-0 top-6 md:hidden">
                <span class="text-white font-bold text-lg leading-none">6</span> {{-- Ditambahkan --}}
            </div>

            <div class="order-1 md:order-2 flex justify-start md:justify-start w-full md:w-auto pl-14 md:pl-0">
                <div class="relative">
                    <img src="img/Desain/report.svg" alt="Beri Ulasan" class="w-24 h-24 md:w-40 md:h-40 object-cover rounded-xl shadow-lg">
                     {{-- Desktop circle - Added leading-none to span --}}
                    <div class="absolute -right-6 top-1/2 transform -translate-y-1/2 w-12 h-12 rounded-full bg-yellow-400 border-4 border-white flex items-center justify-center hidden md:block">
                        <span class="text-white font-bold p-3">6</span>
                    </div>
                </div>
            </div>
            <div class="order-2 md:order-1 md:text-right pl-14 md:pl-0">
                <h3 class="text-xl md:text-2xl font-bold text-hitam mb-2">Beri Ulasan</h3>
                <p class="text-sm md:text-base text-gray-600">Terakhir, jangan lupa untuk kasih ulasan ya! Kamu bisa menilai proses penanganan laporanmu, apakah sudah memuaskan atau masih ada yang perlu ditingkatkan. Masukan dari kamu sangat berharga buat kami agar terus berkembang dan memberikan layanan yang lebih baik ke depannya.</p>
            </div>
        </div>
    </div>
</section>


<section class="bg-kuning py-16">
    <div class="container mx-auto text-center px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-hitam mb-4">
            <span class="italic">Ada masalah?</span> Jangan diam saja!
        </h2>
        <p class="text-hitam text-lg md:text-xl mb-8 italic">
            Laporkan sekarang juga agar segera ditindaklanjuti. <span class="not-italic font-semibold">Suaramu penting</span> untuk perubahan!
        </p>
        <a href="/login" class="inline-block font-semibold text-lg bg-white text-hitam hover:text-white hover:bg-kuning hover:ring-2 ring-white hover:bg-opacity-90 transform hover:scale-[0.98] transition-all duration-200 px-8 py-3 rounded-full shadow-lg ">
            Ayo Lapor!
        </a>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center text-hitam mb-12">Frequently Asked Questions Lapor.pal</h2>

    <div class="max-w-3xl mx-auto space-y-4">
        <!-- FAQ Item 1 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Apakah saya bisa mengunggah foto atau video dari galeri saat membuat laporan pengaduan?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Tidak. Sistem hanya memperbolehkan pengambilan foto atau video secara langsung dari kamera untuk memastikan keaslian laporan dan mencegah manipulasi data.</p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Bagaimana cara memastikan bahwa laporan saya diterima dan ditindaklanjuti oleh pihak pemerintah?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Setelah laporan dikirim, Anda bisa memantau status laporan melalui dashboard. Status laporan akan berubah dari pending → on-progress → selesai. Jika tidak ada progres dalam 1 bulan, laporan akan otomatis di-escalate ke pemerintah pusat.</p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Apakah saya bisa membuat lebih dari satu laporan di lokasi yang sama?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Sistem membatasi maksimal 5 laporan untuk satu lokasi dalam radius 5 meter. Jika sudah ada 5 laporan yang masuk dari lokasi tersebut, laporan baru akan ditolak untuk mencegah spam dan penumpukan pengaduan.</p>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Apa keuntungan bagi masyarakat yang aktif melapor?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Masyarakat akan mendapatkan poin reward yang dapat ditukar dengan hadiah digital (seperti pulsa atau token listrik) serta potongan pajak daerah bagi pelapor dengan rekam jejak kredibel.</p>
            </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Bagaimana sistem ini menjaga keamanan dan transparansi data laporan?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Setiap laporan tercatat di blockchain, yang tidak bisa diedit atau dihapus. Perubahan status laporan juga dicatat otomatis menggunakan smart contract untuk menjaga keaslian dan integritas data.</p>
            </div>
        </div>

        <!-- FAQ Item 7 -->
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Bagaimana sistem mencegah pemerintah daerah mengunggah bukti penyelesaian palsu?</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Sistem menggunakan teknologi AI (Computer Vision & GPS) untuk memverifikasi bahwa foto/video bukti diambil langsung dari lokasi pengaduan dan sesuai dengan kategori yang dilaporkan.</p>
            </div>
        </div>
        <div class="border border-kuning rounded-lg overflow-hidden">
            <button class="faq-toggle w-full flex justify-between items-center p-6 bg-kuning hover:bg-gray-100 transition-colors">
                <h3 class="text-xl font-semibold text-left" style="font-size: 18px;">Apakah tersedia di Aplikasi Mobile</h3>
                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600" style="font-size: 16px;">Saat ini belum ada aplikasi mobile, namun situs ini di rancang responsive mobile dan tetap nyaman digunakan di ponsel.</p>
            </div>
        </div>
    </div>
</section>

<style>
    #progressLine {
    }
    .timeline-step .md\\:block .bg-gray-300 {
         background-color: #D1D5DB; /* Example gray color */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Toggle Functionality
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            // Toggle content
            content.classList.toggle('hidden');

            // Rotate icon
            icon.classList.toggle('rotate-180');

            // Toggle background color
            button.classList.toggle('bg-gray-100');
        });
    });

    // Timeline Progress Functionality
    const progressLine = document.getElementById('progressLine');
    const timelineContainer = document.querySelector('.relative.space-y-8'); // The container of all steps
    const timelineSteps = document.querySelectorAll('.timeline-step'); // Added class 'timeline-step' to each step div

    function updateProgress() {
        if (!timelineContainer || !progressLine) return; // Exit if elements not found

        const timelineRect = timelineContainer.getBoundingClientRect();
        const timelineTopRelativeToDocument = timelineRect.top + window.scrollY;
        const timelineHeight = timelineContainer.offsetHeight;
        const viewportHeight = window.innerHeight;
        const scrollY = window.scrollY;

        // Calculate how far the bottom of the viewport is past the top of the timeline
        const scrollAmountPastTimelineStart = scrollY + viewportHeight - timelineTopRelativeToDocument;

        // Calculate progress percentage relative to the total timeline height
        // Ensure progress doesn't exceed 100% or go below 0%
        const progress = Math.max(0, Math.min(1, scrollAmountPastTimelineStart / timelineHeight));
        const progressPercentage = progress * 100;

        // Update the progress line height
        progressLine.style.height = `${progressPercentage}%`;

        // Update active steps based on scroll position (middle of viewport logic)
        const viewportMiddle = scrollY + viewportHeight / 2;

        timelineSteps.forEach((step) => {
            const stepRect = step.getBoundingClientRect();
            const stepTopRelativeToDocument = stepRect.top + scrollY;
            const stepMiddleRelativeToDocument = stepTopRelativeToDocument + (stepRect.height / 2);

            // Find the desktop circle within this step
            const circle = step.querySelector('.hidden.md\\:block .rounded-full');
            if (circle) {
                // If the step's middle point is above or at the viewport middle, activate it
                if (stepMiddleRelativeToDocument <= viewportMiddle) {
                    circle.classList.add('bg-yellow-400');
                    circle.classList.remove('bg-gray-300'); // Use gray for inactive
                } else {
                    // Otherwise, deactivate it
                    circle.classList.remove('bg-yellow-400');
                    circle.classList.add('bg-gray-300'); // Use gray for inactive
                }
            }
        });
    }

    // Initial update
    updateProgress();

    // Update on scroll and resize
    window.addEventListener('scroll', updateProgress);
    window.addEventListener('resize', updateProgress);
});
</script>

@endsection
