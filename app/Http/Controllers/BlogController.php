<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::has('articles')->get();
        $query = Article::with('category')->where('is_published', true);

        if ($request->has('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($request->has('author')) {
            $query->where('author', $request->author);
        }

        $articles = $query->latest()->paginate(9)->withQueryString();

        return view('blog.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        // A. Ambil Data Artikel
        $article = Article::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // B. Ambil Artikel Terbaru (Untuk Sidebar)
        $recentArticles = Article::with('category')
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(4)
            ->get();

        // ==============================================================
        // [BARU] C. Ambil Artikel Terkait (Satu Kategori, untuk Artikel Lainnya)
        // ==============================================================
        $relatedArticles = Article::with('category')
            ->where('category_id', $article->category_id)
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        // ==============================================================
        // 1. LOGIKA UNTUK TABLE OF CONTENTS (ANCHOR LINK)
        // ==============================================================
        $tocData = [];

        $contentWithIds = preg_replace_callback('/<h([2-3])>(.*?)<\/h\1>/', function ($matches) use (&$tocData) {
            $level = $matches[1];
            $text  = strip_tags($matches[2]);
            $id    = Str::slug($text);

            $tocData[] = ['level' => $level, 'text' => $text, 'id' => $id];

            return "<h$level id='$id'>$matches[2]</h$level>";
        }, $article->content);

        // --- GENERATE HTML TOC ---
        $tocHtml = '';
        if (count($tocData) > 0) {
            $tocHtml .= '<div class="my-8 bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">';
            $tocHtml .= '<h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 border-b border-gray-200 pb-2">';
            $tocHtml .= '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>';
            $tocHtml .= 'Daftar Isi</h3>';
            $tocHtml .= '<ul class="space-y-1">';
            foreach ($tocData as $item) {
                $padding = ($item['level'] == 3) ? 'pl-4 text-gray-500' : 'text-gray-700 font-medium';
                $tocHtml .= '<li><a href="#' . $item['id'] . '" class="block py-1 text-sm ' . $padding . ' hover:text-green-600 transition-colors hover:underline decoration-green-500 underline-offset-2">' . $item['text'] . '</a></li>';
            }
            $tocHtml .= '</ul></div>';
        }

        // ==============================================================
        // 2. LOGIKA BANNER IKLAN (IMPLEMENTASI DUA GAMBAR BERBEDA)
        // ==============================================================
        $targetUrl = '/login?mode=register';

        // --- BANNER 1: UNTUK DI DALAM KONTEN (Gambar: coba.jpg) ---
        $imageContent = asset('images/ban.jpeg');
        $bannerAd = '
        <div class="my-12 w-full">
            <a href="' . $targetUrl . '" class="block" title="Daftar Sekarang">
                <img src="' . $imageContent . '" 
                     alt="Promo Tahfidz Konten" 
                     width="1022" 
                     height="374"
                     class="w-full h-auto object-cover !rounded-none !shadow-none !border-none m-0"
                     style="border-radius: 0 !important; box-shadow: none !important; margin: 0 !important;"
                     loading="lazy">
            </a>
        </div>';

        // --- BANNER 2: SIDEBAR SLIDER (DENGAN URL BERBEDA) ---
        $sliderData = [
            [
                'image' => asset('images/tah.jpeg'),
                'link'  => '/program/tahsin-dewasa' // Target URL Gambar 1
            ],
            [
                'image' => asset('images/arab.png'),
                'link'  => '/program/bahasa-arab' // Target URL Gambar 2
            ],
        ];

        // Encode data agar bisa dibaca oleh Alpine.js
        $jsonSlides = json_encode($sliderData);

        $sidebarBanner = '
        <div x-data="{ 
                activeSlide: 0, 
                slides: ' . htmlspecialchars($jsonSlides) . ',
                init() {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length
                    }, 5000);
                }
            }" 
           class="w-full mt-8 mb-6 lg:mt-0 lg:mb-8 relative overflow-hidden group border-none">
            
            <div class="relative w-full overflow-hidden border-none shadow-none">
                <div class="flex flex-row transition-transform duration-700 ease-in-out border-none" 
                     :style="`width: ${slides.length * 100}%; gap: 0rem; transform: translateX(-${activeSlide * (100 / slides.length)}%)`"
                     style="display: flex;">
                    
                    <template x-for="(slide, index) in slides" :key="index">
                        <div :style="`width: ${100 / slides.length}%`" class="w-full flex-shrink-0 border-none">
                            <a :href="slide.link" class="block w-full border-none outline-none">
                                <img :src="slide.image" 
                                     class="w-full h-auto object-cover !rounded-none !shadow-none !border-none m-0 p-0 block" 
                                     style="border-radius: 0 !important; box-shadow: none !important; margin: 0 !important; width: 100%; display: block;"
                                     loading="lazy">
                            </a>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-center items-center gap-1.5 mt-4 w-full">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            :class="activeSlide === index ? \'bg-green-600 w-4\' : \'bg-gray-300 w-1.5\'"
                            class="h-1.5 rounded-full transition-all duration-300 border-none outline-none"></button>
                </template>
            </div>
        </div>';

        // Pecah konten menjadi array per paragraf
        $paragraphs = explode('</p>', $contentWithIds);

        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $paragraphs[$index] .= '</p>';
            }

            // SISIPKAN TOC (Index 0)
            if ($index == 0) {
                $paragraphs[$index] .= $tocHtml;
            }

            // SISIPKAN IKLAN KONTEN (Index 3)
            if ($index == 3) {
                $paragraphs[$index] .= $bannerAd;
            }
        }

        $finalContent = implode('', $paragraphs);

        // ==============================================================
        // [UPDATE] Tambahkan $relatedArticles ke compact()
        // ==============================================================
        return view('blog.show', compact('article', 'recentArticles', 'relatedArticles', 'finalContent', 'sidebarBanner'));
    }
}