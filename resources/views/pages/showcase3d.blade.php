@extends('layouts.app', ['metaTitle' => '3D & AR Design Showcase | Rime Interior Design'])

@section('content')
@php
    $models = $projects->map(fn ($p) => [
        'title' => $p->localized_title,
        'style' => $p->style,
        'location' => $p->location,
        'src' => \App\Support\MediaHelper::url($p->model_3d_path),
    ])->values();
@endphp

<section class="bg-charcoal-deep text-offwhite min-h-[85vh] py-16 px-4 sm:px-6 lg:px-8">
    <div
        x-data='{
            items: @json($models),
            activeIndex: 0,
            activeStyle: "Modern",
            exposure: 1.05,
            autoRotate: true,
            get current() { return this.items[this.activeIndex] || null; }
        }'
        class="max-w-7xl mx-auto space-y-10"
    >
        <div class="text-center space-y-4">
            <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Interactive WebGL &amp; AR</span>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold">3D Architectural Showcase</h1>
            <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Explore custom furniture and room archetypes in 360°, switch studio lighting moods, or launch Augmented Reality on supported smartphones.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Controls -->
            <div class="lg:col-span-4 glass-card-dark rounded-3xl p-6 space-y-6 border border-white/10">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gold font-bold mb-3">Select 3D Model</label>
                    <div class="space-y-2.5">
                        <template x-for="(item, idx) in items" :key="idx">
                            <button
                                type="button"
                                @click="activeIndex = idx"
                                class="w-full text-left p-4 rounded-2xl border transition-all"
                                :class="activeIndex === idx ? 'bg-gold/20 border-gold text-offwhite' : 'bg-white/5 border-white/10 text-offwhite/75 hover:border-gold/40'"
                            >
                                <div class="font-serif text-lg font-bold" x-text="item.title"></div>
                                <div class="text-xs text-gold-light mt-0.5" x-text="item.style + ' • ' + item.location"></div>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/10">
                    <label class="block text-xs uppercase tracking-widest text-gold font-bold mb-3">Style &amp; Mood Lighting</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['Modern' => 1.05, 'Minimal' => 1.3, 'Classic' => 0.9, 'Scandinavian' => 1.45] as $styleName => $exp)
                            <button
                                type="button"
                                @click="activeStyle = '{{ $styleName }}'; exposure = {{ $exp }}"
                                class="py-2.5 px-3 rounded-xl text-xs font-semibold border transition-all"
                                :class="activeStyle === '{{ $styleName }}' ? 'bg-gold text-charcoal-deep border-gold' : 'bg-white/5 text-offwhite/75 border-white/10'"
                            >
                                {{ $styleName }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                    <span class="text-xs text-offwhite/75">Auto-Rotate Turntable</span>
                    <button
                        type="button"
                        @click="autoRotate = !autoRotate"
                        class="px-4 py-1.5 rounded-full text-xs font-bold"
                        :class="autoRotate ? 'bg-gold text-charcoal-deep' : 'bg-white/10 text-offwhite'"
                        x-text="autoRotate ? 'ON' : 'OFF'"
                    ></button>
                </div>
            </div>

            <!-- Model Viewer Viewport -->
            <div class="lg:col-span-8 glass-card-dark rounded-3xl border border-gold/30 h-[520px] relative overflow-hidden p-4 flex items-center justify-center">
                <template x-if="current">
                    <model-viewer
                        :src="current.src"
                        :alt="current.title"
                        :exposure="exposure"
                        :auto-rotate="autoRotate ? true : null"
                        camera-controls
                        ar
                        shadow-intensity="1.2"
                        class="w-full h-full"
                    ></model-viewer>
                </template>
                <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-charcoal-deep/80 border border-white/15 text-xs text-gold-light" x-show="current" x-text="activeStyle + ' Studio Calibration'"></div>
            </div>
        </div>
    </div>
</section>
@endsection

