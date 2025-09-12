@extends('layouts.app')

@section('content')
    @foreach ($blocks as $block)
        @if ($block->type === 'hero')
            <section id="{{ $page->slug }}" class="hero" style="background: linear-gradient(rgba(26, 26, 46, 0.7), rgba(26, 26, 46, 0.7)), url('{{ $block->content['background_image'] ?? '/img/hero-bg.jpeg' }}') no-repeat center center/cover;">
                <div class="container hero-content">
                    <h2>{{ $block->content['headline'] }}</h2>
                    <p>{{ $block->content['subtext'] }}</p>
                    <a href="{{ $block->content['cta_url'] }}" class="btn">{{ $block->content['cta_text'] }}</a>
                </div>
            </section>

        @elseif ($block->type === 'section_title')
            <div class="section-title">
                <h2>{{ $block->content['title'] }}</h2>
                <p>{{ $block->content['subtitle'] }}</p>
            </div>

        @elseif ($block->type === 'text_image')
            <section class="{{ $block->type }}">
                <div class="container about-content" style="flex-direction: {{ $block->content['image_position'] === 'right' ? 'row' : 'row-reverse' }};">
                    <div class="about-text">
                        <h3>{{ $block->content['headline'] }}</h3>
                        @foreach ($block->content['text'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                        @if (isset($block->content['cta_text']) && isset($block->content['cta_url']))
                            <a href="{{ $block->content['cta_url'] }}" class="btn">{{ $block->content['cta_text'] }}</a>
                        @endif
                    </div>
                    <div class="about-image">
                        <img src="{{ $block->content['image'] }}" alt="{{ $block->content['headline'] }}">
                    </div>
                </div>
            </section>

        @elseif ($block->type === 'grid')
            <section class="{{ $block->type }}">
                <div class="container services-grid">
                    @foreach ($block->content['items'] as $item)
                        <div class="service-card">
                            @if (isset($item['icon']))
                                <div class="service-icon">
                                    <i class="{{ $item['icon'] }}"></i>
                                </div>
                            @elseif (isset($item['image']))
                                <div class="equipment-img">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                </div>
                            @endif
                            <div class="{{ isset($item['image']) ? 'equipment-info' : '' }}">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        @elseif ($block->type === 'contact')
            <section class="{{ $block->type }}">
                <div class="container contact-container">
                    <div class="contact-info">
                        <h3>Contact Information</h3>
                        @foreach ($block->content['info'] as $info)
                            <div class="contact-detail">
                                <div class="contact-icon">
                                    <i class="{{ $info['icon'] }}"></i>
                                </div>
                                <p>{{ $info['detail'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="contact-form">
                        @if (session('success'))
                            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            @foreach ($block->content['form']['fields'] as $field)
                                <div class="form-group">
                                    @if ($field === 'message')
                                        <textarea name="{{ $field }}" placeholder="Your {{ ucfirst($field) }}" class="w-full border p-2 rounded" required></textarea>
                                    @else
                                        <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" placeholder="Your {{ ucfirst($field) }}" class="w-full border p-2 rounded" required>
                                    @endif
                                </div>
                            @endforeach
                            <button type="submit" class="btn">Send Message</button>
                        </form>
                    </div>
                </div>
            </section>

        @elseif ($block->type === 'steps')
            <section class="{{ $block->type }}">
                <div class="container">
                    <div class="steps-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                        @foreach ($block->content['steps'] as $step)
                            <div class="step-card" style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid {{ $settings['primary_color'] ?? '#C9A635' }}; text-align: center;">
                                <h3>{{ $step['title'] }}</h3>
                                <p>{{ $step['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        @elseif ($block->type === 'testimonials')
            <section class="{{ $block->type }}">
                <div class="container testimonial-container">
                    @foreach ($block->content['items'] as $testimonial)
                        <div class="testimonial">
                            <p>{{ $testimonial['quote'] }}</p>
                            <div class="client">{{ $testimonial['client'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

        @elseif ($block->type === 'live_prices')
            <section class="{{ $block->type }}">
                <div class="container">
                    <div id="live-prices">
                        <h3>Current Prices (per ounce in USD)</h3>
                        <ul>
                            @if (isset($block->content['prices']['gold']))
                                <li>Gold: ${{ number_format($block->content['prices']['gold'], 2) }}</li>
                            @endif
                            @if (isset($block->content['prices']['silver']))
                                <li>Silver: ${{ number_format($block->content['prices']['silver'], 2) }}</li>
                            @endif
                            @if (isset($block->content['prices']['platinum']))
                                <li>Platinum: ${{ number_format($block->content['prices']['platinum'], 2) }}</li>
                            @endif
                        </ul>
                        @if ($block->content['calculator'])
                            <div class="price-calculator">
                                <h3>Calculate Your Gold's Value</h3>
                                <form id="calculator-form">
                                    <div class="form-group">
                                        <label>Weight (grams)</label>
                                        <input type="number" id="weight" step="0.01" placeholder="Enter weight" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Purity</label>
                                        <select id="purity" required>
                                            <option value="24">24K (99.9%)</option>
                                            <option value="22">22K (91.67%)</option>
                                            <option value="18">18K (75%)</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="calculateValue()" class="btn">Calculate</button>
                                    <p>Result: <span id="calculator-result">N/A</span></p>
                                </form>
                                <script>
                                    function calculateValue() {
                                        const weight = parseFloat(document.getElementById('weight').value);
                                        const purity = parseFloat(document.getElementById('purity').value) / 24;
                                        const goldPricePerOunce = {{ $block->content['prices']['gold'] ?? 0 }};
                                        const goldPricePerGram = goldPricePerOunce / 31.1035; // Troy ounce to gram
                                        const value = weight * purity * goldPricePerGram;
                                        document.getElementById('calculator-result').textContent = `$${value.toFixed(2)}`;
                                    }
                                </script>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

        @endif
    @endforeach
@endsection
