<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <title>What's Good</title>
    <style>
        body {
            padding-top: 20px;
        }

        @media (min-width: 992px) {
            body {
                padding-top: 20px;
            }
        }

        #mp3player {
            width: 80%;
        }
    </style>
</head>
<body>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">What's Good</h1>
            <hr>
            <audio id="mp3player" controls></audio>
        </div>
    </div>

    <div class="mt-5 row">
        <div class="col">
            <div class="list-group" id="episodes"></div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title" id="episode-title"></h4>
                    <h6 class="card-subtitle mb-2 text-muted" id="episode-airdate"></h6>
                    <p class="card-text" id="episode-description"></p>
                    <a href="#" class="card-link" id="episode-download">Download</a>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-block">
                    <h5 class="card-title">About What's Good</h5>
                    <p class="card-text">
                        Jeff and Steve bring you What's Good - a radio show hosted on PeaceFM with the best hip-hop
                        tracks! Get down with the best of hip-hop including Snoop Dogg, Biggie, Tupac, Dr. Dre, and many
                        more!
                    </p>
                    <p class="card-text">
                        Tweet Jeff <a href="https://twitter.com/jeffm8r" target="_blank">@Jeffm8r</a> and Steve <a
                                href="https://twitter.com/PhalanxIII" target="_blank">@PhalanxIII</a> #whatsgood
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        var episodes = [];
        var firstVisit = true;

        jQuery.getJSON("/api/episodes", function (data) {
            data.forEach(function (item) {
                episodes[item.id] = item;
                $("<a></a>").attr('data-episodeid', item.id).attr('href', '#').addClass('list-group-item list-group-item-action episode').text(item.title).appendTo($("#episodes"));
            });

            $("#episodes .episode:first").click();
            firstVisit = false;
        });

        $("#episodes").on("click", ".episode", function () {
            if (!$(this).hasClass('active')) {
                $(".episode.active").removeClass('active');
                $(this).addClass("active");

                var episode = episodes[$(this).attr('data-episodeid')];
                $("#episode-title").text(episode.title);
                $("#episode-airdate").text(episode.air_date);
                $("#episode-description").text(episode.description);
                $("#episode-download").attr('href', "/episodes/" + episode.location);

                $("#mp3player").empty();
                $("<source/>").attr('src', "/episodes/" + episode.location).attr('type', 'audio/mp3').appendTo($('#mp3player'));

                var player = $("#mp3player")[0];
                player.load();
                if (!firstVisit) {
                    player.play();
                }
            } else {
                $("#mp3player")[0].play();
            }
        });
    });
</script>
</body>
</html>