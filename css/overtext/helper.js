jQuery(document).ready(function($){
    // Only run if there is a title.
    if ($('#cboxTitle:empty').length == false) {
        setTimeout(function () { $('#cboxTitle', context).slideUp() }, 1500);
        $('#cboxLoadedContent img', context).bind('mouseover', function () {
            $('#cboxTitle').slideDown();
        });
        $('#cboxOverlay').bind('mouseover', function () {
            $('#cboxTitle').slideUp();
        });
    }
    else {
        $('#cboxTitle').hide();
    }
});