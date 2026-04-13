/**
 * Manejo de Modal para Agendar Citas
 * Clínica Adventista - Gestión Oftalmológica
 */

function abrirModal() {
    const modal = document.getElementById('modalAgendar');
    if (modal) {
        modal.style.display = 'flex';
        // Evita que el scroll del body se mueva mientras el modal está abierto
        document.body.style.overflow = 'hidden';
    }
}

function cerrarModal() {
    const modal = document.getElementById('modalAgendar');
    if (modal) {
        modal.style.display = 'none';
        // Restaura el scroll del body
        document.body.style.overflow = 'auto';
    }
}

// Cerrar al hacer clic fuera del contenido del modal (en el área oscura)
window.onclick = function(event) {
    const modal = document.getElementById('modalAgendar');
    if (event.target == modal) {
        cerrarModal();
    }
}

// Escuchar la tecla "Escape" para cerrar el modal por accesibilidad
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        cerrarModal();
    }
});

function cargarMedicos(idEspecialidad) {
    const selectMedico = document.getElementById('selectMedico');
    const selectCupo = document.getElementById('selectCupo');
    
    // Limpiar turnos al cambiar especialidad
    selectCupo.disabled = true;
    selectCupo.innerHTML = '<option value="">Seleccione médico primero...</option>';

    if (!idEspecialidad) {
        selectMedico.disabled = true;
        selectMedico.innerHTML = '<option value="">Primero elija especialidad...</option>';
        return;
    }

    selectMedico.disabled = true;
    selectMedico.innerHTML = '<option value="">Cargando médicos...</option>';

    fetch(`index.php?action=getMedicosPorEspecialidad&id=${idEspecialidad}`)
        .then(response => {
            if (!response.ok) throw new Error('Error en el servidor');
            return response.json();
        })
        .then(data => {
            selectMedico.innerHTML = '<option value="">Seleccione un médico...</option>';
            if (data && data.length > 0) {
                selectMedico.disabled = false;
                data.forEach(medico => {
                    selectMedico.innerHTML += `<option value="${medico.idmedico}">${medico.nombre}</option>`;
                });
            } else {
                // AQUÍ CORREGIMOS EL MENSAJE
                selectMedico.innerHTML = '<option value="">No hay médicos con disponibilidad actual</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectMedico.innerHTML = '<option value="">Sin conexión con el sistema</option>';
        });
}

function cargarHorarios(idMedico) {
    const selectCupo = document.getElementById('selectCupo');
    
    if (!idMedico) {
        selectCupo.disabled = true;
        selectCupo.innerHTML = '<option value="">Primero elija un médico...</option>';
        return;
    }

    selectCupo.disabled = true;
    selectCupo.innerHTML = '<option value="">Buscando cupos...</option>';

    // Esta acción debe existir en tu index.php y controlador
    fetch(`index.php?action=getHorariosDisponibles&id_medico=${idMedico}`)
        .then(response => response.json())
        .then(data => {
            selectCupo.innerHTML = '';
            if (data && data.length > 0) {
                selectCupo.disabled = false;
                selectCupo.innerHTML = '<option value="">Seleccione un turno...</option>';
                data.forEach(horario => {
                    // Formateamos para que el paciente vea: "Lunes 15/04 - 08:00 AM"
                    selectCupo.innerHTML += `<option value="${horario.id_disponibilidad}">
                        ${horario.dia} ${horario.fecha} - ${horario.hora_inicio}
                    </option>`;
                });
            } else {
                selectCupo.innerHTML = '<option value="">Sin turnos disponibles por ahora</option>';
            }
        });
}