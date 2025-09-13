@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Edit Block for {{ $block->page->title }}</h2>
        <form action="{{ route('blocks.update', $block) }}" method="POST" enctype="multipart/form-data" id="block-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="page_id" value="{{ $block->page_id }}">
            <div class="mb-4">
                <label class="block mb-1">Block Type</label>
                <select name="type" class="w-full border p-2 rounded" onchange="toggleFields(this)">
                    <option value="hero" {{ $block->type === 'hero' ? 'selected' : '' }}>Hero</option>
                    <option value="section_title" {{ $block->type === 'section_title' ? 'selected' : '' }}>Section Title</option>
                    <option value="text_image" {{ $block->type === 'text_image' ? 'selected' : '' }}>Text + Image</option>
                    <option value="grid" {{ $block->type === 'grid' ? 'selected' : '' }}>Grid</option>
                    <option value="contact" {{ $block->type === 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="steps" {{ $block->type === 'steps' ? 'selected' : '' }}>Steps</option>
                    <option value="testimonials" {{ $block->type === 'testimonials' ? 'selected' : '' }}>Testimonials</option>
                    <option value="live_prices" {{ $block->type === 'live_prices' ? 'selected' : '' }}>Live Prices</option>
                </select>
            </div>

            <!-- Hero Fields -->
            <div id="hero-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Headline</label>
                    <input type="text" name="content[headline]" value="{{ $block->content['headline'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Subtext</label>
                    <textarea name="content[subtext]" class="w-full border p-2 rounded">{{ $block->content['subtext'] ?? '' }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA Text</label>
                    <input type="text" name="content[cta_text]" value="{{ $block->content['cta_text'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA URL</label>
                    <input type="text" name="content[cta_url]" value="{{ $block->content['cta_url'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Background Image</label>
                    @if (isset($block->content['background_image']))
                        <img src="{{ $block->content['background_image'] }}" alt="Current Background" width="100" class="mb-2">
                    @endif
                    <input type="file" name="content[background_image]" class="w-full border p-2 rounded" accept="image/*">
                </div>
            </div>

            <!-- Section Title Fields -->
            <div id="section_title-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Title</label>
                    <input type="text" name="content[title]" value="{{ $block->content['title'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Subtitle</label>
                    <input type="text" name="content[subtitle]" value="{{ $block->content['subtitle'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
            </div>

            <!-- Text Image Fields -->
            <div id="text_image-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Headline</label>
                    <input type="text" name="content[headline]" value="{{ $block->content['headline'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Text Paragraphs</label>
                    <div id="text-paragraphs">
                        @foreach ($block->content['text'] ?? [] as $index => $paragraph)
                            <div class="paragraph-group mb-2">
                                <textarea name="content[text][{{ $index }}]" class="w-full border p-2 rounded">{{ $paragraph }}</textarea>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addParagraph()" class="bg-green-500 text-white px-2 py-1 rounded">Add Paragraph</button>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image</label>
                    @if (isset($block->content['image']))
                        <img src="{{ $block->content['image'] }}" alt="Current Image" width="100" class="mb-2">
                    @endif
                    <input type="file" name="content[image]" class="w-full border p-2 rounded" accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA Text</label>
                    <input type="text" name="content[cta_text]" value="{{ $block->content['cta_text'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA URL</label>
                    <input type="text" name="content[cta_url]" value="{{ $block->content['cta_url'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image Position</label>
                    <select name="content[image_position]" class="w-full border p-2 rounded">
                        <option value="left" {{ ($block->content['image_position'] ?? '') === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="right" {{ ($block->content['image_position'] ?? '') === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </div>
            </div>

            <!-- Grid Fields -->
            <div id="grid-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Grid Items</label>
                    <div id="grid-items">
                        @foreach ($block->content['items'] ?? [] as $index => $item)
                            <div class="grid-item-group mb-4 border p-4 rounded">
                                <label class="block mb-1">Icon (e.g., fas fa-icon)</label>
                                <input type="text" name="content[items][{{ $index }}][icon]" value="{{ $item['icon'] ?? '' }}" class="w-full border p-2 rounded mb-2" placeholder="Icon class">
                                <label class="block mb-1">Image</label>
                                @if (isset($item['image']))
                                    <img src="{{ $item['image'] }}" alt="Current Item Image" width="100" class="mb-2">
                                @endif
                                <input type="file" name="content[items][{{ $index }}][image]" class="w-full border p-2 rounded mb-2" accept="image/*">
                                <label class="block mb-1">Title</label>
                                <input type="text" name="content[items][{{ $index }}][title]" value="{{ $item['title'] ?? '' }}" class="w-full border p-2 rounded mb-2">
                                <label class="block mb-1">Description</label>
                                <textarea name="content[items][{{ $index }}][description]" class="w-full border p-2 rounded">{{ $item['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addGridItem()" class="bg-green-500 text-white px-2 py-1 rounded">Add Item</button>
                </div>
            </div>

            <!-- Contact Fields -->
            <div id="contact-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Contact Info Items</label>
                    <div id="contact-info">
                        @foreach ($block->content['info'] ?? [] as $index => $info)
                            <div class="info-group mb-4 border p-4 rounded">
                                <label class="block mb-1">Icon (e.g., fas fa-map-marker-alt)</label>
                                <input type="text" name="content[info][{{ $index }}][icon]" value="{{ $info['icon'] ?? '' }}" class="w-full border p-2 rounded mb-2">
                                <label class="block mb-1">Detail</label>
                                <input type="text" name="content[info][{{ $index }}][detail]" value="{{ $info['detail'] ?? '' }}" class="w-full border p-2 rounded">
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addInfoItem()" class="bg-green-500 text-white px-2 py-1 rounded">Add Info Item</button>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Form Fields (comma-separated, e.g., name,email,subject,message)</label>
                    <input type="text" name="content[form][fields]" value="{{ implode(',', $block->content['form']['fields'] ?? []) }}" class="w-full border p-2 rounded">
                </div>
            </div>

            <!-- Steps Fields -->
            <div id="steps-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Steps</label>
                    <div id="steps-items">
                        @foreach ($block->content['steps'] ?? [] as $index => $step)
                            <div class="step-group mb-4 border p-4 rounded">
                                <label class="block mb-1">Title</label>
                                <input type="text" name="content[steps][{{ $index }}][title]" value="{{ $step['title'] ?? '' }}" class="w-full border p-2 rounded mb-2">
                                <label class="block mb-1">Description</label>
                                <textarea name="content[steps][{{ $index }}][description]" class="w-full border p-2 rounded">{{ $step['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addStep()" class="bg-green-500 text-white px-2 py-1 rounded">Add Step</button>
                </div>
            </div>

            <!-- Testimonials Fields -->
            <div id="testimonials-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Testimonials</label>
                    <div id="testimonial-items">
                        @foreach ($block->content['items'] ?? [] as $index => $testimonial)
                            <div class="testimonial-group mb-4 border p-4 rounded">
                                <label class="block mb-1">Quote</label>
                                <textarea name="content[items][{{ $index }}][quote]" class="w-full border p-2 rounded mb-2">{{ $testimonial['quote'] ?? '' }}</textarea>
                                <label class="block mb-1">Client</label>
                                <input type="text" name="content[items][{{ $index }}][client]" value="{{ $testimonial['client'] ?? '' }}" class="w-full border p-2 rounded">
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addTestimonial()" class="bg-green-500 text-white px-2 py-1 rounded">Add Testimonial</button>
                </div>
            </div>

            <!-- Live Prices Fields -->
            <div id="live_prices-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Gold Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][gold]" value="{{ $block->content['prices']['gold'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Silver Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][silver]" value="{{ $block->content['prices']['silver'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Platinum Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][platinum]" value="{{ $block->content['prices']['platinum'] ?? '' }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Enable Calculator</label>
                    <input type="checkbox" name="content[calculator]" value="true" {{ isset($block->content['calculator']) ? 'checked' : '' }}>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="draft" {{ $block->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $block->status === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
    <script>
        function toggleFields(select) {
            document.querySelectorAll('[id$="-fields"]').forEach(div => div.style.display = 'none');
            document.getElementById(`${select.value}-fields`).style.display = 'block';
        }

        // Initialize the form with the correct fields visible
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields(document.querySelector('select[name="type"]'));
        });

        let paragraphCount = {{ count($block->content['text'] ?? []) }};
        function addParagraph() {
            const div = document.createElement('div');
            div.className = 'paragraph-group mb-2';
            div.innerHTML = `<textarea name="content[text][${paragraphCount}]" class="w-full border p-2 rounded"></textarea>`;
            document.getElementById('text-paragraphs').appendChild(div);
            paragraphCount++;
        }

        let gridCount = {{ count($block->content['items'] ?? []) }};
        function addGridItem() {
            const div = document.createElement('div');
            div.className = 'grid-item-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Icon (e.g., fas fa-icon)</label>
                <input type="text" name="content[items][${gridCount}][icon]" class="w-full border p-2 rounded mb-2" placeholder="Icon class">
                <label class="block mb-1">Image</label>
                <input type="file" name="content[items][${gridCount}][image]" class="w-full border p-2 rounded mb-2" accept="image/*">
                <label class="block mb-1">Title</label>
                <input type="text" name="content[items][${gridCount}][title]" class="w-full border p-2 rounded mb-2">
                <label class="block mb-1">Description</label>
                <textarea name="content[items][${gridCount}][description]" class="w-full border p-2 rounded"></textarea>
            `;
            document.getElementById('grid-items').appendChild(div);
            gridCount++;
        }

        let infoCount = {{ count($block->content['info'] ?? []) }};
        function addInfoItem() {
            const div = document.createElement('div');
            div.className = 'info-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Icon</label>
                <input type="text" name="content[info][${infoCount}][icon]" class="w-full border p-2 rounded mb-2">
                <label class="block mb-1">Detail</label>
                <input type="text" name="content[info][${infoCount}][detail]" class="w-full border p-2 rounded">
            `;
            document.getElementById('contact-info').appendChild(div);
            infoCount++;
        }

        let stepCount = {{ count($block->content['steps'] ?? []) }};
        function addStep() {
            const div = document.createElement('div');
            div.className = 'step-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Title</label>
                <input type="text" name="content[steps][${stepCount}][title]" class="w-full border p-2 rounded mb-2">
                <label class="block mb-1">Description</label>
                <textarea name="content[steps][${stepCount}][description]" class="w-full border p-2 rounded"></textarea>
            `;
            document.getElementById('steps-items').appendChild(div);
            stepCount++;
        }

        let testimonialCount = {{ count($block->content['items'] ?? []) }};
        function addTestimonial() {
            const div = document.createElement('div');
            div.className = 'testimonial-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Quote</label>
                <textarea name="content[items][${testimonialCount}][quote]" class="w-full border p-2 rounded mb-2"></textarea>
                <label class="block mb-1">Client</label>
                <input type="text" name="content[items][${testimonialCount}][client]" class="w-full border p-2 rounded">
            `;
            document.getElementById('testimonial-items').appendChild(div);
            testimonialCount++;
        }
    </script>
@endsection
