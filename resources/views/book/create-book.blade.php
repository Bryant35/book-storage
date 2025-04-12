<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Book
    </title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

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
            <h2 class="text-2xl font-bold uppercase"> New Book </h2>
            <div class="flex justify-items-start p-8">
                <div class="w-full max-w-[550px]">
                    <form action="/book/save" method="post">
                        @csrf
                        <div class="mb-5">
                            <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                Book Title
                            </label>
                            <input type="text" name="name" id="name" placeholder="Enter Title of Book"
                                value=""
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div class="mb-5">
                            <label for="category" class="mb-3 block text-base font-medium text-[#07074D]">
                                Category
                            </label>
                            <select name="category" id="select-category" name="category"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">
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
                                    <option value="{{ $author->author_id }}">
                                        {{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Content CKEditor --}}
                        <div class="main-container mb-5">
                            <textarea id="editor" name="content"
                                class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                        </div>

                        {{-- Button Finish --}}
                        <div class="flex justify-between">
                            <div class=""></div>
                            {{-- Save/Add Button --}}
                            <button type="submit" name="submit"
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none"
                                value="save">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- flowbite js --}}
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#select-author', {
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Add Author...',
            create: false,
        });
    </script>


    {{-- CKEditor --}}
    <script>
        const {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph
        } = CKEDITOR;
        const {
            FormatPainter
        } = CKEDITOR_PREMIUM_FEATURES;

        ClassicEditor
            .create(document.querySelector('#editor'), {
                licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDU0NTI3OTksImp0aSI6ImIwNDBlZmQxLWJjZTYtNDZlZS05MTU3LTY0NmU2YzY1NjBjNyIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImNhOWFiNTI0In0.B3HpOk_VB0jO4lHSA2srlL9o1cTFzE35YytT9OB9dLm2GAJvYkpUUDF1h7h2fiLytR4nwK2YB9SIBRLUOFyUkw',
                plugins: [Essentials, Bold, Italic, Font, Paragraph, FormatPainter],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'formatPainter'
                ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(console.error);
    </script>

</body>

</html>
