document.addEventListener('DOMContentLoaded', function() {
    // Initialize light gallery
    const galleryElements = document.querySelectorAll('.photo-gallery');
    
    if (galleryElements.length > 0) {
        lightGallery(galleryElements[0], {
            selector: '.lightbox',
            speed: 500,
            download: false,
            counter: true,
            loadYoutubeThumbnail: true,
            youtubePlayerParams: {
                modestbranding: 1,
                showinfo: 0,
                rel: 0
            }
        });
    }
}); 