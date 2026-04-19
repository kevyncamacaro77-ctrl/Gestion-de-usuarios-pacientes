<div class="main-content">
    <div class="container-fluid">
        <div class="header-body">
            <h1 class="dashboard-title">Panel de Control: Administrador</h1>
            <p class="text-muted">Bienvenido de nuevo, <?php echo $_SESSION['usuario']; ?>. Aquí tienes el resumen de la clínica.</p>
        </div>

        <div class="row-stats">
            <div class="stat-card">
                <div class="stat-icon blue">👥</div>
                <div class="stat-info">
                    <h3>1,250</h3>
                    <p>Pacientes Totales</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">📅</div>
                <div class="stat-info">
                    <h3>48</h3>
                    <p>Citas para Hoy</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">👨‍⚕️</div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Médicos Activos</p>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card-section">
                <h3>Acciones Rápidas</h3>
                <div class="btn-group-vertical">
                    <a href="index.php?view=gestionar_usuarios" class="btn-action">⚙️ Gestionar Usuarios</a>
                    <a href="index.php?view=reportes" class="btn-action">📊 Ver Reportes Globales</a>
                </div>
            </div>
            <div class="card-section">
                <h3>Próximas Citas</h3>
                <p>No hay citas recientes que mostrar.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-title { font-weight: 700; color: #2d3436; margin-top: 20px; }
    .row-stats { display: flex; gap: 20px; margin-bottom: 30px; margin-top: 20px; }
    .stat-card { background: white; padding: 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #edf2f7; }
    .stat-icon { font-size: 2rem; padding: 10px; border-radius: 12px; }
    .stat-icon.blue { background: #e3f2fd; }
    .stat-icon.green { background: #e8f5e9; }
    .stat-icon.purple { background: #f3e5f5; }
    .stat-info h3 { margin: 0; font-size: 1.5rem; color: #2d3436; }
    .stat-info p { margin: 0; color: #636e72; font-size: 0.9rem; }
    .dashboard-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; }
    .card-section { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .btn-action { display: block; padding: 12px; background: #f8f9fa; border: 1px solid #dee2e6; margin-bottom: 10px; border-radius: 8px; text-decoration: none; color: #2d3436; transition: 0.2s; }
    .btn-action:hover { background: #e9ecef; }
</style>