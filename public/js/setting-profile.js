$(document).ready(function () {

    // ===============================
    // UBAH NAMA
    // ===============================
    $('#saveNameBtn').on('click', function () {
        $.ajax({
            url: "/profile/update-name",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#inputName').val()
            },
            success: function (res) {
                alert("Nama berhasil diperbarui!");
                location.reload();
            },
            error: function (err) {
                alert("Gagal mengubah nama!");
            }
        });
    });


    // ===============================
    // UBAH EMAIL
    // ===============================
    $('#saveEmailBtn').on('click', function () {
        $.ajax({
            url: "/profile/update-email",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                email: $('#inputEmail').val()
            },
            success: function (res) {
                alert("Email berhasil diperbarui!");
                location.reload();
            },
            error: function () {
                alert("Gagal mengubah email!");
            }
        });
    });


    // ===============================
    // UBAH PASSWORD
    // ===============================
    $('#savePasswordBtn').on('click', function () {
        $.ajax({
            url: "/profile/update-password",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                current_password: $('#inputCurrentPassword').val(),
                password: $('#inputNewPassword').val()
            },
            success: function () {
                alert("Password berhasil diperbarui!");
                location.reload();
            },
            error: function () {
                alert("Gagal mengubah password!");
            }
        });
    });

});
