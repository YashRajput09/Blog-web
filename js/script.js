document.addEventListener('DOMContentLoaded', () => {
    // Fetch and display all posts
    fetch('php/fetch_posts.php')
        .then(response => response.json())
        .then(posts => {
            const postsContainer = document.getElementById('posts');
            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.classList.add('post');
                postElement.innerHTML = `<h2>${post.title}</h2><p>${post.content}</p>`;
                postsContainer.appendChild(postElement);
            });
        });

    // Handle post form submission in dashboard
    const postForm = document.getElementById('postForm');
    if (postForm) {
        postForm.addEventListener('submit', event => {
            event.preventDefault();
            const formData = new FormData(postForm);
            fetch('php/post.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Post created successfully');
                    postForm.reset();
                    // Optionally reload the user's posts
                } else {
                    alert('Error creating post');
                }
            });
        });
    }
});
