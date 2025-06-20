<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat Terhapus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Obat Terhapus') }}
                        </h2>
                        <a href="{{ route('dokter.obat.index') }}" class="btn btn-secondary mb-3">
                            Kembali ke Daftar Obat
                        </a>
                    </header>

                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Obat</th>
                                <th scope="col">Kemasan</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obatsTerhapus as $obat)
                                <tr>
                                    <th scope="row" class="align-middle text-start">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="align-middle text-start">
                                        {{ $obat->nama_obat }}
                                    </td>
                                    <td class="align-middle text-start">
                                        {{ $obat->kemasan }}
                                    </td>
                                    <td class="align-middle text-start">
                                        {{ 'Rp' . number_format($obat->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="flex items-center gap-3">
                                        {{-- Button Restore --}}
                                        <form action="{{ route('obat.restore', $obat->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Restore
                                            </button>
                                        </form>
                                        {{-- Button Force Delete --}}
                                        <form action="{{ route('obat.forceDelete', $obat->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus permanen?')">
                                                Force Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada obat terhapus.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>