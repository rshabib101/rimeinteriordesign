<div class="space-y-10">
    <!-- Filter Controls -->
    <div class="glass-card-light rounded-3xl p-6 sm:p-8 border border-black/5 shadow-xl space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-[11px] uppercase tracking-widest font-bold text-charcoal/60 mb-2">Search Projects</label>
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Gulshan, Penthouse, Minimal..."
                        class="w-full px-4 py-3 pl-10 rounded-xl bg-white border border-black/10 focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm"
                    />
                    <svg class="w-4 h-4 text-charcoal/40 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Room Type -->
            <div>
                <label class="block text-[11px] uppercase tracking-widest font-bold text-charcoal/60 mb-2">Space Type</label>
                <select wire:model.live="roomType" class="w-full px-4 py-3 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm">
                    <option value="all">All Spaces</option>
                    @foreach($roomTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Design Style -->
            <div>
                <label class="block text-[11px] uppercase tracking-widest font-bold text-charcoal/60 mb-2">Design Style</label>
                <select wire:model.live="style" class="w-full px-4 py-3 rounded-xl bg-white border border-black/10 focus:border-gold outline-none text-sm">
                    <option value="all">All Styles</option>
                    @foreach($styles as $styleOption)
                        <option value="{{ $styleOption }}">{{ $styleOption }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Category Pills -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-black/5">
            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    wire:click="$set('category', 'all')"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $category === 'all' ? 'bg-charcoal text-gold shadow-md' : 'bg-white text-charcoal/75 hover:bg-gold/10' }}"
                >
                    All Disciplines
                </button>
                @foreach($categories as $cat)
                    <button
                        type="button"
                        wire:click="$set('category', '{{ $cat->slug }}')"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $category === $cat->slug ? 'bg-charcoal text-gold shadow-md' : 'bg-white text-charcoal/75 hover:bg-gold/10' }}"
                    >
                        {{ $cat->localized_name }}
                    </button>
                @endforeach
            </div>

            @if($category !== 'all' || $roomType !== 'all' || $style !== 'all' || $search !== '')
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="text-xs font-semibold text-gold hover:text-gold-dark underline"
                >
                    Reset Filters
                </button>
            @endif
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="w-full text-center py-4 text-xs uppercase tracking-widest text-gold font-semibold">
        Curating Portfolio...
    </div>

    <!-- Projects Masonry / Grid -->
    @if($projects->isEmpty())
        <div class="text-center py-20 rounded-3xl bg-white/60 border border-black/5">
            <p class="font-serif text-2xl text-charcoal mb-2">No projects match this filter combination.</p>
            <p class="text-sm text-charcoal/60 mb-6">Try broadening your space or style criteria.</p>
            <button wire:click="resetFilters" class="px-6 py-3 rounded-full bg-gold text-charcoal-deep text-xs font-bold uppercase tracking-wider">
                View All Projects
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <a href="{{ route('portfolio.show', $project->slug) }}" class="block group" wire:key="project-{{ $project->id }}">
                    <x-card-3d :dark="false" class="h-full flex flex-col">
                        <div class="relative h-64 rounded-xl overflow-hidden mb-5">
                            <img
                                src="{{ \App\Support\MediaHelper::url($project->cover_image) }}"
                                alt="{{ $project->localized_title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal-deep/85 via-transparent to-transparent"></div>
                            <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-full bg-charcoal-deep/80 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-gold">
                                    {{ $project->style }}
                                </span>
                                @if($project->model_3d_path)
                                    <span class="px-2.5 py-1 rounded-full bg-gold text-charcoal-deep text-[10px] font-bold uppercase tracking-wider">
                                        3D View
                                    </span>
                                @endif
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-offwhite">
                                <div class="text-[11px] text-gold-light font-medium">{{ $project->location }} • {{ number_format((int) $project->area_sqft) }} sq ft</div>
                                <h3 class="font-serif text-xl font-bold leading-snug group-hover:text-gold transition-colors">
                                    {{ $project->localized_title }}
                                </h3>
                            </div>
                        </div>

                        <p class="text-xs text-charcoal/70 leading-relaxed mb-4 flex-grow">
                            {{ \Illuminate\Support\Str::limit($project->summary, 115) }}
                        </p>

                        <div class="flex items-center justify-between text-xs pt-3 border-t border-black/5">
                            <span class="text-charcoal/50">{{ $project->category?->localized_name ?? ucfirst($project->room_type) }}</span>
                            <span class="text-gold font-bold inline-flex items-center space-x-1">
                                <span>{{ __('messages.cta.view_details') }}</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </x-card-3d>
                </a>
            @endforeach
        </div>
    @endif
</div>

