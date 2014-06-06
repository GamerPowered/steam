function setupFields() {
    prepLoadImages();

    var input = $('#urls').find(' :text:last');

    $(input).keydown(function(event) {
        if (this.value) {
            $('#inputs').append('<br /><input type="text" name="url[]" placeholder="Enter Steam URL"/>');
            $(this).off();

            setupFields();
        }
    })

}

function prepLoadImages()
{
    var urls_div = $("#urls");
    urls_div.find(':text').off();

    urls_div.submit(function() {
        $(this).find('input:text').filter(function() { return this.value == ""; }).remove();
    });

    urls_div.find(':text').blur(function() {
        var urls = $("#urls").find(":text").map(function(idx, elem) {
            return $(elem).val();
        }).get();

        $.get('/json/show', {'url': urls}, function(data)
        {
            var games_div = $('#games');
            games_div.empty();

            for (var i = 0; i < data.games.length; i++) {
                games_div.append(
                    '<img src="http://media.steampowered.com/steamcommunity/public/images/apps/' + data.games[i].appid + '/' + data.games[i].img_logo_url + '.jpg"/>'
                )
            }
        });
    });
}

$(document).ready(function() {
    setupFields();
});
