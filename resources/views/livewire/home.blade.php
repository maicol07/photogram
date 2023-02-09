<div>
    @php($posts = $this->getPosts())

    @if($posts->isEmpty())
        <p>@lang("There aren't posts for you.")</p>
    @endif

    @foreach($posts as $post)
        <livewire:posts.post-view :wire-key="$post->id" :post="$post" width=60 ></livewire:posts.post-view>
    @endforeach
</div>
