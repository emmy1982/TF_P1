// Función para cambiar entre pestañas
function openTab(evt, tabName) {
    // Ocultar todos los contenidos de pestañas
    var tabContents = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
    }
    
    // Remover la clase "active" de todos los botones
    var tabButtons = document.getElementsByClassName("tab-btn");
    for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(" active", "");
    }
    
    // Mostrar la pestaña actual y agregar clase "active" al botón
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Mostrar la primera pestaña por defecto
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("tab-info").style.display = "block";
}); 