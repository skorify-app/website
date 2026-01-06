<div class="modal-subtes" id="create-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Tambah Subtes</h3>

        <form id="create-subtest-form"
              method="POST"
              action="/subtest"
              enctype="multipart/form-data">

            @csrf

            <label>Nama</label>
            <input type="text" name="name" placeholder="Masukkan nama subtes" />

            <label>Durasi Subtes</label>
            <div class="d-flex justify-content-between align-items-center">
                <input type="number" name="duration_hours" placeholder="Jam" style="width:27%" />
                <input type="number" name="duration_minutes" placeholder="Menit" style="width:32%" />
                <input type="number" name="duration_seconds_input" placeholder="Detik" style="width:32%" />
            </div>

            <label>Ikon</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="icon_file" id="create-icon-file" accept=".png,.jpg,.jpeg">
                <label class="custom-file-label" for="create-icon-file">Pilih berkas...</label>
            </div>

            <label>Berkas Soal (Excel)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="questions_file" id="create-questions-file" accept=".xlsx,.xltx,.xlt">
                <label class="custom-file-label" for="create-questions-file">Pilih berkas...</label>
            </div>

            <label>Berkas Gambar Soal (ZIP)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="images_zip" id="create-images-file" accept=".zip">
                <label class="custom-file-label" for="create-images-file">Pilih berkas...</label>
            </div>

            <button type="button" id="submit-create-subtest">Tambah</button>

        </form>
    </div>
</div>

<script>
// Bootstrap custom file input - update label with filename
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('#create-subtest-modal .custom-file-input');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih berkas...';
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });
});
</script>
