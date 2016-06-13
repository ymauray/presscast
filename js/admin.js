(function ($) {
    'use strict';
    $(document).ready(function () {
        $('#savetrackbtn').click(function (event) {
            event.preventDefault();
            var payload = {
                action: 'presscast_add_track',
                title: $('#newtitle').val(),
                album: $('#newalbum').val(),
                publication: $('#newpublication').val(),
                buylink: $('#newbuylink').val()
            };
            var data = JSON.stringify(payload);
            console.log(data);
            $.post(ajaxurl, payload, function(response) {
                console.log(response);
            });
        });
    });

    $(document).ready(function () {
        var title = $('#newtitle');
        var album = $('#newalbum');
        var publication = $('#newpublication');
        var buylink = $('#newbuylink');
        var savetrackbtn = $('#savetrackbtn');

        var listener = function () {
            if (title.val() == '' || album.val() == '' || publication.val() == '' || buylink.val() == '') {
                savetrackbtn.prop('disabled', true);
            } else {
                savetrackbtn.prop('disabled', false);
            }
        };

        title.keydown(listener);
        album.keydown(listener);
        publication.keydown(listener);
        buylink.keydown(listener);
    });
}(window.jQuery));