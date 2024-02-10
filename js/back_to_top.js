document.addEventListener('DOMContentLoaded', (event) => {
    // Fonction pour faire défiler la page jusqu'en haut
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Ajout d'un écouteur d'événement pour le bouton Back to Top
    let backToTopButton = document.querySelector(".back-to-top");
    
    if (backToTopButton) {
        backToTopButton.addEventListener('click', scrollToTop);

        window.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        });
    }
});
