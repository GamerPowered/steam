function setupFields() {
    var input = $('#urls').find(' :text:last');

    $(input).keydown(function (event) {
        if (this.value) {
            $('#inputs').append('<br /><input type="text" name="url[]" placeholder="Enter Steam URL"/>');
            $(this).off();

            prepLoadImages();
            setupFields();
        }
    });
}

function prepLoadImages() {
    if (self.old_urls == undefined) {
        self.old_urls = '';
    }

    var urls_div = $("#urls");
    urls_div.find(':text').off();

    urls_div.submit(function () {
        $(this).find('input:text').filter(function () {
            return this.value == "";
        }).remove();
    });

    urls_div.find(':text').blur(function () {

        var urls = $("#urls").find(":text").map(function (idx, elem) {
            return $(elem).val();
        }).get();

        if (urls.join() != self.old_urls) {
            self.old_urls = urls.join();
            var games_div = $('#games');

            loading_div = $('#loading');

            games_div.fadeOut(400, function () {
                loading_div.show();
            });

            $.get('/json/show', {'url': urls}, function (data) {
                games_div.empty();

                games_div.append('<div id="count"></div>');

                var game_count = 0;

                for (var i = 0; i < data.games.length; i++) {
                    var img = undefined;

                    var width = 184;
                    var height = 69;

                    if (data.games[i].img_logo_url != '') {
                        img = data.games[i].img_logo_url;
                    }

                    if (img != undefined) {
                        var appid = data.games[i].appid
                        var name = data.games[i].name

                        games_div.append(
                            '<img src="http://media.steampowered.com/steamcommunity/public/images/apps/' +
                            appid +
                            '/' +
                            img +
                            '.jpg" width="' +
                            width +
                            '" height="' +
                            height +
                            '" alt="' +
                            name +
                            '" title="' +
                            name +
                            '" />'
                        )
                        game_count++;
                    }
                }

                games_div.find('#count').html(game_count + ' games');

                games_div.waitForImages(function () {
                    loading_div.fadeOut(400, function () {
                        games_div.fadeIn();
                    });
                });
            });
        }
    });
}

$(document).ready(function () {
    prepLoadImages();
    setupFields();
});
