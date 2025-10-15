document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.rating-form');

    forms.forEach(form => {
        const commentId = form.querySelector('input[name="comment_id"]').value;
        const userId = form.querySelector('input[name="user_id"]').value;
        const labelScore = document.getElementById(`labelScore-${commentId}`);
        const stars = form.querySelectorAll(`.star-rating input[type="radio"]`);

        stars.forEach(star => {
            star.addEventListener('change', function () {
                const formData = new FormData(form);
                fetch('Controller/handleForum/handleScore.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar la puntuación actual
                        const currentRating = data.current_rating;
                        if (currentRating > 0) {
                            document.getElementById(`star${currentRating}-${commentId}`).checked = true;
                        }

                        // Actualizar la puntuación promedio
                        return fetch(`Controller/handleForum/handleScore.php?action=average&comment_id=${commentId}`);
                    })
                    .then(response => response.json())
                    .then(data => {
                        const averageRating = data.average_rating;
                        if (averageRating !== undefined && averageRating !== null) {
                            labelScore.textContent = `Puntuación: ${averageRating}`;
                        } else {
                            labelScore.textContent = `Puntuación: 0`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Obtener y mostrar la puntuación actual del usuario para el comentario
        fetch(`Controller/handleForum/handleScore.php?comment_id=${commentId}&user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                const currentRating = data.current_rating;
                if (currentRating > 0) {
                    document.getElementById(`star${currentRating}-${commentId}`).checked = true;
                }
            })
            .catch(error => {
                console.error('Error fetching current rating:', error);
            });

        // Obtener y mostrar la puntuación promedio
        fetch(`Controller/handleForum/handleScore.php?action=average&comment_id=${commentId}`)
            .then(response => response.json())
            .then(data => {
                const averageRating = data.average_rating;
                if (averageRating !== undefined && averageRating !== null) {
                    labelScore.textContent = `Puntuación: ${averageRating}`;
                } else {
                    labelScore.textContent = `Puntuación: 0`;
                }
            })
            .catch(error => {
                console.error('Error fetching average rating:', error);
            });
    });
});
