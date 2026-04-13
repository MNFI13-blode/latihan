@if ($paginator->hasPages())
    <!-- Container pagination -->
    <div class="flex items-center gap-2">

        {{-- ================= PREVIOUS BUTTON ================= --}}
        @if ($paginator->onFirstPage())
            <!-- Kalau di halaman pertama → disable -->
            <span class="px-3 py-1 bg-gray-200 text-gray-400 rounded-lg">‹</span>
        @else
            <!-- Kalau bukan halaman pertama → bisa diklik -->
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1 bg-white border rounded-lg hover:bg-blue-50">‹</a>
        @endif


        {{-- ================= PAGE NUMBERS ================= --}}
        @foreach ($elements as $element)

            {{-- Kalau "..." (ellipsis) --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            {{-- Kalau array halaman --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    {{-- Halaman aktif --}}
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-blue-500 text-white rounded-lg shadow">
                            {{ $page }}
                        </span>

                    {{-- Halaman biasa --}}
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1 bg-white border rounded-lg hover:bg-blue-50">
                            {{ $page }}
                        </a>
                    @endif

                @endforeach
            @endif

        @endforeach


        {{-- ================= NEXT BUTTON ================= --}}
        @if ($paginator->hasMorePages())
            <!-- Kalau masih ada halaman berikutnya -->
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1 bg-white border rounded-lg hover:bg-blue-50">›</a>
        @else
            <!-- Kalau sudah halaman terakhir -->
            <span class="px-3 py-1 bg-gray-200 text-gray-400 rounded-lg">›</span>
        @endif

    </div>
@endif