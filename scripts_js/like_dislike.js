'use strict'

function userLikePost(user_id, post_id) {
    const data = new FormData();

    data.append("user_id", user_id);
    data.append("post_id", post_id);
    data.append("like_post", post_id);

    fetch(`like_dislike.php/`, {
        method: 'POST',
        body: data
    })
    .then( (response) => {
        if (response.ok) {
            // handleLikeIcon(post_id);
            return response.json();
        } else {
            throw Error(`Like Post failed with status: ${response.status}`)
        }
    })
    .then( (data) => {
        console.log(data);
        // totalLikes.innerText = data.total_likes + ' Likes'
        // totalDislikes.innerText = data.total_dislikes + ' Dislikes'
    })
    .then( () => {
        // Push state because otherwise doesn't take effect visually when navigating back and forth
        const postFeedBody = document.querySelector('.body-fluid');
        history.replaceState(postFeedBody.innerHTML, '', '');
    })
    .catch( (error) => console.log(error))
}

// Like Post functionality #############################################################################
const postLike = (uuid) => {

    const likeForm = document.querySelector(`#like_${uuid}`)
    const totalLikes = document.querySelector(`#total_likes_${uuid}`)
    const totalDislikes = document.querySelector(`#total_dislikes_${uuid}`)
    const data = new FormData()
    data.append('csrfmiddlewaretoken', likeForm.firstElementChild.value)

    fetch(`/home/post_like/${uuid}/`, {
        method: 'POST',
        body: data
    })
    .then( (response) => {
        if (response.ok) {
            handleLikeIcon(uuid)
            return response.json()
        } else {
            throw Error(`Like Post failed with status: ${response.status}`)
        }
    })
    .then( (data) => {
        console.log(data)
        totalLikes.innerText = data.total_likes + ' Likes'
        totalDislikes.innerText = data.total_dislikes + ' Dislikes'
    })
    .then( () => {
        // Push state because otherwise doesn't take effect visually when navigating back and forth
        const postFeedArea = document.querySelector('.main-side-area')
        history.replaceState(postFeedArea.innerHTML, '', '')
    })
    .catch( (error) => console.log(error))
}
const handleLikeIcon = (uuid) => {  
    
    const likeForm = document.querySelector(`#like_${uuid}`)
    const dislikeForm = document.querySelector(`#dislike_${uuid}`)

        if (likeForm.lastElementChild.attributes.src.value === '/static/post/icons/alreadyliked.png') {
            likeForm.lastElementChild.attributes.src.value = '/static/post/icons/like.png'

        } else if (likeForm.lastElementChild.attributes.src.value === '/static/post/icons/like.png') {
            likeForm.lastElementChild.attributes.src.value = '/static/post/icons/alreadyliked.png'
            dislikeForm.lastElementChild.attributes.src.value = '/static/post/icons/dislike.png'
        }
}
// Dislike Post functionality #############################################################################
// const postDislike = (uuid) => {

//     const dislikeForm = document.querySelector(`#dislike_${uuid}`)
//     const totalDislikes = document.querySelector(`#total_dislikes_${uuid}`)
//     const totalLikes = document.querySelector(`#total_likes_${uuid}`)
//     const data = new FormData()
//     data.append('csrfmiddlewaretoken', dislikeForm.firstElementChild.value)

//     fetch(`/home/post_dislike/${uuid}/`, {
//         method: 'POST',
//         body: data
//     })
//     .then( (response) => {
//         if (response.ok) {
//             handleDislikeIcon(uuid)
//             return response.json()
//         } else {
//             throw Error(`Dislike Post failed with status: ${response.status}`)
//         }
//     })
//     .then( (data) => {
//         console.log(data)
//         totalDislikes.innerText = data.total_dislikes + ' Dislikes'
//         totalLikes.innerText = data.total_likes + ' Likes'
//     })
//     .then( () => {
//         // Push state because otherwise doesn't take effect visually when navigating back and forth
//         const postFeedArea = document.querySelector('.main-side-area')
//         history.replaceState(postFeedArea.innerHTML, '', '')
//     })
//     .catch( (error) => console.log(error))
// }
// const handleDislikeIcon = (uuid) => {  
    
//     const dislikeForm = document.querySelector(`#dislike_${uuid}`)
//     const likeForm = document.querySelector(`#like_${uuid}`)

//         if (dislikeForm.lastElementChild.attributes.src.value === '/static/post/icons/alreadydisliked.png') {
//             dislikeForm.lastElementChild.attributes.src.value = '/static/post/icons/dislike.png'

//         } else if (dislikeForm.lastElementChild.attributes.src.value === '/static/post/icons/dislike.png') {
//             dislikeForm.lastElementChild.attributes.src.value = '/static/post/icons/alreadydisliked.png'
//             likeForm.lastElementChild.attributes.src.value = '/static/post/icons/like.png'
//         }
// }
const input = document.querySelector(".body-fluid");
input.addEventListener("click", (event) => {
    console.log(event);
    
    if (event.target.name === "like_post") {
        userLikePost(event.target.attributes["user_id"].nodeValue, event.target.attributes["post_id"].nodeValue);
    }
})