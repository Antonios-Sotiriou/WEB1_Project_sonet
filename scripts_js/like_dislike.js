'use strict'

const input = document.querySelector(".body-fluid");
input.addEventListener("click", (event) => {
    if (event.target.name === "like_post") {
        userLikePost(event.target.attributes["user_id"].nodeValue, event.target.attributes["post_id"].nodeValue);
    } else if (event.target.name == "dislike_post") {
        userDislikePost(event.target.attributes["user_id"].nodeValue, event.target.attributes["post_id"].nodeValue);
    }
})

function userLikePost(user_id, post_id) {
    const data = new FormData();

    if (user_id == 0) {
        return;
    }

    data.append("user_id", user_id);
    data.append("post_id", post_id);
    data.append("like_post", post_id);

    fetch(`like_dislike.php/`, {
        method: 'POST',
        body: data
    })
    .then( (response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw Error(`Like Post failed with status: ${response.status}`);
        }
    })
    .then( (data) => {
        const likes_info = document.querySelector("#post_" + data.post_id + "_likes_info");
        likes_info.innerText = data.total_likes + " Likes";

        const dislikes_info = document.querySelector("#post_" + data.post_id + "_dislikes_info");
        dislikes_info.innerText = data.total_dislikes + " Dislikes";

        handleLikeImg(data.post_id);
    })
    .then( () => {
        // Push state because otherwise doesn't take effect visually when navigating back and forth
        const postFeedBody = document.querySelector('.body-fluid');
        history.replaceState(postFeedBody.innerHTML, '', '');
    })
    .catch( (error) => console.log(error))
}
const handleLikeImg = (post_id) => {  
    
    const like_img = document.querySelector(`#post_${post_id}_like_img`);
    const dislike_img = document.querySelector(`#post_${post_id}_dislike_img`)

    if (like_img.attributes.src.value === 'images/alreadyliked.png') {
        like_img.attributes.src.value = 'images/like.png'

    } else if (like_img.attributes.src.value === 'images/like.png') {
        like_img.attributes.src.value = 'images/alreadyliked.png'
        dislike_img.attributes.src.value = 'images/dislike.png'
    }
}
function userDislikePost(user_id, post_id) {
    const data = new FormData();

    if (user_id == 0) {
        return;
    }

    data.append("user_id", user_id);
    data.append("post_id", post_id);
    data.append("dislike_post", post_id);

    fetch(`like_dislike.php/`, {
        method: 'POST',
        body: data
    })
    .then( (response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw Error(`Like Post failed with status: ${response.status}`);
        }
    })
    .then( (data) => {
        const likes_info = document.querySelector("#post_" + data.post_id + "_likes_info");
        likes_info.innerText = data.total_likes + " Likes";

        const dislikes_info = document.querySelector("#post_" + data.post_id + "_dislikes_info");
        dislikes_info.innerText = data.total_dislikes + " Dislikes";

        handleDislikeImg(data.post_id);
    })
    .then( () => {
        // Push state because otherwise doesn't take effect visually when navigating back and forth
        const postFeedBody = document.querySelector('.body-fluid');
        history.replaceState(postFeedBody.innerHTML, '', '');
    })
    .catch( (error) => console.log(error))
}
const handleDislikeImg = (post_id) => {  
    
    const like_img = document.querySelector(`#post_${post_id}_like_img`);
    const dislike_img = document.querySelector(`#post_${post_id}_dislike_img`)

    if (dislike_img.attributes.src.value === 'images/alreadydisliked.png') {
        dislike_img.attributes.src.value = 'images/dislike.png'

    } else if (dislike_img.attributes.src.value === 'images/dislike.png') {
        dislike_img.attributes.src.value = 'images/alreadydisliked.png'
        like_img.attributes.src.value = 'images/like.png'
    }
}


