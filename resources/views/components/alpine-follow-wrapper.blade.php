@props(['user', 'style_class' => ''])

<div x-data="{
    following: {{ $user->isFollowedBy(Auth::user()) ? 'true' : 'false' }},

    followersCount: '{{ $user->followers->count() }}',

    follow() {
        axios.post('/follow/{{ $user->id }}')
            .then(response => {
                this.following = !this.following

                this.followersCount = response.data.followersCount

                return console.log(response.data);
            })
            .catch(error => {
                console.error(error)
            })
    }
}" class="{{ $style_class }}">
    {{ $slot }}
</div>
