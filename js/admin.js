(function ($) {
    'use strict';
    $(document).ready(function () {
        $('#savetrackbtn').click(function (event) {
            event.preventDefault();
            var payload = {
                action: 'presscast_add_track',
                artist: $('#post_ID').val(),
                title: $('#newtitle').val(),
                album: $('#newalbum').val(),
                publication: $('#newpublication').val(),
                buylink: $('#newbuylink').val()
            };
            var data = JSON.stringify(payload);
            $.post(ajaxurl, payload, function (response) {
                var o = JSON.parse(response);
                if (o.status == 'ok') {
                    $('#artist_tracks_box tbody tr:not(:last-child)').remove();
                    for (var i = 0; i < o.tracks.length; i++) {
                        var track = o.tracks[i];
                        var html = $('<tr class="data"><td>' + track.title + '</td><td>' + track.album + '</td><td>' + track.publication_year + '</td><td><a href="' + track.buy_link + '">' + track.buy_link.substring(0, 50) + '</a></td><td>' + track.id + '</td></tr>');
                        $('#artist_tracks_box tbody').prepend(html);
                    }
                }
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
