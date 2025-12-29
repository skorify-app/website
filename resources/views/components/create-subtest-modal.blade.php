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
            <input type="file" name="icon_file" accept=".png,.jpg,.jpeg" />

            <label>File Soal (Excel)</label>
            <input type="file" name="questions_file" accept=".xlsx,.xltx,.xlt" />

            <label>File Gambar Soal (ZIP)</label>
            <input type="file" name="images_zip" accept=".zip" />

            <button type="button" id="submit-create-subtest">Tambah</button>

        </form>
    </div>
</div>
