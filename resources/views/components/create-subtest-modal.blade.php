<div class="modal-subtes" id="create-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Tambah Subtes</h3>

        <label>Nama</label>
        <input type="text" name="subtest-name" placeholder="Masukkan nama subtes" />

        <label>Durasi Subtes (Menit)</label>
        <input type="number" min="0" step="1" name="subtest-duration" placeholder="Masukkan durasi subtes (menit)" />

        <label>Ikon</label>
        <input type="file" name="subtest-icon" accept=".png, .jpg, .jpeg" />

        <label>File Soal (Excel)</label>
        <input type="file" name="subtest-questions" accept=".xlsx, .xltx, .xlt" />

        <button id="submit-create-subtest">Tambah</button>
    </div>
</div>
