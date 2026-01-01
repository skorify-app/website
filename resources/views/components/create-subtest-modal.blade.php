<div class="modal-subtes" id="create-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Tambah Subtes</h3>

        <label>Nama</label>
        <input type="text" name="subtest-name" placeholder="Masukkan nama subtes" />

         <label>Durasi Subtes</label>
        <div class="d-flex justify-content-between align-items-center">
            <input type="number" min="0" name="subtest-duration-hours" placeholder="Jam" style="width:27%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="subtest-duration-minutes" placeholder="Menit" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="subtest-duration-seconds" placeholder="Detik" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
        </div>

        <label>Ikon</label>
        <input type="file" name="subtest-icon" accept=".png, .jpg, .jpeg" />

        <label>File Soal (Excel)</label>
        <input type="file" name="subtest-questions" accept=".xlsx, .xltx, .xlt" />

        <button id="submit-create-subtest">Tambah</button>
    </div>
</div>
