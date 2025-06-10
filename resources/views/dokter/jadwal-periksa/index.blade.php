<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Jadwal Periksa') }}
                        </h2>
                        <div class="flex-col items-center justify-center text-center">
                            <a href="{{ route('dokter.jadwal-periksa.create') }}" class="btn btn-primary">Tambah Jadwal</a>

                            @if (session('status') === 'jadwal-periksa-created')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >
                                    {{ __('Created.') }}
                                </p>
                            @endif
                        </div>
                    </header>

                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($JadwalPeriksas as $jadwalperiksa)
                                <tr>
                                    <th scope="row" class="align-middle text-start">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="align-middle text-start">
                                        {{ $jadwalperiksa->hari }}
                                    </td>
                                    <td class="align-middle text-start">
                                        {{ $jadwalperiksa->jam_mulai }}
                                    </td>
                                    <td class="align-middle text-start">
                                        {{ $jadwalperiksa->jam_selesai }}
                                    </td>
                                    <td class="align-middle text-start">
                                        <form action="{{ route('dokter.jadwal-periksa.status', $jadwalperiksa->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 rounded text-white
                                                    {{ $jadwalperiksa->status ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }}">
                                                {{ $jadwalperiksa->status ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="flex items-center gap-3">
                                        {{-- Button Edit --}}
                                        <a href="{{ route('dokter.jadwal-periksa.edit', $jadwalperiksa->id) }}" class="btn btn-secondary btn-sm">
                                            Edit
                                        </a>
                                        {{-- Button Delete --}}
                                        <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwalperiksa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>