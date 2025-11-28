<?php
function renderMedia($url) {

    // Detectar YouTube
    if (strpos($url, "youtube.com") !== false || strpos($url, "youtu.be") !== false) {
        return '
            <div class="video-wrapper">
                <iframe src="'. $url .'"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>';
    }

    // Detectar imágenes
    if (preg_match("/\.(jpg|jpeg|png|gif|webp)$/i", $url)) {
        return '<img src="'. $url .'" class="exercise-image">';
    }

    // Detectar MP4
    if (preg_match("/\.mp4$/i", $url)) {
        return '
            <video class="exercise-video" controls>
                <source src="'. $url .'" type="video/mp4">
            </video>';
    }

    return "<p>No hay vista previa disponible</p>";
}
?>
