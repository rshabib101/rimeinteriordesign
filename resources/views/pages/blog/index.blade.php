@extends('layouts.app', ['metaTitle' => 'The Design Journal | Asad Interior Design'])

@section('content')
<section class="bg-charcoal-deep text-offwhite py-20 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto space-y-4">
        <span class="px-4 py-1.5 rounded-full bg-gold/20 text-gold-light text-xs font-bold uppercase tracking-widest border border-gold/30 inline-block">Editorial</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold">The Design Journal</h1>
        <p class="text-offwhite/70 max-w-2xl mx-auto text-sm sm:text-base">Architectural essays, lighting guides, and material studies from our Dhaka studio.</p>
    </div>
</section>

<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#F8F5F0]">
    <div class="max-w-7xl mx-auto space-y-10">
        <!-- Search & Categories -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-5 rounded-2xl border border-black/5 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ !request('category') ? 'bg-charcoal text-gold' : 'bg-[#F8F5F0] text-charcoal/70' }}">All Topics</a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ request('category') === $cat ? 'bg-charcoal text-gold' : 'bg-[#F8F5F0] text-charcoal/70' }}">{{ $cat }}</a>
                @endforeach
            </div>

            <form action="{{ route('blog.index') }}" method="GET" class="w-full md:w-72 flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="w-full px-4 py-2.5 rounded-l-xl bg-[#F8F5F0] border border-black/10 text-xs outline-none focus:border-gold" />
                <button type="submit" class="px-4 py-2.5 rounded-r-xl bg-gold text-charcoal-deep text-xs font-bold uppercase">Find</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group bg-white rounded-3xl overflow-hidden border border-black/5 shadow-lg hover:shadow-2xl transition-all flex flex-col">
                    <div class="h-56 overflow-hidden">
                        <img src="{{ \App\Support\MediaHelper::url($post->cover_image) }}" alt="{{ $post->localized_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy" />
                    </div>
                    <div class="p-6 space-y-3 flex-grow flex flex-col justify-between">
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between text-[11px] text-gold-dark font-bold uppercase tracking-wider">
                                <span>{{ $post->category }}</span>
                                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                            </div>
                            <h2 class="font-serif text-2xl font-bold text-charcoal group-hover:text-gold transition-colors leading-snug">{{ $post->localized_title }}</h2>
                            <p class="text-xs text-charcoal/65 leading-relaxed">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                        </div>
                        <div class="pt-4 border-t border-black/5 flex justify-between items-center text-xs text-charcoal/50">
                            <span>By {{ $post->author?->name ?? 'Asad Editorial' }}</span>
                            <span class="text-gold font-bold">Read &rarr;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-16 text-charcoal/60">No articles found.</div>
            @endforelse
        </div>

        <div>{{ $posts->links() }}</div>
    </div>
</section>
@endsection

