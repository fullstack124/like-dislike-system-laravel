const show_all_posts = async () => {
    const response = await (await fetch('/posts/all')).json();
    document.getElementById('show_all_posts').innerHTML = response.data;
}
show_all_posts();

const csrf_token = $("#token").val();

$(document).on('click', '#like_post', async function (e) {
    e.preventDefault();

    const post_id = $(this).data('post-id');
    const response = await (await fetch('/posts/like', {
        method: 'POST',
        body: JSON.stringify({
            post_id,
            "_token": csrf_token
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })).json();
    if (response.success) {
        show_all_posts();
    }
})

$(document).on('click', '#dis_like_post', async function (e) {
    e.preventDefault();

    const post_id = $(this).data('post-id');
    const response = await (await fetch('/posts/dis_like', {
        method: 'POST',
        body: JSON.stringify({
            post_id,
            "_token": csrf_token
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })).json();
    if (response.success) {
        show_all_posts();
    }
})



const show_comment = async (id) => {
    const response = await (await fetch('/comment/all', {
        method: 'POST',
        body: JSON.stringify({
            post_id: id,
            "_token": csrf_token
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })).json();
    document.getElementById('show_4_comments' + id).innerHTML = response.data;
}

const show_replay_comment = async (id, comment_id) => {
    const response = await (await fetch('/comment/replay/all', {
        method: 'POST',
        body: JSON.stringify({
            post_id: id,
            comment_id,
            "_token": csrf_token
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })).json();
    document.getElementById('show_replay_comments' + id).innerHTML = response.data;
}


let post_id = 0;
$(document).on('click', '#show_comment', function () {
    post_id = $(this).data('post-id');
    show_comment(post_id);
    const show_comment_box = $("#make_comment_box" + post_id);
    show_comment_box.toggle('block')
});

$(document).on('submit', '#makeComment', function (e) {
    e.preventDefault();
    const form_data = new FormData();
    const comment = $("#comment" + post_id).val();
    form_data.append('comment', comment);
    form_data.append('_token', csrf_token);
    form_data.append('post_id', post_id);

    $.ajax({
        type: 'POST',
        data: form_data,
        url: '/comment/create',
        processData: false,
        contentType: false,
        dataType: 'json',
        success: (data) => {
            if (data.data.success) {
                $("#comment" + post_id).val();
                show_comment(data.data.post_id);
                show_all_posts();
            }
        }
    })
})

let replay_post_id = 0;
let comment_id = 0;
$(document).on('click', '#make_replay', function () {
    replay_post_id = $(this).data('post-id');
    comment_id = $(this).data('comment-id');
    const show_comment_box = $("#make_comment_box" + post_id);
    show_comment_box.toggle('hidden')
    const replay_show_comment_box = $("#replay_make_comment_box" + post_id);
    replay_show_comment_box.toggle('block')
});

$(document).on('submit', '#makeReplayComment', function (e) {
    e.preventDefault();
    const form_data = new FormData();
    const comment = $("#replay_comment" + replay_post_id).val();
    form_data.append('comment', comment);
    form_data.append('comment_id', comment_id);
    form_data.append('_token', csrf_token);
    form_data.append('post_id', replay_post_id);

    $.ajax({
        type: 'POST',
        data: form_data,
        url: '/comment/create/replay',
        processData: false,
        contentType: false,
        dataType: 'json',
        success: (data) => {
            if (data.data.success) {
                $("#replay_comment" + replay_post_id).val();
                show_comment(data.data.post_id);
                const show_comment_box = $("#make_comment_box" + data.data.post_id);
                show_comment_box.toggle('hidden')
                const replay_show_comment_box = $("#replay_make_comment_box" + data.data.post_id);
                replay_show_comment_box.toggle('block')
            }
        }
    })
})
