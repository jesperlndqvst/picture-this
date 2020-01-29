'use strict';

// Updates like number

const formLikes = document.querySelectorAll('.form--likes');

formLikes.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();

        const heart = form.children[1].firstElementChild;
        if (heart.classList.contains('fas')) {
            heart.classList.remove('fas');
            heart.classList.add('far');
        } else {
            heart.classList.remove('far');
            heart.classList.add('fas');
        }

        const formData = new FormData(form);

        fetch('app/posts/likes.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(json => (form.lastElementChild.textContent = json.likes));
    });
});

// Toggles edit information

const editPosts = document.querySelectorAll('.user-info__edit');

editPosts.forEach(post => {
    post.addEventListener('click', () => {
        const currentPost = post.parentElement.parentElement;
        const hiddenForm = currentPost.querySelector('.post-edit');
        const editContainer = currentPost.querySelector('.post-edit-container');
        const editPostExitBtn = currentPost.querySelector('.post-edit__exit');
        hiddenForm.classList.remove('hidden');

        editPostExitBtn.addEventListener('click', () => {
            hiddenForm.classList.add('hidden');
        });

        hiddenForm.addEventListener('click', event => {
            const isClickInside = editContainer.contains(event.target);
            if (!isClickInside) {
                hiddenForm.classList.add('hidden');
            }
        });
    });
});

// Preview post image

const fileFormInput = document.querySelector('.form--store__input');

if (fileFormInput) {
    fileFormInput.addEventListener('change', event => {
        const input = event.target;

        const reader = new FileReader();
        reader.onload = () => {
            const TheFileContents = reader.result;
            document.querySelector('.form--store__img').innerHTML =
                '<img src="' + TheFileContents + '" />';
        };
        reader.readAsDataURL(input.files[0]);
    });
}

// Preview avatar image

const avatarForm = document.querySelector('.form--avatar');

if (avatarForm) {
    const avatarInput = avatarForm.querySelector('input');

    avatarInput.addEventListener('change', event => {
        const input = event.target;

        const reader = new FileReader();
        reader.onload = () => {
            const TheFileContents = reader.result;
            document.querySelector('.avatar-settings__img').innerHTML =
                '<img src="' + TheFileContents + '" />';
        };
        reader.readAsDataURL(input.files[0]);
    });
}

// Search for users on keyup

search();

function search() {
    const searchResultDiv = document.querySelector('.search-result-container');
    const searchForm = document.querySelector('.form--search');

    if (searchForm) {
        searchForm.addEventListener('submit', event => {
            event.preventDefault();
        });
        const searchInput = searchForm.querySelector('.form__input');
        searchInput.addEventListener('keyup', event => {
            searchResultDiv.innerHTML = '';
            const searchString = event.target.value;
            if (searchString.length > 2) {
                const searchFormData = new FormData();
                searchFormData.append('search', searchString);
                fetch('app/users/search.php', {
                    method: 'POST',
                    body: searchFormData
                })
                    .then(response => response.json())
                    .then(searchArray =>
                        searchArray.forEach(user => {
                            const id = user.id;
                            const name = user.username;
                            const avatar = user.avatar;
                            const userHtml = stringToHTML(
                                searchResultStructure(id, name, avatar)
                            );
                            searchResultDiv.appendChild(userHtml);
                        })
                    );
            }
        });
    }
}
function searchResultStructure(id, username, avatar) {
    return `<a href="/profile.php?id=${id}&username=${username}">
             <div class="search-result">
                 <img class="search-result__img" src="app/uploads/avatars/${avatar}" alt="profile image">
                 <p>${username}</p>
             </div>
         </a>`;
}
//converts a string to html div
function stringToHTML(str) {
    const div = document.createElement('div');
    div.innerHTML = str;
    return div.firstChild;
}
