<div class="content-wrapper">
    <div class="header-section">
        <h2>📝 Registro de Nuevo Paciente</h2>
        <p>Complete la información personal y la ficha médica inicial.</p>
    </div>

    <form action="index.php?view=registrar_paciente" method="POST" class="card-futuristic">
        
        <h3 class="section-title">1. Información Personal</h3>
        <div class="grid-form">
            <div class="form-group">
                <label>Cédula:</label>
                <input type="text" name="cedula" required>
            </div>
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div class="form-group">
                <label>Nombre de Usuario (Para el portal):</label>
                <input type="text" name="nombre_usuario" required placeholder="Ej: jperez01">
            </div>
        </div>

        <div class="grid-form">
            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="correo">
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono">
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Dirección de Habitación:</label>
                <input type="text" name="direccion">
            </div>
        </div>

        <hr>

        <h3 class="section-title">2. Antecedentes Médicos</h3>
        <div class="grid-form">
            <div class="form-group">
                <label>Tipo de Sangre:</label>
                <select name="tipo_sangre">
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="AB+">AB+</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alergias:</label>
                <input type="text" name="alergias" placeholder="Medicamentos, alimentos, etc.">
            </div>
        </div>

        <div class="form-group">
            <label>Antecedentes Personales:</label>
            <textarea name="antecedentes_personales" rows="2"></textarea>
        </div>

        <div class="form-group">
            <label>Hábitos Psicobiológicos (Fumador, Alcohol, Dieta):</label>
            <textarea name="habitos_psicobiologicos" rows="2"></textarea>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <button type="submit" name="btn_registrar" class="btn-clinico">Guardar Paciente y Ficha Médica</button>
        </div>
    </form>
</div>

<style>
    .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
    .section-title { color: var(--primary-blue); border-bottom: 2px solid #f0f0f0; padding-bottom: 5px; margin-bottom: 15px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
    input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
</style>