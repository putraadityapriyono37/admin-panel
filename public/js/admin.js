// Tampilkan/sembunyikan password di halaman login.
document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
    button.addEventListener('click', function () {
        var input = document.getElementById(button.getAttribute('aria-controls'));
        if (!input) {
            return;
        }

        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-pressed', show ? 'true' : 'false');
        button.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');

        button.querySelectorAll('[data-eye]').forEach(function (icon) {
            var visible = icon.hasAttribute(show ? 'data-eye-open' : 'data-eye-closed');

            // properti .hidden hanya ada di elemen HTML, SVG harus lewat atribut
            if (visible) {
                icon.removeAttribute('hidden');
            } else {
                icon.setAttribute('hidden', '');
            }
        });
    });
});
