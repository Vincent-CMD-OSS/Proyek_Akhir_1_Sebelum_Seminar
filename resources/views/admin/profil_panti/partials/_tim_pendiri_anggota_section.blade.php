{{--
    Variables expected:
    $profil (ProfilPanti model instance)
    $timPendiriList (Collection of TimPendiriAnggota)
    $editTimPendiri (TimPendiriAnggota model instance or null for edit)
--}}
<div class="tim-pendiri-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Anggota Tim Pendiri</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahTimPendiriModal">
            <i class="fas fa-plus"></i> Tambah Anggota
        </button>
    </div>

    {{-- Daftar Anggota Tim Pendiri --}}
    @if($timPendiriList->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Peran/Jabatan</th>
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timPendiriList as $index => $pendiri)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($pendiri->foto_pendiri)
                            <img src="{{ Storage::url($pendiri->foto_pendiri) }}" alt="{{ $pendiri->nama_pendiri }}" width="80" class="img-thumbnail">
                        @else
                            <span class="text-muted">Tanpa Foto</span>
                        @endif
                    </td>
                    <td>{{ $pendiri->nama_pendiri }}</td>
                    <td>{{ $pendiri->peran_atau_jabatan }}</td>
                    <td>{{ $pendiri->urutan ?? '0' }}</td>
                    <td>
                        <a href="{{ route('admin.profil.panti.pendiri.edit', $pendiri->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{--
                        <button type="button" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editTimPendiriModal-{{ $pendiri->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        --}}
                        <form action="{{ route('admin.profil.panti.pendiri.destroy', $pendiri->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota tim pendiri ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                {{-- @include('admin.profil_panti.partials._modal_edit_tim_pendiri', ['pendiri' => $pendiri]) --}}
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">Belum ada anggota tim pendiri yang ditambahkan.</div>
    @endif

    {{-- Modal Tambah Anggota Tim Pendiri --}}
    @include('admin.profil_panti.partials._modal_tambah_tim_pendiri')

    {{-- Modal Edit Anggota Tim Pendiri (jika $editTimPendiri ada) --}}
     @if(isset($editTimPendiri) && $editTimPendiri)
        @include('admin.profil_panti.partials._modal_edit_tim_pendiri', ['pendiri' => $editTimPendiri, 'is_editing_active' => true])
    @endif
</div>