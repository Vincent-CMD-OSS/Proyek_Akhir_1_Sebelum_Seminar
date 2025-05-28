{{-- resources/views/admin/operasional/harian/partials/_slot_jadwal_item.blade.php --}}
{{--
    Variables:
    $index (int, index untuk array name)
    $slot (optional, instance of JadwalOperasionalHarian or object from old input)
--}}
<div class="slot-jadwal">
    <div class="row">
        <div class="col-md-2">
            <label for="slots_{{ $index }}_jam_buka" class="form-label form-label-sm">Jam Buka</label>
            <input type="time" class="form-control form-control-sm @error('slots.'.$index.'.jam_buka') is-invalid @enderror"
                   id="slots_{{ $index }}_jam_buka" name="slots[{{ $index }}][jam_buka]"
                   value="{{ old('slots.'.$index.'.jam_buka', $slot->jam_buka ?? '') }}">
            @error('slots.'.$index.'.jam_buka') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-2">
            <label for="slots_{{ $index }}_jam_tutup" class="form-label form-label-sm">Jam Tutup</label>
            <input type="time" class="form-control form-control-sm @error('slots.'.$index.'.jam_tutup') is-invalid @enderror"
                   id="slots_{{ $index }}_jam_tutup" name="slots[{{ $index }}][jam_tutup]"
                   value="{{ old('slots.'.$index.'.jam_tutup', $slot->jam_tutup ?? '') }}">
            @error('slots.'.$index.'.jam_tutup') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-2">
            <label for="slots_{{ $index }}_status_operasional" class="form-label form-label-sm">Status</label>
            <select class="form-select form-select-sm @error('slots.'.$index.'.status_operasional') is-invalid @enderror"
                    id="slots_{{ $index }}_status_operasional" name="slots[{{ $index }}][status_operasional]">
                <option value="Buka" {{ old('slots.'.$index.'.status_operasional', $slot->status_operasional ?? 'Buka') == 'Buka' ? 'selected' : '' }}>Buka</option>
                <option value="Tutup" {{ old('slots.'.$index.'.status_operasional', $slot->status_operasional ?? '') == 'Tutup' ? 'selected' : '' }}>Tutup</option>
            </select>
            @error('slots.'.$index.'.status_operasional') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-3">
            <label for="slots_{{ $index }}_keterangan" class="form-label form-label-sm">Keterangan</label>
            <input type="text" class="form-control form-control-sm @error('slots.'.$index.'.keterangan') is-invalid @enderror"
                   id="slots_{{ $index }}_keterangan" name="slots[{{ $index }}][keterangan]"
                   value="{{ old('slots.'.$index.'.keterangan', $slot->keterangan ?? '') }}" placeholder="Opsional">
            @error('slots.'.$index.'.keterangan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
         <div class="col-md-2">
            <label for="slots_{{ $index }}_urutan" class="form-label form-label-sm">Urutan</label>
            <input type="number" class="form-control form-control-sm @error('slots.'.$index.'.urutan') is-invalid @enderror"
                   id="slots_{{ $index }}_urutan" name="slots[{{ $index }}][urutan]"
                   value="{{ old('slots.'.$index.'.urutan', $slot->urutan ?? $index) }}" min="0">
            @error('slots.'.$index.'.urutan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm hapus-slot-btn w-100" title="Hapus Slot Ini">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</div>