'use strict';

const formLikes = document.querySelectorAll('.form--likes');

formLikes.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('app/posts/likes.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(json => form.firstElementChild.textContent = json.likes);
    });
});
