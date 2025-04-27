<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Book -
        {{ $book->title }}
    </title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')


    {{-- Flowbite js --}}
    @vite('resources/js/text-editor.js')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- tom select css --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />
    <style>
        .ts-control {
            border: 1px solid #e0e0e0 !important;
            padding: 0.625rem 1.5rem !important;
            border-radius: 0.375rem !important;
        }
    </style>


    {{-- CKEditor --}}
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>

    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/45.0.0/ckeditor5-premium-features.umd.js"></script>
    <style>
        .main-container {
            /* width: 795px; */
            margin-left: auto;
            margin-right: auto;
            border-radius: 1.5% !important;
        }
    </style>
</head>

<body class="">
    <div class="flex text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="mx-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <h2 class="text-2xl font-bold uppercase"> Edit Book <span class="underline">{{ $book->title }}</span> </h2>
            <div class="flex justify-items-start p-8">
                <div class="w-full max-w-[550px]">
                    <form action="/book/update" method="post">
                        @csrf
                        {{-- Get Author id (if from book-by-author) --}}
                        @if ($author_id != null)
                            <input type="hidden" name="author_id" value="{{ $author_id }}">
                        @endif
                        {{-- Get Category_id  (if from book-by-category)  --}}
                        @if ($category_id != null)
                            <input type="hidden" name="category_id" value="{{ $category_id }}">
                        @endif

                        <input type="hidden" name="page" value="{{ $page }}">
                        <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                        <div class="mb-5">
                            <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                Book Title
                            </label>
                            <input type="text" name="name" id="name" placeholder="{{ $book->title }}"
                                value="{{ $book->title }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div class="mb-5">
                            <label for="category" class="mb-3 block text-base font-medium text-[#07074D]">
                                Category
                            </label>
                            <select name="category" id="select-category"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ $category->category_id === $book->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-5">
                            <label for="select-author" class="block mb-2 text-sm font-medium text-gray-700">Select
                                Author(s)</label>
                            <select id="select-author" name="authors[]" multiple
                                class="w-full text-sm text-[#6B7280] focus:shadow-md focus:border-[#6A64F1] rounded-md">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->author_id }}"
                                        {{ in_array($author->name, $book->authors) ? 'selected' : '' }}>
                                        {{ $author->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        {{-- Content CKEditor --}}
                        {{-- <div class="main-container mb-5">
                            <textarea id="editor" name="content"
                                class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{!! $book->content !!}</textarea>
                        </div> --}}


                        {{-- flowbite text-editor --}}
                        @include('book.content-editor')

                        {{-- Hidden input to store the HTML content --}}
                        <input type="hidden" name="content" id="editor"
                            value="{{ old('content', $book->content) }}">

                        {{-- Optional error display --}}
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div class="my-5"></div>

                        {{-- Button Finish --}}
                        <div class="flex justify-between">
                            <button data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                class="hover:shadow-form rounded-md bg-[#FA003F] py-3 px-8 text-base font-semibold text-white outline-none"
                                type="button">
                                Delete
                            </button>

                            {{-- Save/Update Button --}}
                            <button type="submit" name="submit"
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none"
                                value="save">
                                Save
                            </button>


                            {{-- Delete Confirmation using Modal (Div after Save code, so if enter will be saved --}}
                            <div id="delete-modal" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-gray-200 rounded-lg shadow-sm">
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                            data-modal-hide="delete-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500">Are
                                                you sure you want to delete this product?</h3>
                                            <button type="submit" name="submit"
                                                class="hover:shadow-form rounded-md bg-[#FA003F] py-2.5 px-5 ms-3 text-sm font-semibold text-white outline-none"
                                                value="delete">
                                                Yes, Delete
                                            </button>
                                            <button data-modal-hide="delete-modal" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No,
                                                cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- flowbite js --}}
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.turbo.js"></script> <!-- if needed -->


    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#select-author', {
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Add Author...',
            create: false,
        });
    </script>



    {{-- Flowbite Text Editor --}}
    <script src="{{ asset('js/text-editor.js') }}"></script>
    <script type="importmap">
    {
        "imports": {
            "https://esm.sh/v135/prosemirror-model@1.22.3/es2022/prosemirror-model.mjs": "https://esm.sh/v135/prosemirror-model@1.19.3/es2022/prosemirror-model.mjs", 
            "https://esm.sh/v135/prosemirror-model@1.22.1/es2022/prosemirror-model.mjs": "https://esm.sh/v135/prosemirror-model@1.19.3/es2022/prosemirror-model.mjs"
        }
    }
</script>

</body>

</html>
