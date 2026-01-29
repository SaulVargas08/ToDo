<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor ToDo</title>
    <style>
        :root {
            --bg: #0b1020;
            --panel: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.12);
            --text: #e7edf7;
            --muted: #9fb3c8;
            --accent: #4ade80;
            --accent-2: #60a5fa;
            --danger: #f87171;
            --shadow: 0 20px 60px rgba(0,0,0,0.35);
        }
        * { box-sizing: border-box; }
        body { margin:0; font-family: "Inter","Segoe UI",system-ui,sans-serif; background: #0b1020; color: var(--text); }
        .wrapper { max-width: 1220px; margin: 0 auto; padding: 32px 24px 64px; }
        header { display:flex; justify-content: space-between; align-items:center; gap:12px; margin-bottom:20px; }
        h1 { margin:0; letter-spacing:-0.02em; }
        a.btn, button {
            text-decoration:none;
            color:#0a0f1d;
            background:linear-gradient(120deg,var(--accent),var(--accent-2));
            padding:10px 14px;
            border-radius:12px;
            font-weight:700;
            box-shadow:var(--shadow);
            border:none;
            cursor:pointer;
        }
        button.secondary { background: var(--panel); color: var(--text); border:1px solid var(--border); box-shadow:none; }
        .status { margin-bottom:12px; color: var(--muted); min-height:20px; }
        .grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap:16px; }
        .panel { background: var(--panel); border:1px solid var(--border); border-radius:16px; padding:16px; box-shadow:var(--shadow); }
        .panel h2 { margin:0 0 10px; font-size:18px; }
        form { display:flex; flex-direction:column; gap:10px; }
        label { display:flex; flex-direction:column; gap:4px; font-size:13px; color:var(--muted); }
        input, select, textarea {
            background: rgba(255,255,255,0.05);
            border:1px solid var(--border);
            border-radius:10px;
            padding:10px;
            color: var(--text);
            font-size:14px;
        }
        textarea { resize: vertical; min-height: 60px; }
        small { color: var(--muted); }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Gestor ToDo</h1>
            <div style="display:flex; gap:8px; align-items:center;">
                <a class="btn" href="/">Volver al dashboard</a>
                <button id="refresh" class="secondary" type="button">Refrescar listados</button>
            </div>
        </header>
        <div class="status" id="status">Crea, edita o borra; usa el dashboard para ver.</div>

        <div class="grid">
            <div class="panel">
                <h2>Proyecto - Crear</h2>
                <form id="formProjectCreate">
                    <label>Nombre<input name="name" required></label>
                    <label>Descripci&oacute;n<textarea name="description"></textarea></label>
                    <label>Estado
                        <select name="status" required>
                            <option value="activo">Activo</option>
                            <option value="pausado">Pausado</option>
                            <option value="completado">Completado</option>
                        </select>
                    </label>
                    <label>Inicio<input type="date" name="start_date"></label>
                    <label>Fin<input type="date" name="end_date" required></label>
                    <button type="submit">Crear proyecto</button>
                </form>
            </div>
            <div class="panel">
                <h2>Proyecto - Editar / Eliminar</h2>
                <form id="formProjectUpdate">
                    <label>ID<input name="id" required></label>
                    <label>Nombre<input name="name" required></label>
                    <label>Descripci&oacute;n<textarea name="description" required></textarea></label>
                    <label>Estado
                        <select name="status" required>
                            <option value="activo">Activo</option>
                            <option value="pausado">Pausado</option>
                            <option value="completado">Completado</option>
                        </select>
                    </label>
                    <label>Inicio<input type="date" name="start_date"></label>
                    <label>Fin<input type="date" name="end_date"></label>
                    <button type="submit">Actualizar proyecto</button>
                </form>
                <form id="formProjectDelete">
                    <label>ID a eliminar<input name="id" required></label>
                    <button type="submit" class="secondary">Eliminar proyecto</button>
                </form>
            </div>
            <div class="panel">
                <h2>Tarea - Crear</h2>
                <form id="formTaskCreate">
                    <label>Proyecto ID<input name="project_id" required></label>
                    <label>Nombre<input name="name" required></label>
                    <label>Descripci&oacute;n<textarea name="description"></textarea></label>
                    <label>Estado
                        <select name="status" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="en progreso">En progreso</option>
                            <option value="completada">Completada</option>
                        </select>
                    </label>
                    <label>Prioridad
                        <select name="priority" required>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </label>
                    <label>Vence (fecha y hora)<input type="datetime-local" name="due_date"></label>
                    <button type="submit">Crear tarea</button>
                </form>
            </div>
            <div class="panel">
                <h2>Tarea - Editar / Eliminar</h2>
                <form id="formTaskUpdate">
                    <label>ID<input name="id" required></label>
                    <label>Nombre<input name="name"></label>
                    <label>Descripci&oacute;n<textarea name="description"></textarea></label>
                    <label>Estado
                        <select name="status">
                            <option value="">(mantener)</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en progreso">En progreso</option>
                            <option value="completada">Completada</option>
                        </select>
                    </label>
                    <label>Prioridad
                        <select name="priority">
                            <option value="">(mantener)</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </label>
                    <label>Vence (fecha y hora)<input type="datetime-local" name="due_date"></label>
                    <button type="submit">Actualizar tarea</button>
                </form>
                <form id="formTaskDelete">
                    <label>ID a eliminar<input name="id" required></label>
                    <button type="submit" class="secondary">Eliminar tarea</button>
                </form>
            </div>
            <div class="panel">
                <h2>Subtarea - Crear</h2>
                <form id="formSubtaskCreate">
                    <label>Tarea ID<input name="task_id" required></label>
                    <label>Nombre<input name="name" required></label>
                    <label>Estado
                        <select name="status" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="completada">Completada</option>
                        </select>
                    </label>
                    <button type="submit">Crear subtarea</button>
                </form>
            </div>
            <div class="panel">
                <h2>Subtarea - Editar / Eliminar</h2>
                <form id="formSubtaskUpdate">
                    <label>ID<input name="id" required></label>
                    <label>Tarea ID<input name="task_id"></label>
                    <label>Nombre<input name="name"></label>
                    <label>Estado
                        <select name="status">
                            <option value="">(mantener)</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="completada">Completada</option>
                        </select>
                    </label>
                    <button type="submit">Actualizar subtarea</button>
                </form>
                <form id="formSubtaskDelete">
                    <label>ID a eliminar<input name="id" required></label>
                    <button type="submit" class="secondary">Eliminar subtarea</button>
                </form>
            </div>
            <div class="panel">
                <h2>Etiqueta - Crear</h2>
                <form id="formTagCreate">
                    <label>Nombre<input name="name" required></label>
                    <small>La API actual no expone borrar/editar etiquetas.</small>
                    <button type="submit">Crear etiqueta</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const statusEl = document.getElementById('status');
        const refreshBtn = document.getElementById('refresh');

        const apiRequest = async (method, url, payload) => {
            statusEl.textContent = 'Procesando...';
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: payload ? JSON.stringify(payload) : undefined,
            });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const msg = data.message || JSON.stringify(data) || `HTTP ${res.status}`;
                throw new Error(msg);
            }
            return data;
        };

        const dateToUnix = (value) => {
            if (!value) return null;
            const ts = Date.parse(value);
            return isNaN(ts) ? null : Math.floor(ts / 1000);
        };

        // Proyectos
        document.getElementById('formProjectCreate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            try {
                await apiRequest('POST', '/api/projects', Object.fromEntries(fd.entries()));
                statusEl.textContent = 'Proyecto creado';
                e.target.reset();
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formProjectUpdate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const id = fd.get('id');
            const payload = Object.fromEntries(fd.entries());
            delete payload.id;
            try {
                await apiRequest('PUT', `/api/projects/${id}`, payload);
                statusEl.textContent = 'Proyecto actualizado';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formProjectDelete').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = new FormData(e.target).get('id');
            if (!id) return;
            try {
                await apiRequest('DELETE', `/api/projects/${id}`);
                statusEl.textContent = 'Proyecto eliminado';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        // Tareas
        document.getElementById('formTaskCreate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const payload = Object.fromEntries(fd.entries());
            const due = dateToUnix(fd.get('due_date'));
            if (due) payload.due_date = due;
            else delete payload.due_date;
            try {
                await apiRequest('POST', '/api/tasks', payload);
                statusEl.textContent = 'Tarea creada';
                e.target.reset();
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formTaskUpdate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const id = fd.get('id');
            const payload = {};
            ['name','description','status','priority'].forEach(key => {
                const val = fd.get(key);
                if (val) payload[key] = val;
            });
            const due = fd.get('due_date');
            if (due) payload.due_date = new Date(due).toISOString();
            try {
                await apiRequest('PUT', `/api/tasks/${id}`, payload);
                statusEl.textContent = 'Tarea actualizada';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formTaskDelete').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = new FormData(e.target).get('id');
            try {
                await apiRequest('DELETE', `/api/tasks/${id}`);
                statusEl.textContent = 'Tarea eliminada';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        // Subtareas
        document.getElementById('formSubtaskCreate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const payload = Object.fromEntries(fd.entries());
            try {
                await apiRequest('POST', '/api/subtasks', payload);
                statusEl.textContent = 'Subtarea creada';
                e.target.reset();
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formSubtaskUpdate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const id = fd.get('id');
            const payload = {};
            ['task_id','name','status'].forEach(key => {
                const val = fd.get(key);
                if (val) payload[key] = val;
            });
            try {
                await apiRequest('PUT', `/api/subtasks/${id}`, payload);
                statusEl.textContent = 'Subtarea actualizada';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        document.getElementById('formSubtaskDelete').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = new FormData(e.target).get('id');
            try {
                await apiRequest('DELETE', `/api/subtasks/${id}`);
                statusEl.textContent = 'Subtarea eliminada';
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        // Etiquetas (solo crear)
        document.getElementById('formTagCreate').addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(e.target).entries());
            try {
                await apiRequest('POST', '/api/tags', payload);
                statusEl.textContent = 'Etiqueta creada';
                e.target.reset();
            } catch (err) {
                statusEl.textContent = err.message;
            }
        });

        refreshBtn.addEventListener('click', () => {
            statusEl.textContent = 'Refresca en el dashboard para ver los cambios.';
        });
    </script>
</body>
</html>
