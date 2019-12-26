'use strict';

// Updates like number without page reload

const formLikes = document.querySelectorAll('.form--likes');

formLikes.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();

         const heart = form.children[2].firstElementChild;
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
            .then(json => form.firstElementChild.textContent = json.likes);
    });
});

