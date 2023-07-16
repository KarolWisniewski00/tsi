<div class="col-start-6 col-end-13 p-3 rounded-lg message">
    <div class="flex items-center justify-start flex-row-reverse">
        <div class="flex items-center justify-center flex-shrink-0">
            <img src="{{ session()->has('profile_image') ? session('profile_image') : '' }}" class="w-10 h-10 rounded-full" alt="Profile Picture" onerror="setDefaultImage()">
        </div>
        <div class="relative mr-3 text-sm bg-indigo-50 py-2 px-4 shadow rounded-xl">
            <div>{{$message}}</div>
        </div>
    </div>
</div>