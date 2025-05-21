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

// Función para confirmar eliminación de cita
function confirmarEliminar(idCita) {
    if (confirm("¿Estás seguro de que deseas eliminar esta cita?")) {
        document.getElementById("deleteIdCita").value = idCita;
        document.getElementById("deleteForm").submit();
    }
}

// Inicialización de pestañas
document.addEventListener("DOMContentLoaded", function() {
    // Verificar si hay una cita para editar
    const editCita = document.querySelector('input[name="id_cita"]');
    if (editCita) {
        openTab({currentTarget: document.getElementsByClassName("tab-btn")[1]}, "tab-create");
    } else {
        document.getElementById("tab-list").style.display = "block";
    }
}); 