<!DOCTYPE html>
<html lang="en">
<head>
    <title>Anonymous Bichig Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- JavaScript -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- End JavaScript -->
    <!-- CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- End CSS -->

</head>

<body>
<div class="chat">

    <!-- Header -->
    <div class="top">
        <div>
            <p>Anonymous Bichig Chat</p>
        </div>
    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div class="messages">
            @include('receive', ['message' => "👋"])
    </div>
    <!-- End Chat -->

    <!-- Footer -->
    <div class="bottom">
        <form>
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>
    </div>
    <!-- End Footer -->

</div>
</body>

<script>
    const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap3'});
    const channel = pusher.subscribe('public');

    //Receive messages
    channel.bind('chat', function (data) {
        $.post("/receive", {
            _token:  '{{csrf_token()}}',
            message: data.message,
        })
            .done(function (res) {
                $(".messages > .message").last().after(res);
                $(document).scrollTop($(document).height());
            });
    });

    //Broadcast messages
    $("form").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url:     "/broadcast",
            method:  'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data:    {
                _token:  '{{csrf_token()}}',
                message: $("form #message").val(),
            }
        }).done(function (res) {
            $(".messages > .message").last().after(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });
    });

</script>
</html>
