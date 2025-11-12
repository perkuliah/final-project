<div>
<form wire:submit.prevent="submit">
    <input type="file" wire:model="submission_file" class="form-control form-control-sm mb-2">
    @error('submission_file') <span class="text-danger text-sm">{{ $message }}</span> @enderror

    <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled">
        <span wire:loading wire:target="submit">📤 Mengunggah...</span>
        <span wire:loading.remove>✅ Unggah Hasil</span>
    </button>
</form>
</div>
@script
<script>
    $wire.on('taskSubmitted', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Tugas Anda telah dikumpulkan.',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endscript
