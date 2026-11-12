@extends('layouts.app', [
    'metaTitle' => $post->meta_title ?? ($post->localized_title . ' | Rime Design Journal'),
    'metaDescription' => $post->meta_description ?? $post->excerpt,
    'ogType' => 'article',
    'metaImage' => \App\Support\MediaHelper::url($post->cover_image),
])

@push('structured-data')
<script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->localized_title,
        'description' => $post->excerpt,
        'datePublished' => $post->published_at?->toAtomString(),
        'author' => ['@type' => 'Person', 'name' => $post->author?->name ?? 'Rime Editorial'],
        'image' => \App\Support\MediaHelper::url($post->cover_image),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<article class="bg-[#F8F5F0] pb-24">
    <header class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-5 text-center">
            <a href="{{ route('blog.index') }}" class="text-xs uppercase tracking-widest text-gold hover:underline">&larr; Back to Journal</a>
            <div class="text-xs font-bold uppercase tracking-widest text-gold-light">{{ $post->category }} • {{ $post->published_at?->format('F d, Y') }}</div>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold leading-tight">{{ $post->localized_title }}</h1>
            <div class="text-xs text-offwhite/60">By {{ $post->author?->name ?? 'Rime Studio' }} • {{ number_format($post->views_count) }} views</div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 space-y-10">
        @if($post->cover_image)
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-black/10 h-[360px] sm:h-[460px]">
                <img src="{{ \App\Support\MediaHelper::url($post->cover_image) }}" alt="{{ $post->localized_title }}" class="w-full h-full object-cover" />
            </div>
        @endif

        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-black/5 prose max-w-none leading-relaxed text-charcoal/85">
            {!! $post->content !!}
        </div>

        @if(!empty($post->tags))
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.index', ['tag' => $tag]) }}" class="px-4 py-1.5 rounded-full bg-white border border-black/10 text-xs font-semibold hover:border-gold">
                        #{{ $tag }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</article>
@endsection

