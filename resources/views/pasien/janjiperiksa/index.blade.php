<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Janji Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Buat Janji Periksa') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                            </p>
                        </header>

                        <form class="mt-6" action="{{ route('pasien.janjiperiksa.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="formGroupExampleInput">Nomor Rekam Medis</label>
                                <input type="text" class="rounded form-control" id="formGroupExampleInput"
                                    placeholder="Example input" value="{{ $no_rm }}" name="no_rm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="dokterSelect">Dokter</label>
                                <select class="form-control" id="dokterSelect" name="id_jadwal_periksa" required>
                                    <option>Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        @foreach ($dokter->JadwalPeriksas as $JadwalPeriksa)
                                            @if ($JadwalPeriksa->status)
                                                <option value="{{ $JadwalPeriksa->id }}">
                                                    {{ $dokter->name }} - Spesialis {{ $dokter->poli }} | {{ $JadwalPeriksa->hari }}, {{ $JadwalPeriksa->jam_mulai }} - {{ $JadwalPeriksa->jam_selesai }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required></textarea>
                            </div>
                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn btn-primary">Submit</button>

                                @if (session('status') === 'janjiperiksa-created')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">{{ __('Berhasil Dibuat.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>