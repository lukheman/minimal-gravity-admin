<?php

namespace Database\Seeders;

use App\Models\Collaboration;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Testimonial;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Admin',
            'password' => 'password123',
        ]);

        $services = [
            ['category' => 'pelatihan', 'name' => 'Pelatihan', 'slug' => 'pelatihan', 'description' => 'Program pelatihan interaktif untuk meningkatkan kapasitas tim dan organisasi.', 'features' => ['Modul terstruktur', 'Fasilitator berpengalaman', 'Dokumentasi kegiatan'], 'sort_order' => 1],
            ['category' => 'workshop', 'name' => 'Workshop', 'slug' => 'workshop', 'description' => 'Workshop praktis yang dirancang sesuai tujuan dan kebutuhan peserta.', 'features' => ['Konsep custom', 'Aktivitas kolaboratif', 'Evaluasi pasca-acara'], 'sort_order' => 2],
            ['category' => 'seminar', 'name' => 'Seminar', 'slug' => 'seminar', 'description' => 'Seminar profesional dengan alur acara yang terencana dan pengalaman peserta yang nyaman.', 'features' => ['Rundown acara', 'Manajemen pembicara', 'Registrasi peserta'], 'sort_order' => 3],
            ['category' => 'penyewaan', 'name' => 'Penyewaan', 'slug' => 'penyewaan', 'description' => 'Kebutuhan perlengkapan dan venue untuk mendukung acara Anda.', 'features' => ['Sound system', 'Tenda dan venue', 'Perlengkapan event'], 'sort_order' => 4],
        ];
        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        foreach ([
            'site_name' => 'Nusa Event',
            'footer_tagline' => 'Partner acara profesional untuk momen penting Anda.',
            'hero_eyebrow' => 'Event organizer untuk momen penting',
            'hero_title' => 'Membuat momen penting terasa lebih berarti.',
            'hero_subtitle' => 'Kami merancang dan menyelenggarakan acara yang rapi, hangat, dan meninggalkan kesan — dari pelatihan hingga penyewaan perlengkapan.',
            'hero_note' => 'Dipercaya instansi, sekolah, perusahaan, dan komunitas.',
            'about' => 'Nusa Event Organizer membantu organisasi, sekolah, perusahaan, dan komunitas menciptakan acara yang bermakna.',
            'vision' => 'Menjadi partner event terpercaya untuk setiap momen penting.',
            'mission' => 'Menghadirkan perencanaan matang, eksekusi rapi, dan pengalaman yang berkesan.',
            'address' => 'Jl. Merdeka No. 10, Makassar',
            'email' => 'halo@nusaevent.id',
            'whatsapp_number' => '6281234567890',
            'whatsapp_template' => 'Halo, saya ingin berkonsultasi tentang layanan event organizer.',
            'operating_hours' => 'Senin–Sabtu, 08.00–17.00',
        ] as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        SocialLink::updateOrCreate(['platform' => 'Instagram'], ['url' => 'https://instagram.com', 'icon' => 'fa-brands fa-instagram', 'sort_order' => 1]);

        foreach ([
            ['name' => 'Rina Pratama', 'organization' => 'SMK Harapan', 'comment' => 'Tim Nusa Event sangat membantu dari awal sampai acara selesai.', 'rating' => 5],
            ['name' => 'Andi Saputra', 'organization' => 'PT Karya Nusantara', 'comment' => 'Workshop berjalan sesuai rencana dan peserta sangat antusias.', 'rating' => 5],
            ['name' => 'Maya Lestari', 'organization' => 'Komunitas Tumbuh', 'comment' => 'Komunikasi jelas dan detail acara diperhatikan dengan baik.', 'rating' => 5],
        ] as $testimonial) {
            Testimonial::firstOrCreate(['name' => $testimonial['name']], $testimonial);
        }

        foreach ([
            ['partner_name' => 'SMK Harapan', 'event_name' => 'Seminar Kepemimpinan', 'slug' => 'seminar-kepemimpinan-smk-harapan', 'event_date' => now()->subMonths(2), 'service_category' => 'seminar', 'description' => 'Seminar pengembangan kepemimpinan untuk siswa dengan alur acara yang terencana.'],
            ['partner_name' => 'PT Karya Nusantara', 'event_name' => 'Workshop Kolaborasi Tim', 'slug' => 'workshop-kolaborasi-tim', 'event_date' => now()->subMonths(5), 'service_category' => 'workshop', 'description' => 'Workshop peningkatan kolaborasi lintas divisi untuk tim internal.'],
            ['partner_name' => 'Komunitas Tumbuh', 'event_name' => 'Pelatihan Fasilitator Muda', 'slug' => 'pelatihan-fasilitator-muda', 'event_date' => now()->subMonths(9), 'service_category' => 'pelatihan', 'description' => 'Pelatihan fasilitator untuk komunitas dengan modul dan pendampingan.'],
        ] as $collaboration) {
            Collaboration::updateOrCreate(['slug' => $collaboration['slug']], $collaboration);
        }
    }
}
