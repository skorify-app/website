const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearBtn');

    // awalnya sembunyikan tombol X
    clearBtn.style.display = 'none';

    // pantau setiap kali ada perubahan teks
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearBtn.style.display = 'inline'; // tampilkan
        } else {
            clearBtn.style.display = 'none'; // sembunyikan
        }
    });

    // kalau tombol X diklik, kosongkan input
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        searchInput.focus();
    });