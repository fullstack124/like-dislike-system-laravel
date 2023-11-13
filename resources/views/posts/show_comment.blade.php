@forelse ($comments as $comment)
    <p class="my-3 text-gray-700 text-sm">
    <div>
        {{ $comment->content }}
        <button class="px-2 py-1 bg-teal-600" data-post-id="{{ $comment->post_id }}" data-comment-id="{{ $comment->id }}" id="make_replay">Replay</button>
    </div>
   @php
       $replay_comments=\App\Models\ReplyComment::where('comment_id',$comment->id)->latest()->get();
   @endphp
   @foreach ($replay_comments as $comment1)
   <p class="my-3 ml-10 text-gray-700 text-sm">
    <div>
        {{ $comment1->content }}
        <button class="px-2 py-1 bg-teal-600" data-post-id="{{ $comment->post_id }}" data-comment-id="{{ $comment->id }}" id="make_replay">Replay</button>
    </div>
   @endforeach
    </p>
    <hr>
@empty
    <h1>Comment Not found</h1>
@endforelse
