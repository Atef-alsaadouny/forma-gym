@php
    $gallery = [
        [
            'src' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=200&q=40',
            'title' => __('messages.tour_gallery_1_title'),
            'desc' => __('messages.tour_gallery_1_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=200&q=40',
            'title' => __('messages.tour_gallery_2_title'),
            'desc' => __('messages.tour_gallery_2_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=200&q=40',
            'title' => __('messages.tour_gallery_3_title'),
            'desc' => __('messages.tour_gallery_3_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=200&q=40',
            'title' => __('messages.tour_gallery_4_title'),
            'desc' => __('messages.tour_gallery_4_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=200&q=40',
            'title' => __('messages.tour_gallery_5_title'),
            'desc' => __('messages.tour_gallery_5_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=200&q=40',
            'title' => __('messages.tour_gallery_6_title'),
            'desc' => __('messages.tour_gallery_6_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=200&q=40',
            'title' => __('messages.tour_gallery_7_title'),
            'desc' => __('messages.tour_gallery_7_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=200&q=40',
            'title' => __('messages.tour_gallery_8_title'),
            'desc' => __('messages.tour_gallery_8_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?w=200&q=40',
            'title' => __('messages.tour_gallery_9_title'),
            'desc' => __('messages.tour_gallery_9_desc'),
        ],
        [
            'src' => 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=800&q=80',
            'thumb' => 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=200&q=40',
            'title' => __('messages.tour_gallery_10_title'),
            'desc' => __('messages.tour_gallery_10_desc'),
        ],
    ];
@endphp

<section id="tour" class="bg-gym-dark px-4 py-8 sm:px-6 lg:px-8 reveal scroll-mt-24">
    <div class="mx-auto max-w-7xl">
        <div class="text-center reveal">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">{{ __('messages.tour_title') }}</h2>
            <p class="mt-2 text-base text-white/60">{{ __('messages.tour_subtitle') }}</p>
        </div>

        <div id="tour-skeleton" class="hidden mt-8 space-y-4">
            <div class="skeleton aspect-video w-full rounded-2xl"></div>
            <div class="flex justify-center gap-3">
                @foreach (range(1, 10) as $i)
                    <div class="skeleton h-16 w-28 rounded-xl"></div>
                @endforeach
            </div>
        </div>

        <div id="tour-content" class="mt-8">
            {{-- Main Display --}}
            <div class="relative overflow-hidden rounded-2xl bg-gym-card">
                <div id="tour-main" class="relative aspect-video">
                    <img id="tour-display"
                        src="{{ $gallery[0]['src'] }}"
                        alt="{{ $gallery[0]['title'] }}"
                        class="h-full w-full cursor-pointer object-cover transition-opacity duration-500"
                        fetchpriority="high"
                        onclick="openLightbox(currentIndex)">
                    <div class="absolute inset-0 bg-gradient-to-t from-gym-dark/90 via-transparent to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 pointer-events-none">
                        <h3 id="tour-title" class="text-lg font-bold text-white sm:text-xl">{{ $gallery[0]['title'] }}</h3>
                        <p id="tour-desc" class="mt-1 text-sm text-white/70">{{ $gallery[0]['desc'] }}</p>
                    </div>
                    <button onclick="openLightbox(currentIndex)"
                        class="absolute left-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white/70 transition-all duration-200 hover:bg-gym-primary hover:text-gym-dark hover:shadow-lg">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Thumbnail Grid --}}
            <div class="mt-4 grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6">
                @foreach ($gallery as $index => $item)
                    <button data-index="{{ $index }}"
                        onclick="showItem({{ $index }})"
                        class="tour-thumb group relative overflow-hidden rounded-xl border-2 transition-all duration-200 aspect-video {{ $index === 0 ? 'border-gym-primary' : 'border-white/10 hover:border-gym-primary/50' }}">
                        <img src="{{ $item['thumb'] }}"
                            alt="{{ $item['title'] }}"
                            class="h-full w-full object-cover"
                            loading="lazy">
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/50 via-transparent to-transparent p-1.5 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                            <span class="text-[10px] font-medium text-white truncate">{{ $item['title'] }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div id="lightbox" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-sm opacity-0 transition-opacity duration-300 select-none">
        {{-- Close --}}
        <button onclick="closeLightbox()" class="absolute right-3 md:right-6 top-3 md:top-6 z-30 flex items-center justify-center rounded-full transition-all duration-200 active:scale-95 h-10 w-10 md:h-12 md:w-12 bg-black/50 md:bg-black/40 text-white md:text-white md:shadow-lg md:backdrop-blur-sm ring-1 ring-white/30 hover:bg-white/20 hover:scale-110">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Previous --}}
        <button onclick="prevItem()" class="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 z-30 flex items-center justify-center rounded-full transition-all duration-200 active:scale-95 h-12 w-12 md:h-16 md:w-16 bg-black/50 md:bg-black/40 text-white md:text-white md:shadow-lg md:backdrop-blur-sm ring-1 ring-white/30 hover:bg-white/20 hover:scale-110">
            <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Next --}}
        <button onclick="nextItem()" class="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 z-30 flex items-center justify-center rounded-full transition-all duration-200 active:scale-95 h-12 w-12 md:h-16 md:w-16 bg-black/50 md:bg-black/40 text-white md:text-white md:shadow-lg md:backdrop-blur-sm ring-1 ring-white/30 hover:bg-white/20 hover:scale-110">
            <svg class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Image --}}
        <div class="flex max-h-[90vh] max-w-[90vw] items-center justify-center p-4 md:px-20">
            <img id="lightbox-img" class="max-h-[85vh] max-w-full rounded-2xl object-contain shadow-2xl" src="" alt="">
        </div>

        {{-- Counter --}}
        <div class="absolute bottom-6 left-1/2 z-20 -translate-x-1/2 text-center">
            <p id="lightbox-counter" class="rounded-full bg-black/40 px-4 py-1.5 text-sm text-white/70 backdrop-blur-sm"></p>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            const skeleton = document.getElementById('tour-skeleton');
            const content = document.getElementById('tour-content');
            if (skeleton && content) {
                skeleton.classList.add('hidden');
                content.style.display = 'block';
            }
        })();

        const gallery = @json($gallery);
        let currentIndex = 0;

        function showItem(index) {
            const item = gallery[index];
            const display = document.getElementById('tour-display');
            const title = document.getElementById('tour-title');
            const desc = document.getElementById('tour-desc');
            const thumbnails = document.querySelectorAll('.tour-thumb');

            thumbnails.forEach(t => {
                t.classList.remove('border-gym-primary');
                t.classList.add('border-white/10');
            });
            thumbnails[index].classList.remove('border-white/10');
            thumbnails[index].classList.add('border-gym-primary');

            display.src = item.src;
            display.alt = item.title;
            title.textContent = item.title;
            desc.textContent = item.desc;
            currentIndex = index;
        }

        function openLightbox(index) {
            currentIndex = index;
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            const counter = document.getElementById('lightbox-counter');

            img.src = gallery[index].src;
            img.alt = gallery[index].title;
            counter.textContent = (index + 1) + ' / ' + gallery.length;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                lightbox.classList.add('flex');
                requestAnimationFrame(() => {
                    lightbox.classList.remove('opacity-0');
                });
            });
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('opacity-0');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
            }, 300);
            document.body.style.overflow = '';
        }

        function prevItem() {
            currentIndex = (currentIndex - 1 + gallery.length) % gallery.length;
            openLightbox(currentIndex);
        }

        function nextItem() {
            currentIndex = (currentIndex + 1) % gallery.length;
            openLightbox(currentIndex);
        }

        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('lightbox');
            if (lightbox.classList.contains('hidden')) return;

            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextItem();
            if (e.key === 'ArrowLeft') prevItem();
        });

        document.getElementById('lightbox')?.addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        document.getElementById('lightbox-img')?.addEventListener('click', function(e) {
            e.stopPropagation();
            nextItem();
        });

        let touchStartX = 0;
        let touchEndX = 0;
        document.getElementById('lightbox')?.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        document.getElementById('lightbox')?.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextItem();
                else prevItem();
            }
        }, { passive: true });
    </script>
    @endpush
</section>
