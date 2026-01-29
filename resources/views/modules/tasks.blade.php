<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Tareas</title>
    <style>
        :root { --bg:#0b1020; --panel:rgba(255,255,255,0.05); --border:rgba(255,255,255,0.12); --text:#e7edf7; --muted:#9fb3c8; --accent:#4ade80; --accent-2:#60a5fa; --shadow:0 20px 60px rgba(0,0,0,0.35); }
        *{box-sizing:border-box;}
        body{margin:0;font-family:"Inter","Segoe UI",system-ui,sans-serif;background:var(--bg);color:var(--text);}
        .wrapper{max-width:900px;margin:0 auto;padding:32px 20px 60px;}
        header{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:18px;}
        h1{margin:0;letter-spacing:-0.02em;}
        a.btn,button{background:linear-gradient(120deg,var(--accent),var(--accent-2));color:#0a0f1d;text-decoration:none;border:none;border-radius:12px;padding:10px 14px;font-weight:700;box-shadow:var(--shadow);cursor:pointer;}
        button.secondary{background:var(--panel);color:var(--text);border:1px solid var(--border);box-shadow:none;}
        .panel{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:16px;box-shadow:var(--shadow);}
        form{display:flex;flex-direction:column;gap:10px;}
        label{display:flex;flex-direction:column;gap:4px;font-size:13px;color:var(--muted);}
        input,select,textarea{background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:10px;padding:10px;color:var(--text);}
        textarea{min-height:70px;resize:vertical;}
        .status{margin-bottom:12px;color:var(--muted);min-height:18px;}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;}
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Tareas</h1>
            <div style="display:flex;gap:8px;">
                <a class="btn" href="/">Dashboard</a>
                <a class="btn secondary" href="/manager" style="color:var(--text);">Gestor general</a>
            </div>
        </header>
        <div class="status" id="status">Crea, actualiza o elimina tareas.</div>
        <div class="grid">
            <div class="panel">
                <h2>Crear</h2>
                <form id="formCreate">
                    <label>Proyecto ID<input name="project_id" required></label>
                    <label>Nombre<input name="name" required></label>
                    <label>Descripción<textarea name="description"></textarea></label>
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
                <h2>Editar / Eliminar</h2>
                <form id="formUpdate">
                    <label>ID<input name="id" required></label>
                    <label>Nombre<input name="name"></label>
                    <label>Descripción<textarea name="description"></textarea></label>
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
                    <button type="submit">Actualizar</button>
                </form>
                <form id="formDelete" style="margin-top:12px;">
                    <label>ID a eliminar<input name="id" required></label>
                    <button type="submit" class="secondary">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const statusEl = document.getElementById('status');
        const apiRequest = async (method, url, payload) => {
            statusEl.textContent = 'Procesando...';
            const res = await fetch(url, {
                method,
                headers: {'Content-Type':'application/json','Accept':'application/json'},
                body: payload ? JSON.stringify(payload) : undefined,
            });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(data.message || JSON.stringify(data) || `HTTP ${res.status}`);
            return data;
        };
        const dateToUnix = (value) => {
            if (!value) return null;
            const ts = Date.parse(value);
            return isNaN(ts) ? null : Math.floor(ts/1000);
        };
        document.getElementById('formCreate').addEventListener('submit', async (e)=>{
            e.preventDefault();
            const fd=new FormData(e.target);
            const payload=Object.fromEntries(fd.entries());
            const due=dateToUnix(fd.get('due_date')); if(due) payload.due_date=due; else delete payload.due_date;
            try{ await apiRequest('POST','/api/tasks',payload); statusEl.textContent='Tarea creada'; e.target.reset(); }
            catch(err){ statusEl.textContent=err.message; }
        });
        document.getElementById('formUpdate').addEventListener('submit', async (e)=>{
            e.preventDefault();
            const fd=new FormData(e.target); const id=fd.get('id'); const payload={};
            ['name','description','status','priority'].forEach(k=>{const v=fd.get(k); if(v) payload[k]=v;});
            const due=fd.get('due_date'); if(due) payload.due_date=new Date(due).toISOString();
            try{ await apiRequest('PUT',`/api/tasks/${id}`,payload); statusEl.textContent='Tarea actualizada'; }
            catch(err){ statusEl.textContent=err.message; }
        });
        document.getElementById('formDelete').addEventListener('submit', async (e)=>{
            e.preventDefault();
            const id=new FormData(e.target).get('id');
            try{ await apiRequest('DELETE',`/api/tasks/${id}`); statusEl.textContent='Tarea eliminada'; }
            catch(err){ statusEl.textContent=err.message; }
        });
    </script>
</body>
</html>
