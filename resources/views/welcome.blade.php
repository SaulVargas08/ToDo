<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo Dashboard</title>
    <style>
        :root {
            --bg: #0b1020;
            --panel: rgba(255, 255, 255, 0.04);
            --panel-strong: rgba(255, 255, 255, 0.07);
            --text: #e7edf7;
            --muted: #9fb3c8;
            --accent: #4ade80;
            --accent-2: #60a5fa;
            --danger: #f87171;
            --border: rgba(255, 255, 255, 0.12);
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at 15% 20%, #1b2a55 0%, #0b1020 35%, #060913 80%);
            color: var(--text);
            min-height: 100vh;
        }
        .wrapper {
            width: 100%;
            margin: 0;
            padding: 24px 18px 48px 0;
        }
        .layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 16px;
        }
        .sidebar {
            height: fit-content;
            position: sticky;
            top: 24px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .title { display: flex; flex-direction: column; gap: 6px; }
        .title h1 { margin: 0; font-size: 28px; letter-spacing: -0.02em; }
        .title p { margin: 0; color: var(--muted); }
        .actions { display: flex; gap: 10px; }
        button {
            background: linear-gradient(120deg, var(--accent) 0%, var(--accent-2) 100%);
            color: #0a0f1d;
            border: none;
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: transform 120ms ease, box-shadow 120ms ease;
        }
        button.secondary {
            background: var(--panel);
            color: var(--text);
            border: 1px solid var(--border);
            box-shadow: none;
        }
        button:hover { transform: translateY(-1px); box-shadow: 0 10px 30px rgba(76, 226, 130, 0.25); }
        button.secondary:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }
        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(4px);
        }
        .panel h2 { margin: 0 0 8px; font-size: 18px; display: flex; align-items: center; gap: 8px; }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 10px;
            background: var(--panel-strong);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 13px;
        }
        .list { display: flex; flex-direction: column; gap: 10px; margin-top: 10px; }
        .item {
            border-radius: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
        }
        .item h3 { margin: 0 0 6px; font-size: 16px; }
        .meta { display: flex; flex-wrap: wrap; gap: 8px; color: var(--muted); font-size: 13px; }
        .muted { color: var(--muted); }
        .danger { color: var(--danger); }
        .success { color: var(--accent); }
        .warning { color: #fbbf24; }
        .hero {
            margin-bottom: 22px;
            padding: 20px;
            background: linear-gradient(140deg, rgba(76, 226, 130, 0.15), rgba(96, 165, 250, 0.08));
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }
        .hero p { margin: 6px 0 0; color: var(--muted); }
        .status-bar { margin-top: 12px; display: flex; gap: 12px; flex-wrap: wrap; color: var(--muted); font-size: 13px; }
        .chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .chip {
            padding: 6px 10px;
            border-radius: 999px;
            background: var(--panel-strong);
            border: 1px solid var(--border);
            font-size: 12px;
        }
        .empty { border: 1px dashed var(--border); border-radius: 12px; padding: 12px; color: var(--muted); text-align: center; }
        footer { margin-top: 26px; color: var(--muted); font-size: 13px; text-align: center; }
        @media (max-width: 640px) {
            header { flex-direction: column; align-items: flex-start; }
            .actions { width: 100%; }
            .actions button { width: 50%; }
            .layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="layout">
            <aside class="sidebar">
                <div class="panel">
                    <h2>Panel</h2>
                    <div class="list">
                        <a href="/manager" style="text-decoration:none;">
                            <button type="button" class="secondary" style="width:100%;">Gestor general</button>
                        </a>
                        <a href="/projects-module" style="text-decoration:none;">
                            <button type="button" class="secondary" style="width:100%;">Módulo proyectos</button>
                        </a>
                        <a href="/tasks-module" style="text-decoration:none;">
                            <button type="button" class="secondary" style="width:100%;">Módulo tareas</button>
                        </a>
                        <a href="/subtasks-module" style="text-decoration:none;">
                            <button type="button" class="secondary" style="width:100%;">Módulo subtareas</button>
                        </a>
                        <a href="/tags-module" style="text-decoration:none;">
                            <button type="button" class="secondary" style="width:100%;">Módulo etiquetas</button>
                        </a>
                    </div>
                </div>
            </aside>
            <main>
                <header>
                    <div class="title">
                        <h1>ToDo API Dashboard</h1>
                        <p id="headline">Listando proyectos, tareas, subtareas y etiquetas desde tus endpoints.</p>
                    </div>
                    <div class="actions">
                        <button id="refresh">Refrescar datos</button>
                    </div>
                </header>

                <section class="hero">
                    <strong>Estado del backend</strong>
                    <div class="status-bar">
                        <span id="statusText">Consultando...</span>
                        <span id="lastUpdate" class="muted"></span>
                        <span id="errorText" class="danger"></span>
                    </div>
                    <div class="chips">
                        <span class="chip" id="projectsCount">Proyectos: 0</span>
                        <span class="chip" id="tasksCount">Tareas: 0</span>
                        <span class="chip" id="subtasksCount">Subtareas: 0</span>
                        <span class="chip" id="tagsCount">Etiquetas: 0</span>
                    </div>
                </section>

                <div class="grid">
                    <div class="panel">
                        <h2>Proyectos <span class="pill" id="projectsPill">0 activos</span></h2>
                        <div class="list" id="projectsList"></div>
                    </div>
                    <div class="panel">
                        <h2>Tareas <span class="pill" id="tasksPill">0 pendientes</span></h2>
                        <div class="list" id="tasksList"></div>
                    </div>
                    <div class="panel">
                        <h2>Subtareas <span class="pill" id="subtasksPill">0</span></h2>
                        <div class="list" id="subtasksList"></div>
                    </div>
                    <div class="panel">
                        <h2>Etiquetas <span class="pill" id="tagsPill">0</span></h2>
                        <div class="list" id="tagsList"></div>
                    </div>
                </div>

                <footer>
                    Esta vista usa la API local: /api/projects, /api/tasks, /api/subtasks, /api/tags. Usa "Refrescar" tras crear/editar/borrar.
                </footer>
            </main>
        </div>
    </div>

    <script>
        const endpoints = {
            projects: { url: '/api/projects', extract: data => data.projects || [] },
            tasks: { url: '/api/tasks', extract: data => data.tasks || [] },
            subtasks: { url: '/api/subtasks', extract: data => Array.isArray(data) ? data : (data.subtasks || []) },
            tags: { url: '/api/tags', extract: data => Array.isArray(data) ? data : (data.tags || []) },
        };

        const els = {
            status: document.getElementById('statusText'),
            lastUpdate: document.getElementById('lastUpdate'),
            error: document.getElementById('errorText'),
            projectsList: document.getElementById('projectsList'),
            tasksList: document.getElementById('tasksList'),
            subtasksList: document.getElementById('subtasksList'),
            tagsList: document.getElementById('tagsList'),
            projectsCount: document.getElementById('projectsCount'),
            tasksCount: document.getElementById('tasksCount'),
            subtasksCount: document.getElementById('subtasksCount'),
            tagsCount: document.getElementById('tagsCount'),
            projectsPill: document.getElementById('projectsPill'),
            tasksPill: document.getElementById('tasksPill'),
            subtasksPill: document.getElementById('subtasksPill'),
            tagsPill: document.getElementById('tagsPill'),
            refresh: document.getElementById('refresh'),
        };

        const badgeByStatus = (status = '') => {
            const normalized = status.toLowerCase();
            if (['activo', 'en progreso', 'completada', 'completado'].includes(normalized)) return 'success';
            if (['pausado', 'pendiente'].includes(normalized)) return 'warning';
            if (['cancelado'].includes(normalized)) return 'danger';
            return 'muted';
        };

        const formatDate = (value) => {
            if (!value) return 'Sin fecha';
            const date = new Date(value);
            return isNaN(date.getTime()) ? value : date.toLocaleDateString();
        };

        async function fetchData() {
            els.status.textContent = 'Cargando datos...';
            els.error.textContent = '';
            try {
                const [projects, tasks, subtasks, tags] = await Promise.all([
                    query('projects'),
                    query('tasks'),
                    query('subtasks'),
                    query('tags'),
                ]);

                renderProjects(projects);
                renderTasks(tasks);
                renderSubtasks(subtasks);
                renderTags(tags);

                els.status.textContent = 'Datos cargados correctamente.';
                els.lastUpdate.textContent = `Actualizado: ${new Date().toLocaleTimeString()}`;
            } catch (error) {
                els.status.textContent = 'No se pudo cargar todo.';
                els.error.textContent = error.message || 'Error desconocido';
            }
        }

        async function query(key) {
            const { url, extract } = endpoints[key];
            const res = await fetch(url);
            if (!res.ok) throw new Error(`Error en ${url}: ${res.status}`);
            const data = await res.json();
            const items = extract(data) || [];
            if (!Array.isArray(items)) return [];
            return items;
        }

        function renderProjects(projects) {
            setCounts('projects', projects.length);
            els.projectsPill.textContent = `${projects.length} totales`;
            if (!projects.length) {
                els.projectsList.innerHTML = emptyBlock('No hay proyectos');
                return;
            }
            els.projectsList.innerHTML = projects.map(p => `
                <div class="item">
                    <h3>${p.name || 'Sin nombre'}</h3>
                    <div class="meta">
                        <span class="${badgeByStatus(p.status)}">${p.status || 'sin estado'}</span>
                        <span>Inicio: ${formatDate(p.start_date)}</span>
                        <span>Fin: ${formatDate(p.end_date)}</span>
                    </div>
                    <p class="muted">${p.description || 'Sin descripcion'}</p>
                </div>
            `).join('');
        }

        function renderTasks(tasks) {
            setCounts('tasks', tasks.length);
            const pending = tasks.filter(t => (t.status || '').toLowerCase() !== 'completada').length;
            els.tasksPill.textContent = `${pending} pendientes`;
            if (!tasks.length) {
                els.tasksList.innerHTML = emptyBlock('No hay tareas');
                return;
            }
            els.tasksList.innerHTML = tasks.map(t => `
                <div class="item">
                    <h3>${t.name || 'Sin nombre'}</h3>
                    <div class="meta">
                        <span class="${badgeByStatus(t.status)}">${t.status || 'sin estado'}</span>
                        <span>Prioridad: ${t.priority || 'sin prioridad'}</span>
                        <span>Vence: ${formatDate(t.due_date)}</span>
                        ${t.project_id ? `<span>Proyecto #${t.project_id}</span>` : ''}
                    </div>
                    <p class="muted">${t.description || 'Sin descripcion'}</p>
                </div>
            `).join('');
        }

        function renderSubtasks(subtasks) {
            setCounts('subtasks', subtasks.length);
            els.subtasksPill.textContent = `${subtasks.length} registradas`;
            if (!subtasks.length) {
                els.subtasksList.innerHTML = emptyBlock('No hay subtareas');
                return;
            }
            els.subtasksList.innerHTML = subtasks.map(s => `
                <div class="item">
                    <h3>${s.name || 'Sin nombre'}</h3>
                    <div class="meta">
                        <span class="${badgeByStatus(s.status)}">${s.status || 'sin estado'}</span>
                        ${s.task_id ? `<span>Tarea #${s.task_id}</span>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function renderTags(tags) {
            setCounts('tags', tags.length);
            els.tagsPill.textContent = `${tags.length} disponibles`;
            if (!tags.length) {
                els.tagsList.innerHTML = emptyBlock('No hay etiquetas');
                return;
            }
            els.tagsList.innerHTML = tags.map(tag => `
                <div class="item">
                    <h3>${tag.name || 'Sin nombre'}</h3>
                    <div class="meta">
                        <span>ID: ${tag.id ?? '-'}</span>
                        ${tag.created_at ? `<span>Creada: ${formatDate(tag.created_at)}</span>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function setCounts(key, count) {
            const map = {
                projects: els.projectsCount,
                tasks: els.tasksCount,
                subtasks: els.subtasksCount,
                tags: els.tagsCount,
            };
            if (map[key]) map[key].textContent = `${map[key].textContent.split(':')[0]}: ${count}`;
        }

        function emptyBlock(text) {
            return `<div class="empty">${text}</div>`;
        }

        els.refresh.addEventListener('click', fetchData);

        fetchData();
    </script>
</body>
</html>
