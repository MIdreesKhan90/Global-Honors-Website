function showAlert(msg, type) {
    var alert = '<div class="alert alert-' + type + '" role="alert">' + msg + '</div>';
    $('#formResponse').append(alert);
    setTimeout(function () {
        jQuery('#formResponse').find('.alert').remove();
    }, 3000);
}

$(document).ready(function () {
    $("#navToggle").click(function () {
        $(".collapse").slideToggle();
    });

    var shrinkHeader = 0.5 * $(window).height();
    var lastScrollTop = 0;
    var slideUpAnimationDuration = 300; // Duration of slide-up animation in milliseconds

    $(window).on("scroll", function () {
        var currentScrollTop = $(this).scrollTop();
        if (currentScrollTop > lastScrollTop) {
            // Scrolling down
            if (currentScrollTop >= shrinkHeader) {
                $("nav").addClass("sticky").removeClass("animate-up");
            }
        } else {
            // Scrolling up
            if (currentScrollTop <= shrinkHeader) {
                $("nav").addClass("animate-up");
                setTimeout(function () {
                    $("nav").removeClass("sticky");
                    // if ($("nav").hasClass("animate-up")) {
                    // }
                }, slideUpAnimationDuration);
            }
        }
        if (currentScrollTop === 0) {
            $("nav").removeClass("sticky");
            $("nav").removeClass("animate-up");
        }
        lastScrollTop = currentScrollTop;
    });

    $(".accordion-button").click(function () {
        var parentTab = $(this).parents('.accordion-tab');
        var isActive = parentTab.hasClass('active');
        $('.accordion-tab').removeClass('active').find(".accordion-content").slideUp();
        if (!isActive) {
            parentTab.addClass('active').find(".accordion-content").slideDown();
        }
    });

    $('.ribbon-text').html(function(_, html) {
        return html.replace(/(\$\d+)/, '<span class="price">$1</span>');
    });

    $('.product-testimonial').owlCarousel({
        loop: true,
        items: 1,
        margin: 10,
        nav: true,
        dots: false,
    });

    $('.home-testimonial').owlCarousel({
        loop: true,
        items: 1,
        margin: 10,
        nav: true,
        dots: false,
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Select the container for the navigation links
    const contentNav = document.querySelector('.content-nav');
    if (!contentNav) return;  // Exit if the navigation container doesn't exist

    // Create a container for the links
    const navList = document.createElement('div');

    // Select all h2 elements inside .resource-content
    const headers = document.querySelectorAll('.resource-content h2');

    headers.forEach((header, index) => {
        // Create a slug-like ID from the h2 text
        const id = 'search-' + header.textContent.toLowerCase().replace(/\s+/g, '-');

        // Assign the ID to the h2 element
        header.id = id;

        // Create the corresponding anchor link
        const anchor = document.createElement('a');
        anchor.href = '#' + id;
        anchor.textContent = header.textContent; // or any other text you want to display

        // Append the anchor to the navigation list
        navList.appendChild(anchor);
    });

    // Append the list to the navigation container
    contentNav.appendChild(navList);
});
