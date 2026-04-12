function abrirModal() {
    const modal = document.getElementById('modalAgendar');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function cerrarModal() {
    const modal = document.getElementById('modalAgendar');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Cerrar al hacer clic fuera
window.onclick = function(event) {
    let modal = document.getElementById('modalAgendar');
    if (event.target == modal) {
        cerrarModal();
    }
}