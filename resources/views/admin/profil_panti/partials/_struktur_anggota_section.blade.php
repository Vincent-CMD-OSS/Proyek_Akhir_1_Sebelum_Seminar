{{--
    Variables expected:
    $profil (ProfilPanti model instance)
    $strukturAnggotaList (Collection of StrukturOrganisasiAnggota)
    $editStrukturAnggota (StrukturOrganisasiAnggota model instance or null for edit)
--}}
<div class="struktur-anggota-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Anggota Struktur Organisasi</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahStrukturAnggotaModal">
            <i class="fas fa-plus"></i> Tambah Anggota
        </button>
    </div>

    {{-- Daftar Anggota Struktur --}}
    @if($strukturAnggotaList->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($strukturAnggotaList as $index => $anggota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($anggota->foto_anggota)
                            <img src="{{ Storage::url($anggota->foto_anggota) }}" alt="{{ $anggota->nama_anggota }}" width="80" class="img-thumbnail">
                        @else
                            <span class="text-muted">Tanpa Foto</span>
                        @endif
                    </td>
                    <td>{{ $anggota->nama_anggota }}</td>
                    <td>{{ $anggota->jabatan }}</td>
                    <td>{{ $anggota->urutan ?? '0' }}</td>
                    <td>
                        <a href="{{ route('admin.profil.panti.struktur.edit', $anggota->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- Atau tombol yang memicu modal edit
                        <button type="button" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editStrukturAnggotaModal-{{ $anggota->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        --}}
                        <form action="{{ route('admin.profil.panti.struktur.destroy', $anggota->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                {{-- Modal Edit untuk setiap anggota (jika menggunakan pendekatan modal yang di-generate di loop) --}}
                {{-- @include('admin.profil_panti.partials._modal_edit_struktur_anggota', ['anggota' => $anggota]) --}}
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">Belum ada anggota struktur organisasi yang ditambahkan.</div>
    @endif

    {{-- Modal Tambah Anggota Struktur --}}
    @include('admin.profil_panti.partials._modal_tambah_struktur_anggota')

    {{-- Modal Edit Anggota Struktur (jika $editStrukturAnggota ada dan menggunakan metode pass data ke view utama) --}}
    @if(isset($editStrukturAnggota) && $editStrukturAnggota)
        @include('admin.profil_panti.partials._modal_edit_struktur_anggota', ['anggota' => $editStrukturAnggota, 'is_editing_active' => true])
    @endif
</div>