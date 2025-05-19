// Funcții pentru administrare
document.addEventListener('DOMContentLoaded', function() {
    // Funcții pentru modale
    window.showModal = function(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    window.hideModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Funcții pentru ștergere
    window.deleteAlbum = function(albumId) {
        if (confirm('Sigur doriți să ștergeți acest album? Această acțiune nu poate fi anulată.')) {
            window.location.href = `album-stergere.php?id=${albumId}`;
        }
    }

    window.deleteCategory = function(categoryId) {
        if (confirm('Sigur doriți să ștergeți această categorie? Această acțiune nu poate fi anulată.')) {
            window.location.href = `media.php?delete_category=${categoryId}`;
        }
    }

    // Închide modalele când se face click în afara lor
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
});