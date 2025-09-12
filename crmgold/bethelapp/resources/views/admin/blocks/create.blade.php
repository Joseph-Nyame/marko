@extends('admin.layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl mb-4">Add Block to {{ $page->title }}</h2>
        <form action="{{ route('blocks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            <div class="mb-4">
                <label class="block mb-1">Block Type</label>
                <select name="type" class="w-full border p-2 rounded" onchange="toggleFields(this)">
                    <option value="hero">Hero</option>
                    <option value="section_title">Section Title</option>
                    <option value="text_image">Text + Image</option>
                    <option value="grid">Grid</option>
                    <option value="contact">Contact</option>
                    <option value="steps">Steps</option>
                    <option value="testimonials">Testimonials</option>
                    <option value="live_prices">Live Prices</option>
                </select>
            </div>

            <!-- Hero Fields -->
            <div id="hero-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Headline</label>
                    <input type="text" name="content[headline]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Subtext</label>
                    <textarea name="content[subtext]" class="w-full border p-2 rounded" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA Text</label>
                    <input type="text" name="content[cta_text]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA URL</label>
                    <input type="text" name="content[cta_url]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Background Image</label>
                    <input type="file" name="content[background_image]" class="w-full border p-2 rounded" accept="image/*">
                </div>
            </div>

            <!-- Section Title Fields -->
            <div id="section_title-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Title</label>
                    <input type="text" name="content[title]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Subtitle</label>
                    <input type="text" name="content[subtitle]" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <!-- Text Image Fields -->
            <div id="text_image-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Headline</label>
                    <input type="text" name="content[headline]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Text Paragraphs</label>
                    <div id="text-paragraphs">
                        <div class="paragraph-group mb-2">
                            <textarea name="content[text][]" class="w-full border p-2 rounded" required></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="addParagraph()" class="bg-green-500 text-white px-2 py-1 rounded">Add Paragraph</button>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image</label>
                    <input type="file" name="content[image]" class="w-full border p-2 rounded" accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA Text</label>
                    <input type="text" name="content[cta_text]" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">CTA URL</label>
                    <input type="text" name="content[cta_url]" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image Position</label>
                    <select name="content[image_position]" class="w-full border p-2 rounded">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </div>
            </div>

            <!-- Grid Fields -->
            <div id="grid-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Grid Items</label>
                    <div id="grid-items">
                        <div class="grid-item-group mb-4 border p-4 rounded">
                            <label class="block mb-1">Icon (e.g., fas fa-icon)</label>
                            <input type="text" name="content[items][0][icon]" class="w-full border p-2 rounded mb-2" placeholder="Icon class">
                            <label class="block mb-1">Image</label>
                            <input type="file" name="content[items][0][image]" class="w-full border p-2 rounded mb-2" accept="image/*">
                            <label class="block mb-1">Title</label>
                            <input type="text" name="content[items][0][title]" class="w-full border p-2 rounded mb-2" required>
                            <label class="block mb-1">Description</label>
                            <textarea name="content[items][0][description]" class="w-full border p-2 rounded" required></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="addGridItem()" class="bg-green-500 text-white px-2 py-1 rounded">Add Item</button>
                </div>
            </div>

            <!-- Contact Fields -->
            <div id="contact-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Contact Info Items</label>
                    <div id="contact-info">
                        <div class="info-group mb-4 border p-4 rounded">
                            <label class="block mb-1">Icon (e.g., fas fa-map-marker-alt)</label>
                            <input type="text" name="content[info][0][icon]" class="w-full border p-2 rounded mb-2" required>
                            <label class="block mb-1">Detail</label>
                            <input type="text" name="content[info][0][detail]" class="w-full border p-2 rounded" required>
                        </div>
                    </div>
                    <button type="button" onclick="addInfoItem()" class="bg-green-500 text-white px-2 py-1 rounded">Add Info Item</button>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Form Fields (comma-separated, e.g., name,email,subject,message)</label>
                    <input type="text" name="content[form][fields]" class="w-full border p-2 rounded" required value="name,email,subject,message">
                </div>
            </div>

            <!-- Steps Fields -->
            <div id="steps-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Steps</label>
                    <div id="steps-items">
                        <div class="step-group mb-4 border p-4 rounded">
                            <label class="block mb-1">Title</label>
                            <input type="text" name="content[steps][0][title]" class="w-full border p-2 rounded mb-2" required>
                            <label class="block mb-1">Description</label>
                            <textarea name="content[steps][0][description]" class="w-full border p-2 rounded" required></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="addStep()" class="bg-green-500 text-white px-2 py-1 rounded">Add Step</button>
                </div>
            </div>

            <!-- Testimonials Fields -->
            <div id="testimonials-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Testimonials</label>
                    <div id="testimonial-items">
                        <div class="testimonial-group mb-4 border p-4 rounded">
                            <label class="block mb-1">Quote</label>
                            <textarea name="content[items][0][quote]" class="w-full border p-2 rounded mb-2" required></textarea>
                            <label class="block mb-1">Client</label>
                            <input type="text" name="content[items][0][client]" class="w-full border p-2 rounded" required>
                        </div>
                    </div>
                    <button type="button" onclick="addTestimonial()" class="bg-green-500 text-white px-2 py-1 rounded">Add Testimonial</button>
                </div>
            </div>

            <!-- Live Prices Fields -->
            <div id="live_prices-fields" style="display: none;">
                <div class="mb-4">
                    <label class="block mb-1">Gold Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][gold]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Silver Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][silver]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Platinum Price (USD per ounce)</label>
                    <input type="number" step="0.01" name="content[prices][platinum]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Enable Calculator</label>
                    <input type="checkbox" name="content[calculator]" value="true">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
    <script>
        function toggleFields(select) {
            document.querySelectorAll('[id$="-fields"]').forEach(div => div.style.display = 'none');
            document.getElementById(`${select.value}-fields`).style.display = 'block';
        }

        let paragraphCount = 1;
        function addParagraph() {
            const div = document.createElement('div');
            div.className = 'paragraph-group mb-2';
            div.innerHTML = `<textarea name="content[text][${paragraphCount}]" class="w-full border p-2 rounded" required></textarea>`;
            document.getElementById('text-paragraphs').appendChild(div);
            paragraphCount++;
        }

        let gridCount = 1;
        function addGridItem() {
            const div = document.createElement('div');
            div.className = 'grid-item-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Icon (e.g., fas fa-icon)</label>
                <input type="text" name="content[items][${gridCount}][icon]" class="w-full border p-2 rounded mb-2" placeholder="Icon class">
                <label class="block mb-1">Image</label>
                <input type="file" name="content[items][${gridCount}][image]" class="w-full border p-2 rounded mb-2" accept="image/*">
                <label class="block mb-1">Title</label>
                <input type="text" name="content[items][${gridCount}][title]" class="w-full border p-2 rounded mb-2" required>
                <label class="block mb-1">Description</label>
                <textarea name="content[items][${gridCount}][description]" class="w-full border p-2 rounded" required></textarea>
            `;
            document.getElementById('grid-items').appendChild(div);
            gridCount++;
        }

        let infoCount = 1;
        function addInfoItem() {
            const div = document.createElement('div');
            div.className = 'info-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Icon</label>
                <input type="text" name="content[info][${infoCount}][icon]" class="w-full border p-2 rounded mb-2" required>
                <label class="block mb-1">Detail</label>
                <input type="text" name="content[info][${infoCount}][detail]" class="w-full border p-2 rounded" required>
            `;
            document.getElementById('contact-info').appendChild(div);
            infoCount++;
        }

        let stepCount = 1;
        function addStep() {
            const div = document.createElement('div');
            div.className = 'step-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Title</label>
                <input type="text" name="content[steps][${stepCount}][title]" class="w-full border p-2 rounded mb-2" required>
                <label class="block mb-1">Description</label>
                <textarea name="content[steps][${stepCount}][description]" class="w-full border p-2 rounded" required></textarea>
            `;
            document.getElementById('steps-items').appendChild(div);
            stepCount++;
        }

        let testimonialCount = 1;
        function addTestimonial() {
            const div = document.createElement('div');
            div.className = 'testimonial-group mb-4 border p-4 rounded';
            div.innerHTML = `
                <label class="block mb-1">Quote</label>
                <textarea name="content[items][${testimonialCount}][quote]" class="w-full border p-2 rounded mb-2" required></textarea>
                <label class="block mb-1">Client</label>
                <input type="text" name="content[items][${testimonialCount}][client]" class="w-full border p-2 rounded" required>
            `;
            document.getElementById('testimonial-items').appendChild(div);
            testimonialCount++;
        }
    </script>
@endsection
