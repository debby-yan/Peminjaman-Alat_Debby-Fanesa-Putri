<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peminjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. PESAN NOTIFIKASI --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 2. FORM PENCARIAN --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 md:mb-0">Ajukan Peminjaman</h3>
                    
                    <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama alat..." 
                               class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-full md:w-64">
                        
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('dashboard') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm flex items-center">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- 3. GRID DAFTAR ALAT --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($alats as $alat)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="font-bold text-lg text-gray-800">{{ $alat->nama_alat }}</h4>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                    Stok: {{ $alat->stok }}
                                </span>
                            </div>

                            <form action="{{ route('pinjam.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Maks: {{ $alat->stok }})</label>
                                    <input type="number" name="jumlah" min="1" max="{{ $alat->stok }}" value="1" required class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" required min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kembali</label>
                                    <input type="date" name="tanggal_kembali" required min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>

                                @if ($alat->stok > 0)
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">PINJAM</button>
                                @else
                                    <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded text-sm cursor-not-allowed">HABIS</button>
                                @endif
                            </form>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-3 text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500">Alat tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>