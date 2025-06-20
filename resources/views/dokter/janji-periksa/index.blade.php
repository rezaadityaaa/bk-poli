<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Janji Periksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Janji Periksa Anda') }}
                        </h2>
                    </header>

                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Pasien</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Jam</th>
                                <th scope="col">Keluhan</th>
                                <th scope="col">No Antrian</th>
                                {{-- Tambahan: Aksi jika ingin periksa sekarang --}}
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($janji as $item)
                                <tr>
                                    <td class="align-middle text-start">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-start">{{ $item->pasien->name ?? '-' }}</td>
                                    <td class="align-middle text-start">{{ $item->jadwalPeriksa->hari ?? '-' }}</td>
                                    <td class="align-middle text-start">
                                        {{ $item->jadwalPeriksa->jam_mulai }} - {{ $item->jadwalPeriksa->jam_selesai }}
                                    </td>
                                    <td class="align-middle text-start">{{ $item->keluhan }}</td>
                                    <td class="align-middle text-start">{{ $item->no_antrian }}</td>
                                    <td class="flex items-center gap-3">
                                        @if ($item->periksa)
                                            <a href="{{ route('dokter.periksa.edit', $item->periksa->id) }}" class="btn btn-success btn-sm">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('dokter.periksa.create', $item->id) }}" class="btn btn-primary btn-sm">
                                                Periksa
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">Belum ada janji periksa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
