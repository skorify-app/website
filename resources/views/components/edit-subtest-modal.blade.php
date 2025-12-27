<div class="modal-subtes" id="edit-subtest-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Edit Subtes</h3>

        <input type="text" name="edit-subtest-id" class="d-none" />

        <label>Nama Subtes</label>
        <input type="text" name="edit-subtest-name" />

        <label>Ikon Subtes</label>
        <input type="file" name="edit-subtest-icon" accept=".png, .jpg, .jpeg" />

        <label>Durasi Subtes</label>
        <div class="d-flex justify-content-between align-items-center">
            <input type="number" min="0" name="edit-subtest-duration-hours" placeholder="Jam" style="width:27%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="edit-subtest-duration-minutes" placeholder="Menit" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
            <input type="number" min="0" max="59" name="edit-subtest-duration-seconds" placeholder="Detik" style="width:32%" inputmode="numeric" pattern="[0-9]*" step="1" class="duration-input" />
        </div>

        <button id="submit-edit-subtest">Simpan Perubahan</button>
    </div>
</div>
