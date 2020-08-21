@extends('layouts.app')

@section('content')
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
        }

        .chat {
            border: 1px solid gray;
            border-radius: 3px;
            width: 50%;
            padding: 0.5em
        }

        .chat-left {
            background-color: white;
            align-self: flex-start;
        }

        .chat-right {
            background-color: #adff2f7f;
            align-self: flex-end;
        }

        .message-input-contrainer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            border: 1px solid gray;
            padding: 1em;
        }

    </style>
    <div class="container" style="margin-bottom: 482px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div class="chat-container" >
                            @if ($chats->count() == 0)
                                <p>No Messages Yet.</p>
                            @endif
                            @foreach ($chats as $chat)
                                @if ($chat->sender_id == Auth::user()->id)
                                    <p class="chat chat-right">
                                        <b>{{ $chat->sender_name }}: </b><br>
                                        {{ $chat->message }}
                                    </p>
                                @else
                                    <p class="chat chat-left">
                                        <b>{{ $chat->sender_name }}: </b><br>
                                        {{ $chat->message }}
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="message-input-contrainer">
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Message</label>
                <input type="text" class="form-control" name="message">
            </div>
            <div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const messaging = firebase.messaging();

        messaging.usePublicVapidKey(
            "BPlHsze4k8p664cfYpmQjwOet-2SadSwuCudrQJo4ZZEevPdZoALpHFeU6DIjLH--JAw9oMEFURARo68ADVsRzc");

        function sendTokenToServer(fcm_token) {
            const user_id = '{{ Auth::user()->id }}';
            axios.post('/api/save-token', {
                fcm_token,
                user_id
            }).then(res => {
                console.log(res);
            });
        }

        function retrieveToken() {
            messaging.getToken().then((currentToken) => {
                if (currentToken) {
                    console.log('token received', currentToken)
                    sendTokenToServer(currentToken);
                    // updateUIForPushEnabled(currentToken);
                } else {
                    alert('you should allow notification')
                    // // Show permission request.
                    // console.log('No Instance ID token available. Request permission to generate one.');
                    // // Show permission UI.
                    // updateUIForPushPermissionRequired();
                    // setTokenSentToServer(false);
                }
            }).catch((err) => {
                console.log(err.message);
                // showToken('Error retrieving Instance ID token. ', err);
                // setTokenSentToServer(false);
            });
        }

        retrieveToken();

        messaging.onTokenRefresh(() => {
            retrieveToken();
        });

        messaging.onMessage((paylod) => {
            console.log('Message Recived');
            console.log(paylod);

            location.reload();
        })

    </script>
@endsection
