<div class="modal-subtes" id="edit-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Edit Subtes</h3>

        <input type="text" name="edit-subtest-id" class="d-none" />

        <label>Nama Subtes</label>
        <input type="text" name="edit-subtest-name" />


        <label>Durasi Subtes</label>
        <div class="d-flex justify-content-between align-items-center">
            <input type="number" min="0" name="edit-subtest-duration-hours" placeholder="Jam" style="width:27%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="edit-subtest-duration-minutes" placeholder="Menit" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="edit-subtest-duration-seconds" placeholder="Detik" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
        </div>

        <label>Ikon Subtes</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="edit-subtest-icon" id="edit-icon-file" accept=".png, .jpg, .jpeg">
            <label class="custom-file-label" for="edit-icon-file">Pilih berkas...</label>
        </div>

        <label>Berkas Soal (Excel) </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="edit-subtest-questions-file" id="edit-questions-file" accept=".xlsx,.xltx,.xlt">
            <label class="custom-file-label" for="edit-questions-file">Pilih berkas...</label>
        </div>

        <label>Berkas Gambar Soal (ZIP) </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="edit-subtest-images-zip" id="edit-images-file" accept=".zip">
            <label class="custom-file-label" for="edit-images-file">Pilih berkas...</label>
        </div>

        <button id="submit-edit-subtest">Simpan Perubahan</button>
    </div>
</div>

<script>
// Bootstrap custom file input - update label with filename
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('#edit-subtest-modal .custom-file-input');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih berkas...';
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });
});
</script>
