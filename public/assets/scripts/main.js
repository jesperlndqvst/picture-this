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

const avatarForm = document.querySelector('.avatar-settings__form');

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
