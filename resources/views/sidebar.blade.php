<aside class="flex sticky top-0 left-0 h-screen w-20 flex-col items-center border-r border-gray-200 bg-white">
    <div class="flex h-[4.5rem] w-full items-center justify-center border-b border-gray-200 p-2">
        <img src="{{ asset('imgs/books.png') }}" />
    </div>
    <nav class="flex flex-1 flex-col gap-y-2 pt-5 m-2  min-w-10">
        <a href="/book/view"
            class="group relative rounded-xl {{ request()->is('book*') ? 'bg-gray-100' : '' }} p-2 text-blue-600 hover:text-gray-900 hover:bg-gray-100">
            <img src="{{ asset('imgs/book_list.png') }}" alt="" class="p-1" />
            <div class="absolute inset-y-0 left-12 hidden items-center group-hover:flex">
                <div
                    class="relative whitespace-nowrap rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 drop-shadow-lg">
                    Book List <span class="text-gray-400"></span>
                </div>
            </div>
        </a>
        <a href="/author/view"
            class="text-gray-400 group relative rounded-xl p-2 hover:text-gray-900 hover:bg-gray-100 {{ request()->is('author*') ? 'bg-gray-100' : '' }}">
            <img src="{{ asset('imgs/author.png') }}" alt="" class="p-1" />
            <div class="absolute inset-y-0 left-12 hidden items-center group-hover:flex">
                <div
                    class="relative whitespace-nowrap rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 drop-shadow-lg">
                    Authors <span class="text-gray-400"></span>
                </div>
            </div>
        </a>
        <a href="/category/view" class="text-gray-400 group relative rounded-xl p-2 hover:text-gray-900 hover:bg-gray-100 {{ request()->is('category*') ? 'bg-gray-100' : '' }}">
            <img src="{{ asset('imgs/category.png') }}" alt="" class="p-1" />

            <div class="absolute inset-y-0 left-12 hidden items-center group-hover:flex">
                <div
                    class="relative whitespace-nowrap rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 drop-shadow-lg">
                    Categories <span class="text-gray-400"></span>
                </div>
            </div>
        </a>
    </nav>

    <div class="flex flex-col items-center gap-y-4 py-10 m-auto">
        <button class="group relative rounded-xl p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100">
            <svg width="24" height="24" class="h-6 w-6 stroke-current" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M12 16H12.01M12 8V12V8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <button class="group relative rounded-xl p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100">
            <i class="bi bi-person-circle"></i>
        </button>
        <a href="/validate/logout"
            class="group relative rounded-xl p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100">
            <i
                class="bi bi-door-closed-fill absolute transition-all duration-300 ease-in-out opacity-100 group-hover:opacity-0 group-hover:-rotate-12"></i>
            <i
                class="bi bi-door-open-fill transition-all duration-300 ease-in-out opacity-0 group-hover:opacity-100 group-hover:rotate-0"></i>
            <div class="absolute inset-y-0 left-12 hidden items-center group-hover:flex">
                <div
                    class="relative whitespace-nowrap rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 drop-shadow-lg">
                    <div class="absolute inset-0 -left-1 flex items-center">
                        <div class="h-2 w-2 rotate-45 bg-white"></div>
                    </div>
                    Log Out <span class="text-gray-400"></span>
                </div>
            </div>
        </a>
    </div>
</aside>
