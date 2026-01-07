(function($) {
    "use strict";

    new quixSettings({
        version: "light",
        layout: "vertical",
        navheaderBg: "color_1",
        headerBg: "color_1",
        sidebarStyle: "full",
        sidebarBg: "color_1",
        sidebarPosition: "fixed",
        headerPosition: "fixed",
        containerLayout: "wide",
        direction: "ltr"
    });

})(jQuery);

$(document).ready(function() {
    // Sidebar Toggle (listen on both nav-control and hamburger)
    $(".nav-control, .hamburger").on('click', function(e) {
        e.preventDefault();
        $('#main-wrapper').toggleClass("menu-toggle");
        $(".hamburger").toggleClass("is-active");

        // On small screens, also toggle body class to allow overlay behavior
        if ($(window).width() < 992) {
            $('body').toggleClass('nav-open');
        }
    });

    // Responsive on window resize: ensure consistent state
    function handleResize() {
        if ($(window).width() < 992) {
            // default collapsed on mobile
            $('#main-wrapper').addClass('menu-toggle');
            $(".hamburger").addClass("is-active");
        } else {
            // default expanded on desktop
            $('#main-wrapper').removeClass('menu-toggle');
            $(".hamburger").removeClass("is-active");
            $('body').removeClass('nav-open');
        }
    }

    $(window).on('resize', handleResize);
    handleResize();

    // Dropdown fallback: if Bootstrap's dropdowns are blocked, provide manual toggle
    $('.nav-item.dropdown > a, .nav-item.dropdown > .nav-link').on('click', function(e) {
        var $anchor = $(this);
        var $parent = $anchor.parent('.nav-item.dropdown');
        var $menu = $parent.find('.dropdown-menu').first();
        if ($menu.length) {
            // Prevent default navigation
            e.preventDefault();
            // Toggle show class (Bootstrap uses .show)
            var isShown = $menu.hasClass('show');
            if (isShown) {
                $menu.removeClass('show');
                $parent.removeClass('show');
                $anchor.attr('aria-expanded', 'false');
            } else {
                // close other dropdowns
                $('.nav-item.dropdown .dropdown-menu').removeClass('show');
                $('.nav-item.dropdown').removeClass('show');
                $('.nav-item.dropdown > a').attr('aria-expanded', 'false');

                $menu.addClass('show');
                $parent.addClass('show');
                $anchor.attr('aria-expanded', 'true');
            }
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.nav-item.dropdown').length) {
            $('.nav-item.dropdown .dropdown-menu').removeClass('show');
            $('.nav-item.dropdown').removeClass('show');
            $('.nav-item.dropdown > a').attr('aria-expanded', 'false');
        }
    });
});

// Chart initialization for dashboard
;(function() {
    if (typeof Chart === 'undefined') return;
    var ctx = document.getElementById('userStatsChart');
    if (!ctx) return;

    var labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agust','Sept','Okt','Nov','Des'];
    var data = [5,6,10,15,6,20,20,15,13,13,18,14];

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pengerjaan',
                data: data,
                fill: true,
                backgroundColor: 'rgba(37,99,235,0.06)',
                borderColor: 'rgba(4,120,87,0.9)',
                pointRadius: 3,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { drawBorder: false } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
})();

// ===== FIX UNTUK MODAL DAN DROPDOWN =====
$(document).on('shown.bs.modal', function() {
    // Pastikan body bisa di-scroll
    $('body').css('overflow', 'auto');
    $('body').css('padding-right', '0');
});

$(document).on('hidden.bs.modal', function() {
    // Pastikan dropdown tetap berfungsi
    $('body').css('overflow', 'auto');
    $('body').css('padding-right', '0');
});

// Pastikan dropdown di header tetap berfungsi
$(document).on('click', '.nav-item.dropdown > a, .nav-item.dropdown > .nav-link', function(e) {
    var $parent = $(this).parent('.nav-item.dropdown');
    var $menu = $parent.find('.dropdown-menu').first();
    
    if ($menu.length) {
        e.preventDefault();
        $menu.toggleClass('show');
        $parent.toggleClass('show');
        $(this).attr('aria-expanded', $menu.hasClass('show'));
    }
});

// Close dropdown ketika klik di luar
$(document).on('click', function(e) {
    if (!$(e.target).closest('.nav-item.dropdown').length) {
        $('.nav-item.dropdown .dropdown-menu').removeClass('show');
        $('.nav-item.dropdown').removeClass('show');
    }
});
