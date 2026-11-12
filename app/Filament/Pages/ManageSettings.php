<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

/**
 * Dynamic Site Settings page allowing Admins/Editors to manage Hero, About, Process, Pricing, Contact, Social, and SEO/Analytics.
 *
 * @property-read Schema $form
 */
class ManageSettings extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings & Access';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Site & Hero Settings';

    protected static ?string $title = 'Studio & Website Settings';

    protected string $view = 'filament.pages.manage-settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name'            => Setting::get('site_name', 'Rime Interior Design'),
            'notice_bar_text'      => Setting::get('notice_bar_text', 'Accepting Q1 & Q2 2027 Projects'),
            'hero_badge'           => Setting::get('hero_badge', 'Architecture & Interior Curation • Dhaka'),
            'hero_badge_bn'        => Setting::get('hero_badge_bn', ''),
            'tagline'              => Setting::get('tagline', 'Designing Spaces That Feel Like You'),
            'tagline_bn'           => Setting::get('tagline_bn', ''),
            'hero_subtitle'        => Setting::get('hero_subtitle', ''),
            'hero_subtitle_bn'     => Setting::get('hero_subtitle_bn', ''),
            'hero_enable_3d'       => Setting::get('hero_enable_3d', '1') === '1',
            'hero_image'           => Setting::get('hero_image', ''),
            'stat_1_value'         => Setting::get('stat_1_value', '150+'),
            'stat_1_label'         => Setting::get('stat_1_label', 'Projects Handed Over'),
            'stat_2_value'         => Setting::get('stat_2_value', '8+'),
            'stat_2_label'         => Setting::get('stat_2_label', 'Years of Mastery'),
            'stat_3_value'         => Setting::get('stat_3_value', '100%'),
            'stat_3_label'         => Setting::get('stat_3_label', 'Turnkey Accountability'),
            'stat_4_value'         => Setting::get('stat_4_value', '5 Yrs'),
            'stat_4_label'         => Setting::get('stat_4_label', 'Craftsmanship Warranty'),
            'about_title'          => Setting::get('about_title', ''),
            'about_story'          => Setting::get('about_story', ''),
            'about_mission'        => Setting::get('about_mission', ''),
            'about_vision'         => Setting::get('about_vision', ''),
            'about_image'          => Setting::get('about_image', ''),
            'awards_items'         => Setting::json('awards_json'),
            'process_items'        => Setting::json('process_steps_json'),
            'phone'                => Setting::get('phone', '+880 1711 000 000'),
            'email'                => Setting::get('email', 'concierge@rimeinterior.com'),
            'whatsapp'             => Setting::get('whatsapp', '+8801711000000'),
            'address'              => Setting::get('address', ''),
            'studio_hours'         => Setting::get('studio_hours', ''),
            'google_maps_embed'    => Setting::get('google_maps_embed', ''),
            'bdt_rate_standard'    => Setting::get('bdt_rate_standard', '1800'),
            'bdt_rate_premium'     => Setting::get('bdt_rate_premium', '2800'),
            'bdt_rate_luxury'      => Setting::get('bdt_rate_luxury', '4200'),
            'instagram_url'        => Setting::get('instagram_url', ''),
            'facebook_url'         => Setting::get('facebook_url', ''),
            'linkedin_url'         => Setting::get('linkedin_url', ''),
            'pinterest_url'        => Setting::get('pinterest_url', ''),
            'seo_meta_title'       => Setting::get('seo_meta_title', ''),
            'seo_meta_description' => Setting::get('seo_meta_description', ''),
            'ga_measurement_id'    => Setting::get('ga_measurement_id', ''),
            'fb_pixel_id'          => Setting::get('fb_pixel_id', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('Hero & KPIs')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Section::make('Top Announcement & Brand')
                                    ->schema([
                                        Forms\Components\TextInput::make('site_name')->label('Brand Name')->required(),
                                        Forms\Components\TextInput::make('notice_bar_text')->label('Top Notice Bar Text'),
                                    ])
                                    ->columns(2),

                                Section::make('3D Hero Content')
                                    ->schema([
                                        Forms\Components\Toggle::make('hero_enable_3d')
                                            ->label('Enable Interactive Three.js 3D Hero Scene')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('hero_badge')->label('Hero Badge (EN)'),
                                        Forms\Components\TextInput::make('hero_badge_bn')->label('Hero Badge (BN)'),
                                        Forms\Components\TextInput::make('tagline')->label('Main Headline (EN)')->required(),
                                        Forms\Components\TextInput::make('tagline_bn')->label('Main Headline (BN)'),
                                        Forms\Components\Textarea::make('hero_subtitle')->label('Hero Subtitle (EN)')->rows(3),
                                        Forms\Components\Textarea::make('hero_subtitle_bn')->label('Hero Subtitle (BN)')->rows(3),
                                        Forms\Components\FileUpload::make('hero_image_upload')
                                            ->label('Upload Hero Fallback/Backdrop Image')
                                            ->disk('public')
                                            ->directory('settings/hero')
                                            ->image(),
                                        Forms\Components\TextInput::make('hero_image')->label('Hero Fallback Image URL / Path'),
                                    ])
                                    ->columns(2),

                                Section::make('Hero Statistics Counters')
                                    ->schema([
                                        Forms\Components\TextInput::make('stat_1_value')->label('Stat 1 Value'),
                                        Forms\Components\TextInput::make('stat_1_label')->label('Stat 1 Label'),
                                        Forms\Components\TextInput::make('stat_2_value')->label('Stat 2 Value'),
                                        Forms\Components\TextInput::make('stat_2_label')->label('Stat 2 Label'),
                                        Forms\Components\TextInput::make('stat_3_value')->label('Stat 3 Value'),
                                        Forms\Components\TextInput::make('stat_3_label')->label('Stat 3 Label'),
                                        Forms\Components\TextInput::make('stat_4_value')->label('Stat 4 Value'),
                                        Forms\Components\TextInput::make('stat_4_label')->label('Stat 4 Label'),
                                    ])
                                    ->columns(4),
                            ]),

                        Tab::make('About, Awards & Process')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                Section::make('Studio Story & Philosophy')
                                    ->schema([
                                        Forms\Components\TextInput::make('about_title')->label('About Headline')->columnSpanFull(),
                                        Forms\Components\Textarea::make('about_story')->label('Studio Story')->rows(4)->columnSpanFull(),
                                        Forms\Components\Textarea::make('about_mission')->label('Mission Statement')->rows(3),
                                        Forms\Components\Textarea::make('about_vision')->label('Vision Statement')->rows(3),
                                        Forms\Components\FileUpload::make('about_image_upload')
                                            ->label('Upload Studio Image')
                                            ->disk('public')
                                            ->directory('settings/about')
                                            ->image(),
                                        Forms\Components\TextInput::make('about_image')->label('Studio Image URL / Path'),
                                    ])
                                    ->columns(2),

                                Section::make('Design Process Timeline')
                                    ->schema([
                                        Forms\Components\Repeater::make('process_items')
                                            ->label('5-Step Process')
                                            ->schema([
                                                Forms\Components\TextInput::make('step')->required()->maxLength(10),
                                                Forms\Components\TextInput::make('duration')->required(),
                                                Forms\Components\TextInput::make('title')->required(),
                                                Forms\Components\TextInput::make('title_bn')->label('Title (BN)'),
                                                Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->collapsible(),
                                    ]),

                                Section::make('Awards & Recognition')
                                    ->schema([
                                        Forms\Components\Repeater::make('awards_items')
                                            ->label('Awards')
                                            ->schema([
                                                Forms\Components\TextInput::make('year')->required(),
                                                Forms\Components\TextInput::make('title')->required(),
                                                Forms\Components\TextInput::make('org')->label('Organization'),
                                                Forms\Components\TextInput::make('category'),
                                            ])
                                            ->columns(2)
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Contact & BDT Pricing')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Section::make('Studio Contact Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('phone')->tel()->required(),
                                        Forms\Components\TextInput::make('email')->email()->required(),
                                        Forms\Components\TextInput::make('whatsapp')->label('WhatsApp Number (with country code)'),
                                        Forms\Components\TextInput::make('studio_hours')->label('Opening Hours'),
                                        Forms\Components\Textarea::make('address')->rows(2)->columnSpanFull(),
                                        Forms\Components\Textarea::make('google_maps_embed')->label('Google Maps Embed Src URL')->rows(2)->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Section::make('Quote Estimator Base Rates (BDT per sq ft)')
                                    ->schema([
                                        Forms\Components\TextInput::make('bdt_rate_standard')->label('Standard Tier (৳ / sq ft)')->numeric()->prefix('৳')->required(),
                                        Forms\Components\TextInput::make('bdt_rate_premium')->label('Premium Tier (৳ / sq ft)')->numeric()->prefix('৳')->required(),
                                        Forms\Components\TextInput::make('bdt_rate_luxury')->label('Bespoke Luxury Tier (৳ / sq ft)')->numeric()->prefix('৳')->required(),
                                    ])
                                    ->columns(3),
                            ]),

                        Tab::make('Social, SEO & Analytics')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Social Links')
                                    ->schema([
                                        Forms\Components\TextInput::make('instagram_url')->url(),
                                        Forms\Components\TextInput::make('facebook_url')->url(),
                                        Forms\Components\TextInput::make('linkedin_url')->url(),
                                        Forms\Components\TextInput::make('pinterest_url')->url(),
                                    ])
                                    ->columns(2),

                                Section::make('SEO & Tracking Pixels')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_meta_title')->label('Default Meta Title')->columnSpanFull(),
                                        Forms\Components\Textarea::make('seo_meta_description')->label('Default Meta Description')->rows(3)->columnSpanFull(),
                                        Forms\Components\TextInput::make('ga_measurement_id')->label('Google Analytics 4 ID')->placeholder('G-XXXXXXXXXX'),
                                        Forms\Components\TextInput::make('fb_pixel_id')->label('Facebook Pixel ID')->placeholder('123456789012345'),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if (!empty($data['hero_image_upload'])) {
            $data['hero_image'] = $data['hero_image_upload'];
        }
        if (!empty($data['about_image_upload'])) {
            $data['about_image'] = $data['about_image_upload'];
        }

        $groupMap = [
            'site_name' => 'general',
            'notice_bar_text' => 'general',
            'hero_badge' => 'hero',
            'hero_badge_bn' => 'hero',
            'tagline' => 'hero',
            'tagline_bn' => 'hero',
            'hero_subtitle' => 'hero',
            'hero_subtitle_bn' => 'hero',
            'hero_image' => 'hero',
            'stat_1_value' => 'stats',
            'stat_1_label' => 'stats',
            'stat_2_value' => 'stats',
            'stat_2_label' => 'stats',
            'stat_3_value' => 'stats',
            'stat_3_label' => 'stats',
            'stat_4_value' => 'stats',
            'stat_4_label' => 'stats',
            'about_title' => 'about',
            'about_story' => 'about',
            'about_mission' => 'about',
            'about_vision' => 'about',
            'about_image' => 'about',
            'phone' => 'contact',
            'email' => 'contact',
            'whatsapp' => 'contact',
            'address' => 'contact',
            'studio_hours' => 'contact',
            'google_maps_embed' => 'contact',
            'bdt_rate_standard' => 'pricing',
            'bdt_rate_premium' => 'pricing',
            'bdt_rate_luxury' => 'pricing',
            'instagram_url' => 'social',
            'facebook_url' => 'social',
            'linkedin_url' => 'social',
            'pinterest_url' => 'social',
            'seo_meta_title' => 'seo',
            'seo_meta_description' => 'seo',
            'ga_measurement_id' => 'seo',
            'fb_pixel_id' => 'seo',
        ];

        Setting::set('hero_enable_3d', !empty($data['hero_enable_3d']) ? '1' : '0', 'hero');
        Setting::set('awards_json', json_encode(array_values($data['awards_items'] ?? [])), 'about');
        Setting::set('process_steps_json', json_encode(array_values($data['process_items'] ?? [])), 'process');

        foreach ($groupMap as $key => $group) {
            Setting::set($key, isset($data[$key]) ? (string) $data[$key] : '', $group);
        }

        Notification::make()
            ->title('Settings saved and published live!')
            ->success()
            ->send();
    }
}

