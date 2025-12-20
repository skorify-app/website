<div class="modal-subtes" id="edit-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Edit Subtes</h3>

        <input type="text" name="edit-subtest-id" class="d-none" />

        <label>Nama Subtes</label>
        <input type="text" name="edit-subtest-name" />

        <label>Ikon Subtes</label>
        <input type="file" name="edit-subtest-icon" accept=".png, .jpg, .jpeg" />

        <label>Durasi Subtes (Menit)</label>
        <input type="number" min="0" step="1" name="edit-subtest-duration" placeholder="Masukkan durasi subtes (menit)" />

        <button id="submit-edit-subtest">Edit</button>
    </div>
</div>
