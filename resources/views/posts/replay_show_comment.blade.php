@forelse ($comments as $comment)
    <p class="my-3 text-gray-700 text-sm">
        {{ $comment->content }}
    </p>
    <hr>
@empty
    <h1>Comment Not found</h1>
@endforelse
