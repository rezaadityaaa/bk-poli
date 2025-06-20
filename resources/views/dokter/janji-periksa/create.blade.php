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
                        <input type="number" name="biaya_periksa" id="biaya_periksa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly value="150000">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Resep Obat</label>
                        <div class="dropdown-multi" id="dropdownMulti">
                            <button type="button" class="form-control" id="dropdownBtn">
                                <span id="selectedObatText">Pilih Obat</span>
                            </button>
                            <div class="dropdown-multi-content" id="dropdownContent">
                                @foreach($obats as $obat)
                                    <label style="display:block; padding:4px 8px;">
                                        <input type="checkbox" name="obat_ids[]" value="{{ $obat->id }}" class="obat-checkbox">
                                        {{ $obat->nama_obat }} ({{ $obat->kemasan }}) - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <small class="text-muted">Klik untuk memilih lebih dari satu obat.</small>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .dropdown-multi {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .dropdown-multi-content {
            display: none;
            position: absolute;
            background: #fff;
            min-width: 250px;
            border: 1px solid #ddd;
            z-index: 1;
            max-height: 200px;
            overflow-y: auto;
        }
        .dropdown-multi.open .dropdown-multi-content {
            display: block;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const biayaAwal = 150000;
            const biayaInput = document.getElementById('biaya_periksa');
            const selectObat = document.getElementById('obat_ids');

            function hitungTotal() {
                let total = biayaAwal;
                Array.from(selectObat.selectedOptions).forEach(opt => {
                    total += parseInt(opt.getAttribute('data-harga')) || 0;
                });
                biayaInput.value = total;
            }

            selectObat.addEventListener('change', hitungTotal);
            hitungTotal();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const dropdown = document.getElementById('dropdownMulti');
            const btn = document.getElementById('dropdownBtn');
            const content = document.getElementById('dropdownContent');
            const checkboxes = content.querySelectorAll('.obat-checkbox');
            const selectedText = document.getElementById('selectedObatText');

            btn.addEventListener('click', function(e) {
                dropdown.classList.toggle('open');
            });

            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });

            function updateSelectedText() {
                const selected = [];
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        selected.push(cb.parentElement.textContent.trim());
                    }
                });
                selectedText.textContent = selected.length ? selected.join(', ') : 'Pilih Obat';
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectedText);
            });

            updateSelectedText();
        });
    </script>
</x-app-layout>
