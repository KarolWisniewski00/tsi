<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Messages
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="chat">
                    <div class="flex flex-row items-center bg-indigo-100 border border-gray-200 rounded-lg p-4 m-4">
                        <div class="flex flex-col items-center mx-auto">
                            <div class="text-sm font-semibold mt-2">Karol Wiśniewski</div>
                            <div class="text-xs text-gray-500">Software developer</div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full">
                        @if(auth()->user()->role == 'admin')
                        <div class="flex flex-row items-center bg-indigo-100 border border-gray-200 rounded-lg p-4 m-4">
                            xd
                        </div>
                        @endif
                        <div class="w-full">
                            <div class="flex flex-row items-center bg-indigo-100 border border-gray-200 rounded-lg p-4 m-4">
                                <div class="messages w-full">
                                    @include('chat.receive', ['message' => "Hey! What's up!  👋"])
                                    @include('chat.receive', ['message' => "Ask a friend to open this link and you can chat with them!"])
                                </div>
                            </div>
                            <form class="bottom flex flex-row p-4 pt-0">

                                <input type="text" id="message" name="message" autocomplete="off" class="mr-4 bg-indigo-100 border-gray-200 text-indigo-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-indigo-700 dark:border-indigo-600 dark:placeholder-indigo-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                                <button type="submit" class="flex uppercase items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                                    <span>Send</span>
                                    <span class="ml-2">
                                        <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const pusher = new Pusher("{{config('broadcasting.connections.pusher.key')}}", {
        cluster: 'eu'
    });
    const channel = pusher.subscribe("{{ 'user.' . auth()->user()->id }}");

    //Receive messages
    channel.bind('chat', function(data) {
        $.post("chat/receive", {
                _token: '{{csrf_token()}}',
                message: data.message,
            })
            .done(function(res) {
                $(".messages > .message").last().after(res);
                $(document).scrollTop($(document).height());
            });
    });

    //Broadcast messages
    $("form").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "chat/broadcast",
            method: 'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data: {
                _token: '{{csrf_token()}}',
                message: $("form #message").val(),
            }
        }).done(function(res) {
            $(".messages > .message").last().after(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });
    });
</script>
<script>
    function setDefaultImage() {
        // Ta funkcja zostanie wywołana, gdy wystąpi błąd ładowania zdjęcia (onerror).
        // Tutaj możesz ustawić domyślne zdjęcie profilowe lub podjąć inne działania.
        const defaultImageURL = "{{ asset('svg/undraw_male_avatar_g98d.svg') }}";
        document.querySelector('img').src = defaultImageURL;
    }
</script>

</html>