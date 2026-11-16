@extends('layouts.app', ['metaTitle' => $project->meta_title ?? ($project->localized_title . ' | Asad Interior Design'), 'metaDescription' => $project->meta_description ?? $project->summary])

@section('content')
<section class="relative bg-charcoal-deep text-offwhite py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    @if($project->cover_image)
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ \App\Support\MediaHelper::url($project->cover_image) }}');"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-charcoal-deep via-charcoal-deep/75 to-transparent"></div>
    <div class="relative z-10 max-w-6xl mx-auto space-y-6">
        <a href="{{ route('portfolio.index') }}" class="text-xs uppercase tracking-widest text-gold hover:underline">&larr; Back to Portfolio</a>
        <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-full bg-gold/20 text-gold border border-gold/30 text-xs font-bold uppercase">{{ $project->style }}</span>
            <span class="px-3 py-1 rounded-full bg-white/10 text-offwhite text-xs font-semibold uppercase">{{ $project->category?->localized_name ?? $project->room_type }}</span>
        </div>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">{{ $project->localized_title }}</h1>
        <p class="text-base sm:text-lg text-offwhite/80 max-w-3xl">{{ $project->summary }}</p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-white/15">
            <div>
                <div class="text-[11px] uppercase tracking-widest text-offwhite/50">Location</div>
                <div class="font-serif text-xl font-bold text-gold-light">{{ $project->location }}</div>
            </div>
            <div>
                <div class="text-[11px] uppercase tracking-widest text-offwhite/50">Floor Area</div>
                <div class="font-serif text-xl font-bold text-gold-light">{{ number_format((int) $project->area_sqft) }} sq ft</div>
            </div>
            <div>
                <div class="text-[11px] uppercase tracking-widest text-offwhite/50">Duration</div>
                <div class="font-serif text-xl font-bold text-gold-light">{{ $project->duration ?? 'Turnkey' }}</div>
            </div>
            <div>
                <div class="text-[11px] uppercase tracking-widest text-offwhite/50">Year</div>
                <div class="font-serif text-xl font-bold text-gold-light">{{ $project->completion_year }}</div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-6xl mx-auto space-y-16">
        @if($project->description)
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/5 shadow-lg prose max-w-none">
                <h2 class="font-serif text-3xl font-bold mb-4">Architectural Narrative</h2>
                {!! $project->description !!}
            </div>
        @endif

        @if($project->before_image && $project->after_image)
            <div class="space-y-4">
                <h2 class="font-serif text-3xl font-bold text-charcoal">Before &amp; After Transformation</h2>
                <x-before-after :beforeImage="$project->before_image" :afterImage="$project->after_image" :title="$project->localized_title" />
            </div>
        @endif

        @php $gallery = \App\Support\MediaHelper::urls($project->gallery_images); @endphp
        @if(!empty($gallery))
            <div class="space-y-4">
                <h2 class="font-serif text-3xl font-bold text-charcoal">Spatial Gallery</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($gallery as $img)
                        <a href="{{ $img }}" class="glightbox block rounded-2xl overflow-hidden h-64 shadow-md hover:shadow-xl transition-all group">
                            <img src="{{ $img }}" alt="{{ $project->localized_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($project->model_3d_path)
            <div class="space-y-4">
                <h2 class="font-serif text-3xl font-bold text-charcoal">Interactive 3D / AR Model</h2>
                <div class="bg-charcoal-deep rounded-3xl h-[460px] p-4 border border-gold/25">
                    <model-viewer
                        src="{{ \App\Support\MediaHelper::url($project->model_3d_path) }}"
                        alt="{{ $project->localized_title }} 3D"
                        auto-rotate
                        camera-controls
                        ar
                        shadow-intensity="1.2"
                        class="w-full h-full"
                    ></model-viewer>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

