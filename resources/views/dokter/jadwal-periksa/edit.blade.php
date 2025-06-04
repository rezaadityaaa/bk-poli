{{-- filepath: /Users/rezaaditya/Herd/bk-poli/resources/views/dokter/jadwal-periksa/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('dokter.jadwal-periksa.update', $jadwalPeriksa->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                        <select name="hari" id="hari" class="mt-1 block w-full rounded border-gray-300" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari', $jadwalPeriksa->hari) == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                        @error('hari')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="mt-1 block w-full rounded border-gray-300" required value="{{ old('jam_mulai', $jadwalPeriksa->jam_mulai) }}">
                        @error('jam_mulai')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="mt-1 block w-full rounded border-gray-300" required value="{{ old('jam_selesai', $jadwalPeriksa->jam_selesai) }}">
                        @error('jam_selesai')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded border-gray-300" required>
                            <option value="aktif" {{ old('status', $jadwalPeriksa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $jadwalPeriksa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <div class="flex justify-end">
                        <a href="{{ route('dokter.jadwal-periksa.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>