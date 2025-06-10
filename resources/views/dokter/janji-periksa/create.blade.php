<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Periksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-4xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <form action="{{ route('dokter.periksa.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_janji_periksa" value="{{ $janji->id }}">

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Periksa</label>
                        <input type="date" name="tgl_periksa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Catatan Pemeriksaan</label>
                        <textarea name="catatan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Biaya Periksa (Rp)</label>
                        <input type="number" name="biaya_periksa" id="biaya_periksa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Resep Obat</label>
                        <div class="mt-2 space-y-2">
                            @foreach($obats as $obat)
                                <label class="flex items-center">
                                    <input type="checkbox" name="obat_ids[]" value="{{ $obat->id }}" class="mr-2">
                                    {{ $obat->nama_obat }} ({{ $obat->kemasan }})
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
