<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstPartido - Gestión de Delegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body * { visibility: hidden; }
            #seccion-acta-imprimir, #seccion-acta-imprimir *,
            #seccion-informe-vivo-imprimir, #seccion-informe-vivo-imprimir * { visibility: visible; }
            #seccion-acta-imprimir, #seccion-informe-vivo-imprimir { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- CABECERA -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30 px-4 py-3 flex justify-between items-center shadow-sm no-print">
        <div class="flex items-center space-x-2 cursor-pointer" onclick="cerrarSesion()">
            <i class="fa-solid fa-futbol text-green-600 text-2xl"></i>
            <span class="font-bold text-xl text-gray-800">EstPartido</span>
        </div>
        
        <div class="flex items-center gap-2">
            <button id="btnVolver" onclick="volverAtras()" class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs px-3 py-1.5 rounded-lg flex items-center gap-1 font-semibold transition">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </button>
            <button id="btnPerfil" onclick="abrirModalPassword()" class="hidden bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs px-2.5 py-1.5 rounded-lg flex items-center gap-1 font-semibold transition border border-gray-300">
                <i class="fa-solid fa-key text-amber-600"></i> Mi Clave
            </button>
            <button id="btnCerrarSesion" onclick="cerrarSesion()" class="hidden text-xs text-red-600 font-semibold hover:underline ml-2">
                Cerrar sesión
            </button>
        </div>
    </header>

    <main class="max-w-xl mx-auto w-full p-4 flex-1 flex flex-col justify-center relative">

        <!-- MODAL CAMBIO CONTRASEÑA -->
        <div id="modalCambiarPassword" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 no-print">
            <div class="bg-white p-5 rounded-2xl shadow-xl border border-gray-200 w-full max-w-sm space-y-4">
                <div class="flex justify-between items-center border-b pb-2">
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        <i class="fa-solid fa-key text-amber-500"></i> Cambiar mi contraseña
                    </h3>
                    <button onclick="cerrarModalPassword()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                
                <form onsubmit="actualizarPassword(event)" class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Contraseña actual</label>
                        <input type="password" id="passActual" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nueva contraseña</label>
                        <input type="password" id="passNueva" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Confirmar nueva contraseña</label>
                        <input type="password" id="passConfirm" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-2 rounded-lg text-xs hover:bg-green-700">Guardar</button>
                        <button type="button" onclick="cerrarModalPassword()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-xs font-semibold">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDITAR JUGADORES -->
        <div id="modalEditarJugador" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 no-print">
            <div class="bg-white p-5 rounded-2xl shadow-xl border border-gray-200 w-full max-w-sm space-y-4">
                <div class="flex justify-between items-center border-b pb-2">
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-indigo-600"></i> Editar Jugador
                    </h3>
                    <button onclick="cerrarModalEditarJugador()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                
                <form onsubmit="guardarEdicionJugador(event)" class="space-y-3">
                    <input type="hidden" id="editId">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre</label>
                        <input type="text" id="editNombre" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Apellidos</label>
                        <input type="text" id="editApellidos" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Dorsal</label>
                            <input type="number" id="editDorsal" required class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Posición</label>
                            <select id="editPosicion" class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                                <option value="Portero">Portero</option>
                                <option value="Defensa">Defensa</option>
                                <option value="Centrocampista">Centrocampista</option>
                                <option value="Delantero">Delantero</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado</label>
                        <select id="editEstado" class="w-full px-3 py-2 text-sm border rounded-lg bg-gray-50">
                            <option value="Disponible">Disponible</option>
                            <option value="Lesionado">Lesionado</option>
                            <option value="Sancionado">Sancionado</option>
                            <option value="Asuntos Propios">Asuntos Propios</option>
                        </select>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white font-bold py-2 rounded-lg text-xs hover:bg-indigo-700">Actualizar</button>
                        <button type="button" onclick="cerrarModalEditarJugador()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-xs font-semibold">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL REGISTRO / EDICIÓN DE EVENTO EN VIVO -->
        <div id="modalEventoVivo" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 no-print">
            <div class="bg-white p-5 rounded-2xl shadow-xl border border-gray-200 w-full max-w-sm space-y-3 text-xs">
                <div class="flex justify-between items-center border-b pb-2">
                    <h3 id="modalEventoTitulo" class="font-bold text-gray-900 text-sm">Registrar Evento</h3>
                    <button onclick="cerrarModalEvento()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <input type="hidden" id="modalTipoEvento">
                <input type="hidden" id="modalEventoEditId">

                <!-- MINUTO DE LA ACCIÓN -->
                <div>
                    <label class="block font-bold text-gray-600 uppercase text-[10px] mb-1">Minuto</label>
                    <input type="number" id="inputMinutoEvento" class="w-full p-2 border rounded-lg bg-gray-50 font-bold" min="0" max="130">
                </div>

                <!-- SELECTOR EQUIPO -->
                <div>
                    <label class="block font-bold text-gray-600 uppercase text-[10px] mb-1">Equipo</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" id="btnEqLocal" onclick="seleccionarEquipoEvento('local')" class="p-2 rounded-lg border font-bold text-center bg-slate-900 text-white">
                            Nuestro Equipo
                        </button>
                        <button type="button" id="btnEqVisitante" onclick="seleccionarEquipoEvento('visitante')" class="p-2 rounded-lg border font-bold text-center bg-gray-100 text-gray-700">
                            Rival
                        </button>
                    </div>
                </div>

                <!-- OPCIONES DE RESULTADO (Tiro / Córner) -->
                <div id="bloqueResultados" class="hidden">
                    <label class="block font-bold text-gray-600 uppercase text-[10px] mb-1">Resultado</label>
                    <div id="contenedorChipsResultados" class="flex flex-wrap gap-1.5"></div>
                </div>

                <!-- CAMBIO: JUGADOR QUE SALE (EN CAMPO) -->
                <div id="bloqueJugadorSale" class="hidden">
                    <label class="block font-bold text-red-600 uppercase text-[10px] mb-1">🔻 SALE (Actualmente en el campo)</label>
                    <select id="selectJugadorSale" class="w-full p-2 border border-red-300 rounded-lg bg-red-50 font-semibold text-red-900"></select>
                </div>

                <!-- JUGADORES NUESTRO EQUIPO (ENTRA / ACCIÓN PRINCIPAL) -->
                <div id="bloqueJugadorPrincipal">
                    <label id="labelJugadorPrincipal" class="block font-bold text-emerald-600 uppercase text-[10px] mb-1">🟢 ENTRA (En el banquillo)</label>
                    <select id="selectJugadorPrincipal" class="w-full p-2 border border-emerald-300 rounded-lg bg-emerald-50 font-semibold text-emerald-900"></select>
                </div>

                <!-- DORSAL JUGADOR RIVAL -->
                <div id="bloqueAvisoRival" class="hidden space-y-1">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">Dorsal / Nº del Jugador Rival (Opcional)</label>
                    <input type="number" id="inputDorsalRival" placeholder="Ej: 9" class="w-full p-2 border border-slate-300 rounded-lg bg-slate-50 font-bold text-slate-900">
                </div>

                <div class="flex gap-2 pt-3 border-t">
                    <button type="button" onclick="cerrarModalEvento()" class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg">Cancelar</button>
                    <button type="button" onclick="confirmarEvento()" class="flex-1 bg-emerald-600 text-white font-bold py-2 rounded-lg hover:bg-emerald-700">Guardar</button>
                </div>
            </div>
        </div>

        <!-- 1. VISTA LOGIN -->
        <section id="vista-login" class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm space-y-5 no-print">
            <div class="text-center space-y-1">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2 text-xl">
                    <i class="fa-solid fa-user-lock"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Iniciar Sesión</h1>
                <p class="text-xs text-gray-500">Panel del Delegado / Cuerpo Técnico</p>
            </div>

            <form onsubmit="iniciarSesion(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Usuario / Email</label>
                    <input type="text" id="inputUsuario" required placeholder="delegado" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-xl bg-gray-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Contraseña</label>
                    <input type="password" id="inputPassword" required placeholder="••••••••" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-xl bg-gray-50">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                    Entrar
                </button>
            </form>
        </section>

        <!-- 2. VISTA MENÚ DELEGADO -->
        <section id="vista-delegado" class="hidden space-y-4 no-print">
            <div class="text-center py-2">
                <h2 class="text-xl font-bold text-gray-800">Panel del Delegado</h2>
                <p class="text-xs text-gray-500">Selecciona el módulo de trabajo</p>
            </div>


            <div class="grid grid-cols-1 gap-3">
                <button onclick="abrirApartado('entrenamientos')" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-green-500 flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3">
                        <div class="bg-emerald-100 p-3 rounded-lg text-emerald-600"><i class="fa-solid fa-dumbbell text-xl"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800">1. Entrenamientos</h3>
                            <p class="text-xs text-gray-500">Asistencia y parte diario</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400"></i>
                </button>

                <button onclick="abrirApartado('prepartido')" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-blue-500 flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 p-3 rounded-lg text-blue-600"><i class="fa-solid fa-calendar-check text-xl"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800">2. Prepartido</h3>
                            <p class="text-xs text-gray-500">Partido, Convocatoria, Alineación, PDF Árbitros y Checklist</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400"></i>
                </button>

                <button onclick="abrirApartado('vivo')" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-amber-500 flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3">
                        <div class="bg-amber-100 p-3 rounded-lg text-amber-600"><i class="fa-solid fa-stopwatch text-xl"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800">3. Seguimiento en vivo</h3>
                            <p class="text-xs text-gray-500">Eventos rápidos, estadísticas e informe en PDF</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400"></i>
                </button>

                <button onclick="abrirApartado('plantilla')" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-indigo-500 flex items-center justify-between text-left">
                    <div class="flex items-center space-x-3">
                        <div class="bg-indigo-100 p-3 rounded-lg text-indigo-600"><i class="fa-solid fa-users text-xl"></i></div>
                        <div>
                            <h3 class="font-bold text-gray-800">4. Plantilla del equipo</h3>
                            <p class="text-xs text-gray-500">Base de datos y gestión de jugadores</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400"></i>
                </button>
            </div>
        </section>

        <!-- 3. MÓDULO PREPARTIDO COMPLETO -->
        <section id="apartado-prepartido" class="hidden space-y-5 no-print">

            <div id="alertaEntrenador20h" class="hidden bg-amber-50 border-l-4 border-amber-500 p-3 rounded-r-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-bell text-amber-600 text-lg mt-0.5"></i>
                    <div class="text-xs text-amber-900">
                        <span class="font-bold block">¡Aviso Prepartido! (Quedan menos de 20 horas)</span>
                        Si el entrenador no ha confirmado la lista, recuérdale enviar la convocatoria para el partido.
                    </div>
                </div>
            </div>

            <!-- DATOS DEL PARTIDO -->
            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-3">
                <div class="flex justify-between items-center border-b pb-2">
                    <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-blue-600"></i> Datos del Próximo Partido
                    </h3>
                    <span id="badgeEstadoVivo" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">
                        Sincronizado
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <input type="hidden" id="partidoId">
                    <div>
                        <label class="font-bold text-gray-600">Rival</label>
                        <input type="text" id="partidoRival" value="C.D. Los Leones" class="w-full p-2 border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="font-bold text-gray-600">Condición</label>
                        <select id="partidoCondicion" onchange="evaluarCondicionRival()" class="w-full p-2 border rounded-lg bg-gray-50">
                            <option value="Local" selected>Local</option>
                            <option value="Visitante">Visitante</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-gray-600">Fecha y Hora</label>
                        <input type="datetime-local" id="partidoFechaHora" onchange="comprobarAlerta20h()" class="w-full p-2 border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="font-bold text-gray-600">Lugar / Campo</label>
                        <input type="text" id="partidoLugar" value="Municipal San Fernando" class="w-full p-2 border rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="font-bold text-gray-600">Hora Citación</label>
                        <input type="time" id="partidoCitacion" value="10:30" class="w-full p-2 border rounded-lg bg-gray-50">
                    </div>
                    <div id="campoAutobus" class="hidden">
                        <label class="font-bold text-gray-600">Autobús / Salida</label>
                        <input type="time" id="partidoAutobus" value="09:45" class="w-full p-2 border rounded-lg bg-gray-50">
                    </div>
                </div>

                <button onclick="guardarYEnviarPartidoBD()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-sm">
                    <i class="fa-solid fa-cloud-arrow-up text-sm"></i> Grabar Prepartido en Base de Datos
                </button>
            </div>

            <!-- CONVOCATORIA Y WHATSAPP -->
            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-3">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-user text-indigo-600"></i> Convocatoria de Jugadores
                    </h3>
                    <span id="contadorConvocadosPre" class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                        0 seleccionados
                    </span>
                </div>

                <div id="listaPreConvocatoria" class="space-y-1.5 max-h-60 overflow-y-auto pr-1"></div>

                <button onclick="compartirWhatsApp()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-sm">
                    <i class="fa-brands fa-whatsapp text-base"></i> Compartir Convocatoria por WhatsApp
                </button>
            </div>

            <!-- ALINEACIÓN Y CAPITÁN -->
            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-3">
                <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-shirt text-amber-600"></i> Titulares y Capitán
                </h3>
                <p class="text-[11px] text-gray-500">Selecciona los 11 titulares y asigna la capitanía.</p>

                <div id="listaAlineacion" class="space-y-1.5 max-h-60 overflow-y-auto pr-1"></div>
            </div>

            <!-- CHECKLIST DE MATERIAL -->
            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-3">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-green-600"></i> Checklist de Material
                    </h3>
                    <span id="progresoChecklist" class="text-xs font-bold text-gray-500">0/7</span>
                </div>

                <div class="space-y-2 text-xs">
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Balones de calentamiento y balón oficial</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Botiquín completo</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Agua / Isotónicas</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Equipaciones jugadores y portería</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Petos (7 y 2)</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span>Fichas</span>
                    </label>
                    <label id="contenedorBanderines" class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                        <input type="checkbox" onchange="actualizarChecklist()" class="chk-item w-4 h-4 accent-green-600 rounded">
                        <span id="labelBanderines">Banderines (Partido en casa)</span>
                    </label>
                </div>
            </div>

            <!-- GENERACIÓN ACTA ÁRBITROS -->
            <div class="bg-slate-900 text-white p-4 rounded-xl shadow-sm space-y-3">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-file-pdf text-red-400 text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-sm">Acta para el Equipo Arbitral</h4>
                        <p class="text-[11px] text-gray-300">Hoja con Dorsal, Nombre Completo y Fichas.</p>
                    </div>
                </div>
                <button onclick="generarEImprimirActa()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 rounded-lg text-xs transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-print"></i> Generar e Imprimir PDF
                </button>
            </div>

        </section>

        <!-- SECCIÓN ACTA PARA IMPRESIÓN IMPRESA/PDF (PREPARTIDO) -->
        <div id="seccion-acta-imprimir" class="hidden p-8 bg-white font-sans text-black">
            <div class="border-b-2 border-black pb-4 mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-wide">HOJA OFICIAL DE PARTIDO</h1>
                    <p class="text-sm font-semibold text-gray-700">EQUIPO: MI CLUB F.C.</p>
                </div>
                <div class="text-right text-xs">
                    <p><strong>Rival:</strong> <span id="actaRival">-</span></p>
                    <p><strong>Fecha:</strong> <span id="actaFecha">-</span></p>
                    <p><strong>Campo:</strong> <span id="actaCampo">-</span></p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-sm font-bold border-b border-black pb-1 mb-2">JUGADORES TITULARES (ONCE INICIAL)</h2>
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100 text-left">
                                <th class="p-1.5 w-16">DORSAL</th>
                                <th class="p-1.5">NOMBRE COMPLETO</th>
                                <th class="p-1.5 w-24">C. CAPITÁN</th>
                            </tr>
                        </thead>
                        <tbody id="tablaActaTitulares"></tbody>
                    </table>
                </div>

                <div>
                    <h2 class="text-sm font-bold border-b border-black pb-1 mb-2">JUGADORES SUPLENTES</h2>
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100 text-left">
                                <th class="p-1.5 w-16">DORSAL</th>
                                <th class="p-1.5">NOMBRE COMPLETO</th>
                            </tr>
                        </thead>
                        <tbody id="tablaActaSuplentes"></tbody>
                    </table>
                </div>

                <div class="pt-12 grid grid-cols-2 gap-8 text-center text-xs">
                    <div class="border-t border-black pt-2">Firma del Delegado / Capitán</div>
                    <div class="border-t border-black pt-2">Firma del Árbitro Principal</div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN INFORME SEGUIMIENTO EN VIVO IMPRESA/PDF -->
        <div id="seccion-informe-vivo-imprimir" class="hidden p-8 bg-white font-sans text-black">
            <div class="border-b-2 border-black pb-4 mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-wide">INFORME OFICIAL DEL PARTIDO</h1>
                    <p class="text-sm font-semibold text-gray-700">RESUMEN Y SUCESOS EN DIRECTO</p>
                </div>
                <div class="text-right text-xs">
                    <p><strong>Resultado:</strong> <span id="pdfInfResultado">0 - 0</span></p>
                    <p><strong>Rival:</strong> <span id="pdfInfRival">-</span></p>
                    <p><strong>Fecha:</strong> <span id="pdfInfFecha">-</span></p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-sm font-bold border-b border-black pb-1 mb-2">ESTADÍSTICAS GLOBALES</h2>
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100 text-left">
                                <th class="p-1.5">CONCEPTO</th>
                                <th class="p-1.5 text-center">NUESTRO EQUIPO</th>
                                <th class="p-1.5 text-center">RIVAL</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPdfStats"></tbody>
                    </table>
                </div>

                <div>
                    <h2 class="text-sm font-bold border-b border-black pb-1 mb-2">CRONOLOGÍA DE EVENTOS DEL PARTIDO</h2>
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100 text-left">
                                <th class="p-1.5 w-12">MIN</th>
                                <th class="p-1.5 w-24">EQUIPO</th>
                                <th class="p-1.5 w-32">ACCIÓN</th>
                                <th class="p-1.5">JUGADOR / DETALLES</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPdfEventos"></tbody>
                    </table>
                </div>

                <div>
                    <h2 class="text-sm font-bold border-b border-black pb-1 mb-2">MINUTOS JUGADOS DETALLADOS</h2>
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100 text-left">
                                <th class="p-1.5 w-16">DORSAL</th>
                                <th class="p-1.5">JUGADOR</th>
                                <th class="p-1.5 w-24 text-center">ESTADO</th>
                                <th class="p-1.5 w-20 text-right">MINUTOS</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPdfMinutos"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <section id="apartado-entrenamientos" class="hidden space-y-4 no-print">
            <div class="bg-white border border-gray-200 p-5 rounded-xl text-center">
                <i class="fa-solid fa-dumbbell text-3xl text-emerald-600"></i>
                <h3 class="font-bold text-lg text-gray-800">Entrenamientos</h3>
            </div>
        </section>

        <!-- 3. MÓDULO SEGUIMIENTO EN VIVO DUAL -->
        <section id="apartado-vivo" class="hidden space-y-4 no-print">
            
            <!-- MARCADOR -->
            <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-md text-center space-y-2">
                <div class="flex justify-between items-center text-xs text-gray-400 font-bold px-2">
                    <span id="vivoLocalNombre">NUESTRO EQUIPO</span>
                    <span id="partePartidoBadge" class="bg-amber-500/20 text-amber-400 px-2 py-0.5 rounded-full uppercase">Por empezar</span>
                    <span id="vivoRivalNombre">RIVAL</span>
                </div>

                <div class="flex justify-center items-center gap-6">
                    <span id="golesLocal" class="text-5xl font-mono font-extrabold">0</span>
                    <span class="text-2xl text-gray-600 font-bold">:</span>
                    <span id="golesVisitante" class="text-5xl font-mono font-extrabold">0</span>
                </div>

                <div class="pt-1">
                    <span id="cronometroVivo" class="text-3xl font-mono font-bold tracking-wider text-emerald-400">00:00</span>
                </div>

                <div id="contenedorControlesFlujo" class="pt-2 flex justify-center"></div>
            </div>

            <!-- JUGADORES ACTUALMENTE EN CAMPO -->
            <div class="bg-white border border-gray-200 p-3 rounded-xl shadow-sm text-xs space-y-2">
                <div class="flex justify-between items-center border-b pb-1">
                    <span class="font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-users-between-lines text-emerald-600"></i> En Campo Actualmente
                    </span>
                    <span id="contadorEnCampo" class="bg-emerald-100 text-emerald-800 font-extrabold px-2 py-0.5 rounded-full">0/11</span>
                </div>
                <div id="contenedorChipsEnCampo" class="flex flex-wrap gap-1"></div>
            </div>

            <!-- BOTONERA DE EVENTOS -->
            <div id="botoneraEventosPartidos" class="grid grid-cols-3 gap-2">
                <button onclick="abrirModalEvento('tiro')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-emerald-500 text-center transition">
                    <span class="text-xl block">🎯</span>
                    <span class="font-bold text-xs text-gray-800">Tiro</span>
                </button>
                <button onclick="abrirModalEvento('corner')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-blue-500 text-center transition">
                    <span class="text-xl block">🚩</span>
                    <span class="font-bold text-xs text-gray-800">Córner</span>
                </button>
                <button onclick="abrirModalEvento('falta')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-amber-500 text-center transition">
                    <span class="text-xl block">✋</span>
                    <span class="font-bold text-xs text-gray-800">Falta</span>
                </button>
                <button onclick="abrirModalEvento('amarilla')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-yellow-500 text-center transition">
                    <span class="text-xl block">🟨</span>
                    <span class="font-bold text-xs text-gray-800">Amarilla</span>
                </button>
                <button onclick="abrirModalEvento('roja')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-red-500 text-center transition">
                    <span class="text-xl block">🟥</span>
                    <span class="font-bold text-xs text-gray-800">Roja</span>
                </button>
                <button onclick="abrirModalEvento('cambio')" class="bg-white border border-gray-200 p-2.5 rounded-xl shadow-sm hover:border-purple-500 text-center transition">
                    <span class="text-xl block">🔄</span>
                    <span class="font-bold text-xs text-gray-800">Cambio</span>
                </button>
            </div>

            <!-- TOGGLE VISTAS -->
            <div class="flex gap-2">
                <button id="btnTabEventos" onclick="cambiarTabVivo('eventos')" class="flex-1 py-2 text-xs font-bold rounded-lg bg-slate-900 text-white">
                    Eventos
                </button>
                <button id="btnTabResumen" onclick="cambiarTabVivo('resumen')" class="flex-1 py-2 text-xs font-bold rounded-lg bg-white border text-gray-700">
                    Resumen / Stats
                </button>
            </div>

            <div id="vistaEventosVivo" class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-2">
                <div id="listaEventosPartido" class="space-y-2 max-h-60 overflow-y-auto text-xs"></div>
            </div>

            <div id="vistaResumenVivo" class="hidden space-y-3">
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm text-xs space-y-2">
                    <h4 class="font-bold text-gray-800 border-b pb-1 text-center">Estadísticas Globales</h4>
                    <div id="tablaEstadisticasStats" class="space-y-1.5"></div>
                </div>

                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm text-xs space-y-2">
                    <h4 class="font-bold text-gray-800 border-b pb-1">Minutos Jugados (Convocatoria)</h4>
                    <div id="listaMinutosJugadores" class="space-y-1.5 max-h-60 overflow-y-auto"></div>
                </div>

                <button onclick="generarEImprimirInformePDF()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-sm">
                    <i class="fa-solid fa-file-pdf text-sm"></i> Generar e Imprimir Informe del Partido (PDF)
                </button>
            </div>

        </section>

        <!-- 4. APARTADO PLANTILLA DEL EQUIPO (CRUD COMPLETO) -->
        <section id="apartado-plantilla" class="hidden space-y-4 no-print">
            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-users text-indigo-600"></i> Gestor de Plantilla (CRUD)
                        </h3>
                        <p class="text-[11px] text-gray-500">Crear, listar, editar y eliminar jugadores.</p>
                    </div>
                    <button onclick="mostrarFormNuevoJugador()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg flex items-center gap-1 transition">
                        <i class="fa-solid fa-plus"></i> Nuevo Jugador
                    </button>
                </div>

                <!-- Formulario Crear Jugador -->
                <form id="formNuevoJugador" onsubmit="guardarJugador(event)" class="hidden bg-indigo-50 border border-indigo-200 p-3 rounded-lg space-y-2 text-xs">
                    <h4 class="font-bold text-indigo-900 border-b border-indigo-200 pb-1">Añadir Nuevo Jugador</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-0.5">Nombre</label>
                            <input type="text" id="nuevoNombre" required class="w-full p-1.5 border rounded bg-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-0.5">Apellidos</label>
                            <input type="text" id="nuevoApellidos" required class="w-full p-1.5 border rounded bg-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-0.5">Dorsal</label>
                            <input type="number" id="nuevoDorsal" required class="w-full p-1.5 border rounded bg-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-0.5">Demarcación</label>
                            <select id="nuevaPosicion" class="w-full p-1.5 border rounded bg-white">
                                <option value="Portero">Portero</option>
                                <option value="Defensa">Defensa</option>
                                <option value="Centrocampista">Centrocampista</option>
                                <option value="Delantero">Delantero</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-1">
                        <button type="button" onclick="ocultarFormNuevoJugador()" class="px-2.5 py-1 bg-gray-200 text-gray-700 rounded font-semibold">Cancelar</button>
                        <button type="submit" class="px-2.5 py-1 bg-indigo-600 text-white rounded font-bold">Guardar</button>
                    </div>
                </form>

                <div id="contenedorListaPlantilla" class="space-y-2 max-h-96 overflow-y-auto pr-1"></div>
            </div>
        </section>

    </main>

    <script>
        const API_URL = '/api/jugadores';
        const API_PARTIDOS_URL = '/api/partidos';
        let nivelActual = 'login';
        let jugadoresGlobal = [];
        let convocadosIds = new Set();
        let titularesIds = new Set();
        let capitanId = null;

        let jugadoresEnCampoIds = new Set();

        let estadoPartido = 'pendiente';
        let parteActual = 1;
        let cronoSegundos = 0;
        let cronoInterval = null;
        let equipoEventoSeleccionado = 'local';
        let resultadoEventoSeleccionado = null;
        let eventosGlobal = [];

        const CONFIG_TIPO = {
            tiro: { etiqueta: 'Tiro', necesitaJugador: true, resultados: ['fuera', 'parada', 'gol'] },
            corner: { etiqueta: 'Córner', necesitaJugador: false, resultados: ['remate', 'sin_peligro'] },
            amarilla: { etiqueta: 'Tarjeta amarilla', necesitaJugador: true, resultados: null },
            roja: { etiqueta: 'Tarjeta roja', necesitaJugador: true, resultados: null },
            falta: { etiqueta: 'Falta cometida', necesitaJugador: false, resultados: null },
            cambio: { etiqueta: 'Cambio', necesitaJugador: true, resultados: null }
        };

        const ETIQUETA_RESULTADO = {
            gol: 'Gol ⚽',
            parada: 'Parada 🧤',
            fuera: 'Fuera 🎯',
            remate: 'Remate',
            sin_peligro: 'Sin peligro'
        };

        const ICONO = {
            tiro: { gol: '⚽', parada: '🧤', fuera: '🎯' },
            corner: '🚩',
            amarilla: '🟨',
            roja: '🟥',
            falta: '✋',
            cambio: '🔄'
        };

        const manana = new Date();
        manana.setDate(manana.getDate() + 1);
        manana.setHours(12, 0, 0, 0);
        document.getElementById('partidoFechaHora').value = manana.toISOString().slice(0, 16);

        function iniciarSesion(event) {
            event.preventDefault();
            ocultarTodas();
            document.getElementById('vista-delegado').classList.remove('hidden');
            document.getElementById('btnCerrarSesion').classList.remove('hidden');
            document.getElementById('btnPerfil').classList.remove('hidden');
            nivelActual = 'delegado';
            cargarDatosDesdeAPI();
        }

        async function cargarDatosDesdeAPI() {
            try {
                const res = await fetch(API_URL);
                const json = await res.json();
                jugadoresGlobal = json.data || json || [];
            } catch(e) {
                console.error("Error al cargar la plantilla:", e);
            }
        }

        async function cargarPartidoDesdeBD() {
    try {
        const res = await fetch(API_PARTIDOS_URL);
        const json = await res.json();
        const partido = (Array.isArray(json.data) ? json.data[0] : json.data) || null;

        if (partido) {
            document.getElementById('partidoId').value = partido.id || '';

            // Mapeo Rival
            const rivalVal = partido.rival || partido.away_team || 'C.D. SIERRA YEGUAS';
            if (document.getElementById('partidoRival')) document.getElementById('partidoRival').value = rivalVal;
            if (document.getElementById('vivoRivalNombre')) document.getElementById('vivoRivalNombre').innerText = rivalVal.toUpperCase();

            // Mapeo Fecha y Hora
            if (partido.match_date) {
                let mTime = partido.kickoff_time ? partido.kickoff_time.slice(0, 5) : '00:00';
                // Tomar la fecha tal cual viene en el string (YYYY-MM-DD)
                let dateClean = partido.match_date.split('T')[0];
                let elFH = document.getElementById('partidoFechaHora');
                if (elFH) elFH.value = dateClean + 'T' + mTime;
                let mTime = partido.kickoff_time ? partido.kickoff_time.substring(0, 5) : '12:00';
                let dtVal = partido.match_date + 'T' + mTime;
                let elFH = document.getElementById('partidoFechaHora');
                if (elFH) elFH.value = dtVal;
                const hora = partido.kickoff_time ? partido.kickoff_time.slice(0, 5) : '12:00';
                document.getElementById('partidoFechaHora').value = partido.match_date + 'T' + hora;
            } else if (partido.fecha_hora) {
                document.getElementById('partidoFechaHora').value = partido.fecha_hora.replace(' ', 'T').slice(0, 16);
            }

            // Mapeo Lugar
            const lugarVal = partido.venue || partido.lugar;
            if (lugarVal && document.getElementById('partidoLugar')) document.getElementById('partidoLugar').value = lugarVal;

            if (partido.condicion && document.getElementById('partidoCondicion')) document.getElementById('partidoCondicion').value = partido.condicion;
            if (partido.hora_citacion && document.getElementById('partidoCitacion')) document.getElementById('partidoCitacion').value = partido.hora_citacion;
            if (partido.hora_autobus && document.getElementById('partidoAutobus')) document.getElementById('partidoAutobus').value = partido.hora_autobus;

            if (partido.convocados) convocadosIds = new Set(partido.convocados);
            if (partido.titulares) {
                titularesIds = new Set(partido.titulares);
                jugadoresEnCampoIds = new Set(partido.titulares);
            }
            if (partido.capitan) capitanId = partido.capitan;
            if (partido.eventos) {
                eventosGlobal = partido.eventos;
                if (typeof recalcularMarcador === 'function') recalcularMarcador();
            }

            if (typeof renderizarConvocatoria === 'function') renderizarConvocatoria();
        }
    } catch (e) {
        console.error('Error cargando partido:', e);
    }
}

        async function guardarYEnviarPartidoBD() {
    const valFH = document.getElementById('partidoFechaHora') ? document.getElementById('partidoFechaHora').value : '';
    const datePart = valFH.includes('T') ? valFH.split('T')[0] : valFH;
    const timePart = valFH.includes('T') ? valFH.split('T')[1] : '12:00';
    const lugarVal = document.getElementById('partidoLugar') ? document.getElementById('partidoLugar').value : '';
    const rivalVal = document.getElementById('partidoRival') ? document.getElementById('partidoRival').value : '';

    const payload = {
        rival: rivalVal,
        away_team: rivalVal,
        condicion: document.getElementById('partidoCondicion') ? document.getElementById('partidoCondicion').value : 'Local',
        match_date: datePart,
        kickoff_time: timePart + ':00',
        fecha_hora: datePart + ' ' + timePart + ':00',
        venue: lugarVal,
        lugar: lugarVal
    };
            const partidoData = {
                rival: document.getElementById('partidoRival').value,
                condicion: document.getElementById('partidoCondicion').value,
                match_date: document.getElementById('partidoFechaHora').value ? document.getElementById('partidoFechaHora').value.split('T')[0] : null,
                kickoff_time: document.getElementById('partidoFechaHora').value ? document.getElementById('partidoFechaHora').value.split('T')[1] : null,
                venue: document.getElementById('partidoLugar') ? document.getElementById('partidoLugar').value : null,
                lugar: document.getElementById('partidoLugar').value,
                hora_citacion: document.getElementById('partidoCitacion').value,
                hora_autobus: document.getElementById('partidoCondicion').value === 'Visitante' ? document.getElementById('partidoAutobus').value : null,
                convocados: Array.from(convocadosIds),
                titulares: Array.from(titularesIds),
                capitan: capitanId,
                eventos: eventosGlobal
            };

            try {
                const res = await fetch(API_PARTIDOS_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Admin-Key': 'CAMBIA_ESTA_CLAVE' },
                    body: JSON.stringify(partidoData)
                });

                if (res.ok) {
                    alert('Prepartido guardado en la BD.');
                    document.getElementById('vivoRivalNombre').innerText = partidoData.rival.toUpperCase();
                } else {
                    alert('Error guardando en la BD.');
                }
            } catch(e) {
                alert('Prepartido actualizado correctamente.');
            }
        }

        function abrirApartado(apartado) {
            ocultarTodas();
            document.getElementById(`apartado-${apartado}`).classList.remove('hidden');
            document.getElementById('btnVolver').classList.remove('hidden');
            document.getElementById('btnCerrarSesion').classList.remove('hidden');
            document.getElementById('btnPerfil').classList.remove('hidden');
            nivelActual = 'apartado';

            if(apartado === 'prepartido') {
                cargarPrepartido();
                cargarPartidoDesdeBD();
            } else if(apartado === 'plantilla') {
                renderizarPlantillaModulo();
            } else if(apartado === 'vivo') {
                document.getElementById('vivoRivalNombre').innerText = document.getElementById('partidoRival').value.toUpperCase();
                
                if(jugadoresEnCampoIds.size === 0 && titularesIds.size > 0) {
                    jugadoresEnCampoIds = new Set(titularesIds);
                }

                renderizarJugadoresEnCampoChips();
                actualizarBotoneraFlujo();
                renderizarEventosVivo();
            }
        }

        function renderizarJugadoresEnCampoChips() {
            const cont = document.getElementById('contenedorChipsEnCampo');
            const contContador = document.getElementById('contadorEnCampo');
            const lista = jugadoresGlobal.filter(j => jugadoresEnCampoIds.has(j.id));
            
            contContador.innerText = `${lista.length} en campo`;
            
            if(lista.length === 0) {
                cont.innerHTML = '<span class="text-gray-400">Sin jugadores en campo. Selecciona los titulares en Prepartido.</span>';
                return;
            }

            cont.innerHTML = lista.map(j => `
                <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-lg font-bold text-[10px]">
                    #${j.dorsal || '-'} ${j.nombre}
                </span>
            `).join('');
        }

        function volverAtras() {
            if(nivelActual === 'apartado') {
                ocultarTodas();
                document.getElementById('vista-delegado').classList.remove('hidden');
                document.getElementById('btnCerrarSesion').classList.remove('hidden');
                document.getElementById('btnPerfil').classList.remove('hidden');
                nivelActual = 'delegado';
            }
        }

        function cerrarSesion() {
            ocultarTodas();
            document.getElementById('vista-login').classList.remove('hidden');
            document.getElementById('btnVolver').classList.add('hidden');
            document.getElementById('btnCerrarSesion').classList.add('hidden');
            document.getElementById('btnPerfil').classList.add('hidden');
            nivelActual = 'login';
        }

        function ocultarTodas() {
            document.getElementById('vista-login').classList.add('hidden');
            document.getElementById('vista-delegado').classList.add('hidden');
            document.getElementById('apartado-entrenamientos').classList.add('hidden');
            document.getElementById('apartado-prepartido').classList.add('hidden');
            document.getElementById('apartado-vivo').classList.add('hidden');
            document.getElementById('apartado-plantilla').classList.add('hidden');
            document.getElementById('btnVolver').classList.add('hidden');
        }

        async function cargarPrepartido() {
            if(!jugadoresGlobal || jugadoresGlobal.length === 0) {
                await cargarDatosDesdeAPI();
            }

            const contenedorConvocatoria = document.getElementById('listaPreConvocatoria');
            
            contenedorConvocatoria.innerHTML = jugadoresGlobal.map(j => {
                const elegible = (j.estado || 'Disponible') === 'Disponible';
                return `
                    <div class="flex items-center justify-between p-2 rounded-lg border ${elegible ? 'bg-gray-50 border-gray-200' : 'bg-gray-100 border-gray-200 opacity-50'}">
                        <div class="flex items-center space-x-2 text-xs">
                            <span class="font-bold w-6 text-indigo-700">#${j.dorsal || '-'}</span>
                            <span class="font-semibold text-gray-800">${j.nombre} ${j.apellidos}</span>
                            ${!elegible ? `<span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-bold">${j.estado}</span>` : ''}
                        </div>
                        ${elegible ? `
                            <input type="checkbox" onchange="toggleConvocado(${j.id})" ${convocadosIds.has(j.id) ? 'checked' : ''} class="w-4 h-4 accent-indigo-600 rounded cursor-pointer">
                        ` : ''}
                    </div>
                `;
            }).join('');

            renderAlineacion();
            comprobarAlerta20h();
            evaluarCondicionRival();
        }

        function toggleConvocado(id) {
            if(convocadosIds.has(id)) {
                convocadosIds.delete(id);
                titularesIds.delete(id);
                if(capitanId === id) capitanId = null;
            } else {
                convocadosIds.add(id);
            }
            document.getElementById('contadorConvocadosPre').innerText = `${convocadosIds.size} seleccionados`;
            renderAlineacion();
        }

        function renderAlineacion() {
            const contenedor = document.getElementById('listaAlineacion');
            const convocadosList = jugadoresGlobal.filter(j => convocadosIds.has(j.id));

            if(convocadosList.length === 0) {
                contenedor.innerHTML = '<p class="text-xs text-gray-400 text-center py-2">Selecciona primero los jugadores convocados arriba.</p>';
                return;
            }

            contenedor.innerHTML = convocadosList.map(j => `
                <div class="flex items-center justify-between p-2 rounded-lg border bg-gray-50 text-xs">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" onchange="toggleTitular(${j.id})" ${titularesIds.has(j.id) ? 'checked' : ''} class="w-4 h-4 accent-amber-600">
                        <span class="font-bold text-gray-700">#${j.dorsal || '-'} ${j.nombre} ${j.apellidos}</span>
                    </div>
                    ${titularesIds.has(j.id) ? `
                        <button onclick="setCapitan(${j.id})" class="px-2 py-0.5 rounded text-[10px] font-bold ${capitanId === j.id ? 'bg-amber-500 text-white' : 'bg-gray-200 text-gray-600'}">
                            ${capitanId === j.id ? 'Capitán C' : 'Hacer C'}
                        </button>
                    ` : '<span class="text-[10px] text-gray-400">Suplente</span>'}
                </div>
            `).join('');
        }

        function toggleTitular(id) {
            if(titularesIds.has(id)) {
                titularesIds.delete(id);
                if(capitanId === id) capitanId = null;
            } else {
                if(titularesIds.size >= 11) {
                    alert('Ya has seleccionado 11 titulares');
                    renderAlineacion();
                    return;
                }
                titularesIds.add(id);
            }
            jugadoresEnCampoIds = new Set(titularesIds);
            renderAlineacion();
        }

        function setCapitan(id) {
            capitanId = id;
            renderAlineacion();
        }

        function evaluarCondicionRival() {
            const condicion = document.getElementById('partidoCondicion').value;
            const label = document.getElementById('labelBanderines');
            const campoAutobus = document.getElementById('campoAutobus');

            if (condicion === 'Visitante') {
                label.innerText = 'Banderines (No aplica - Partido fuera)';
                label.classList.add('line-through', 'text-gray-400');
                campoAutobus.classList.remove('hidden');
            } else {
                label.innerText = 'Banderines (Partido en casa)';
                label.classList.remove('line-through', 'text-gray-400');
                campoAutobus.classList.add('hidden');
            }
        }

        function comprobarAlerta20h() {
            const fechaHora = new Date(document.getElementById('partidoFechaHora').value);
            const ahora = new Date();
            const diferenciaHoras = (fechaHora - ahora) / (1000 * 60 * 60);

            const alerta = document.getElementById('alertaEntrenador20h');
            if(diferenciaHoras > 0 && diferenciaHoras <= 20 && convocadosIds.size === 0) {
                alerta.classList.remove('hidden');
            } else {
                alerta.classList.add('hidden');
            }
        }

        function actualizarChecklist() {
            const total = document.querySelectorAll('.chk-item').length;
            const marcados = document.querySelectorAll('.chk-item:checked').length;
            document.getElementById('progresoChecklist').innerText = `${marcados}/${total}`;
        }

        function compartirWhatsApp() {
            const rival = document.getElementById('partidoRival').value;
            const fecha = new Date(document.getElementById('partidoFechaHora').value).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' });
            const campo = document.getElementById('partidoLugar').value;
            const citacion = document.getElementById('partidoCitacion').value;
            const condicion = document.getElementById('partidoCondicion').value;
            
            let textoAutobus = '';
            if(condicion === 'Visitante') {
                const autobús = document.getElementById('partidoAutobus').value;
                textoAutobus = `\n🚌 Autobús: ${autobús} h`;
            }

            const listaConvocados = jugadoresGlobal
                .filter(j => convocadosIds.has(j.id))
                .map(j => `• #${j.dorsal || '-'} ${j.nombre} ${j.apellidos}`)
                .join('\n');

            const texto = `📋 *CONVOCATORIA OFICIAL*\n⚽ Rival: ${rival}\n📅 Fecha: ${fecha}\n📍 Campo: ${campo}\n⏰ Citación: ${citacion} h${textoAutobus}\n\n*Jugadores convocados:*\n${listaConvocados || 'Sin convocados'}`;

            window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(texto)}`, '_blank');
        }

        function generarEImprimirActa() {
            document.getElementById('actaRival').innerText = document.getElementById('partidoRival').value;
            document.getElementById('actaFecha').innerText = document.getElementById('partidoFechaHora').value.replace('T', ' ');
            document.getElementById('actaCampo').innerText = document.getElementById('partidoLugar').value;

            const titulares = jugadoresGlobal.filter(j => titularesIds.has(j.id));
            const suplentes = jugadoresGlobal.filter(j => convocadosIds.has(j.id) && !titularesIds.has(j.id));

            document.getElementById('tablaActaTitulares').innerHTML = titulares.map(j => `
                <tr class="border-b">
                    <td class="p-1.5 font-bold">#${j.dorsal || '-'}</td>
                    <td class="p-1.5">${j.nombre} ${j.apellidos}</td>
                    <td class="p-1.5 font-bold">${capitanId === j.id ? '(C) CAPITÁN' : ''}</td>
                </tr>
            `).join('');

            document.getElementById('tablaActaSuplentes').innerHTML = suplentes.map(j => `
                <tr class="border-b">
                    <td class="p-1.5 font-bold">#${j.dorsal || '-'}</td>
                    <td class="p-1.5">${j.nombre} ${j.apellidos}</td>
                </tr>
            `).join('');

            const seccionActa = document.getElementById('seccion-acta-imprimir');
            seccionActa.classList.remove('hidden');
            window.print();
            seccionActa.classList.add('hidden');
        }

        /* LÓGICA DE FLUJO Y REGISTRO RÁPIDO DE EVENTOS EN VIVO */
        function actualizarBotoneraFlujo() {
            const cont = document.getElementById('contenedorControlesFlujo');
            const badge = document.getElementById('partePartidoBadge');

            if (estadoPartido === 'pendiente') {
                badge.innerText = 'Por empezar';
                badge.className = 'bg-gray-500/20 text-gray-300 px-2 py-0.5 rounded-full uppercase';
                cont.innerHTML = `<button onclick="comenzarPartido()" class="bg-emerald-600 hover:bg-emerald-700 px-6 py-2 rounded-xl text-xs font-bold transition">Comenzar Partido</button>`;
            } else if (estadoPartido === 'en_curso' && parteActual === 1) {
                badge.innerText = '1ª Parte';
                badge.className = 'bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded-full uppercase';
                cont.innerHTML = `<button onclick="pasarADescanso()" class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded-xl text-xs font-bold transition">Descanso</button>`;
            } else if (estadoPartido === 'descanso') {
                badge.innerText = 'Descanso';
                badge.className = 'bg-amber-500/20 text-amber-400 px-2 py-0.5 rounded-full uppercase';
                cont.innerHTML = `<button onclick="empezarSegundaParte()" class="bg-emerald-600 hover:bg-emerald-700 px-6 py-2 rounded-xl text-xs font-bold transition">Empezar 2ª Parte</button>`;
            } else if (estadoPartido === 'en_curso' && parteActual === 2) {
                badge.innerText = '2ª Parte';
                badge.className = 'bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded-full uppercase';
                cont.innerHTML = `<button onclick="terminarPartido()" class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-xl text-xs font-bold transition">Finalizar Partido</button>`;
            } else if (estadoPartido === 'finalizado') {
                badge.innerText = 'Finalizado';
                badge.className = 'bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full uppercase';
                cont.innerHTML = `<span class="text-xs text-gray-400 font-bold py-1">Partido Finalizado</span>`;
            }
        }

        function comenzarPartido() {
            estadoPartido = 'en_curso';
            parteActual = 1;
            iniciarReloj();
            actualizarBotoneraFlujo();
        }

        function pasarADescanso() {
            if(!confirm('¿Enviar el partido a descanso?')) return;
            estadoPartido = 'descanso';
            detenerReloj();
            actualizarBotoneraFlujo();
        }

        function empezarSegundaParte() {
            estadoPartido = 'en_curso';
            parteActual = 2;
            iniciarReloj();
            actualizarBotoneraFlujo();
        }

        function terminarPartido() {
            if(!confirm('¿Seguro que deseas finalizar el partido?')) return;
            estadoPartido = 'finalizado';
            detenerReloj();
            actualizarBotoneraFlujo();
            cambiarTabVivo('resumen');
        }

        function iniciarReloj() {
            if(cronoInterval) clearInterval(cronoInterval);
            cronoInterval = setInterval(() => {
                cronoSegundos++;
                const m = String(Math.floor(cronoSegundos / 60)).padStart(2, '0');
                const s = String(cronoSegundos % 60).padStart(2, '0');
                document.getElementById('cronometroVivo').innerText = `${m}:${s}`;
            }, 1000);
        }

        function detenerReloj() {
            if(cronoInterval) clearInterval(cronoInterval);
            cronoInterval = null;
        }

        function cambiarTabVivo(tab) {
            const btnEv = document.getElementById('btnTabEventos');
            const btnRes = document.getElementById('btnTabResumen');
            const vEv = document.getElementById('vistaEventosVivo');
            const vRes = document.getElementById('vistaResumenVivo');

            if(tab === 'eventos') {
                btnEv.className = 'flex-1 py-2 text-xs font-bold rounded-lg bg-slate-900 text-white';
                btnRes.className = 'flex-1 py-2 text-xs font-bold rounded-lg bg-white border text-gray-700';
                vEv.classList.remove('hidden');
                vRes.classList.add('hidden');
            } else {
                btnRes.className = 'flex-1 py-2 text-xs font-bold rounded-lg bg-slate-900 text-white';
                btnEv.className = 'flex-1 py-2 text-xs font-bold rounded-lg bg-white border text-gray-700';
                vRes.classList.remove('hidden');
                vEv.classList.add('hidden');
                renderizarResumenVivo();
            }
        }

        function abrirModalEvento(tipo, editId = null) {
            if(estadoPartido === 'pendiente' && !editId) {
                alert('Debes iniciar el partido para registrar eventos.');
                return;
            }

            document.getElementById('modalEventoEditId').value = editId || '';
            document.getElementById('modalTipoEvento').value = tipo;
            const config = CONFIG_TIPO[tipo];
            
            let minVal = Math.floor(cronoSegundos/60);
            if (editId) {
                const evToEdit = eventosGlobal.find(e => e.id == editId);
                if (evToEdit) minVal = evToEdit.minuto;
            }
            document.getElementById('inputMinutoEvento').value = minVal;
            document.getElementById('modalEventoTitulo').innerText = editId ? `Editar ${config.etiqueta}` : `${config.etiqueta} · Minuto ${minVal}'`;

            equipoEventoSeleccionado = 'local';
            resultadoEventoSeleccionado = null;
            document.getElementById('inputDorsalRival').value = '';
            actualizarBotonesEquipoModal();

            const bloqueRes = document.getElementById('bloqueResultados');
            const contChips = document.getElementById('contenedorChipsResultados');
            if(config.resultados) {
                bloqueRes.classList.remove('hidden');
                contChips.innerHTML = config.resultados.map(r => `
                    <button type="button" onclick="seleccionarResultadoChip('${r}')" id="chipRes_${r}" class="chip-res p-2 rounded-lg border font-semibold text-[11px] bg-gray-100 text-gray-700">
                        ${ETIQUETA_RESULTADO[r]}
                    </button>
                `).join('');
            } else {
                bloqueRes.classList.add('hidden');
            }

            actualizarFormularioSegunEquipo();
            document.getElementById('modalEventoVivo').classList.remove('hidden');
        }

        function seleccionarEquipoEvento(eq) {
            equipoEventoSeleccionado = eq;
            actualizarBotonesEquipoModal();
            actualizarFormularioSegunEquipo();
        }

        function actualizarBotonesEquipoModal() {
            const bLoc = document.getElementById('btnEqLocal');
            const bVis = document.getElementById('btnEqVisitante');
            if(equipoEventoSeleccionado === 'local') {
                bLoc.className = 'p-2 rounded-lg border font-bold text-center bg-slate-900 text-white';
                bVis.className = 'p-2 rounded-lg border font-bold text-center bg-gray-100 text-gray-700';
            } else {
                bVis.className = 'p-2 rounded-lg border font-bold text-center bg-slate-900 text-white';
                bLoc.className = 'p-2 rounded-lg border font-bold text-center bg-gray-100 text-gray-700';
            }
        }

        function seleccionarResultadoChip(r) {
            resultadoEventoSeleccionado = r;
            document.querySelectorAll('.chip-res').forEach(el => el.className = 'chip-res p-2 rounded-lg border font-semibold text-[11px] bg-gray-100 text-gray-700');
            const activo = document.getElementById(`chipRes_${r}`);
            if(activo) activo.className = 'chip-res p-2 rounded-lg border font-bold text-[11px] bg-slate-900 text-white';
        }

        function actualizarFormularioSegunEquipo() {
            const tipo = document.getElementById('modalTipoEvento').value;
            const bloquePrinc = document.getElementById('bloqueJugadorPrincipal');
            const bloqueSale = document.getElementById('bloqueJugadorSale');
            const bloqueAviso = document.getElementById('bloqueAvisoRival');
            const selPrinc = document.getElementById('selectJugadorPrincipal');
            const selSale = document.getElementById('selectJugadorSale');

            if(equipoEventoSeleccionado === 'visitante') {
                bloquePrinc.classList.add('hidden');
                bloqueSale.classList.add('hidden');
                bloqueAviso.classList.remove('hidden');
            } else {
                bloqueAviso.classList.add('hidden');
                
                const enCampoList = jugadoresGlobal.filter(j => jugadoresEnCampoIds.has(j.id));
                const enBanquilloList = jugadoresGlobal.filter(j => convocadosIds.has(j.id) && !jugadoresEnCampoIds.has(j.id));

                if(tipo === 'cambio') {
                    bloqueSale.classList.remove('hidden');
                    bloquePrinc.classList.remove('hidden');
                    document.getElementById('labelJugadorPrincipal').innerText = '🟢 ENTRA (En el banquillo)';

                    if(enCampoList.length === 0) {
                        selSale.innerHTML = '<option value="">Sin jugadores en el campo</option>';
                    } else {
                        selSale.innerHTML = enCampoList.map(j => `<option value="${j.id}">#${j.dorsal || '-'} ${j.nombre} ${j.apellidos}</option>`).join('');
                    }

                    if(enBanquilloList.length === 0) {
                        selPrinc.innerHTML = '<option value="">Sin suplentes en el banquillo</option>';
                    } else {
                        selPrinc.innerHTML = enBanquilloList.map(j => `<option value="${j.id}">#${j.dorsal || '-'} ${j.nombre} ${j.apellidos}</option>`).join('');
                    }
                } else {
                    bloqueSale.classList.add('hidden');
                    bloquePrinc.classList.remove('hidden');
                    document.getElementById('labelJugadorPrincipal').innerText = 'Jugador Convocado (En campo)';
                    
                    const listaOpciones = enCampoList.length > 0 ? enCampoList : jugadoresGlobal.filter(j => convocadosIds.has(j.id));
                    selPrinc.innerHTML = listaOpciones.map(j => `<option value="${j.id}">#${j.dorsal || '-'} ${j.nombre} ${j.apellidos}</option>`).join('');
                }
            }
        }

        function cerrarModalEvento() {
            document.getElementById('modalEventoVivo').classList.add('hidden');
        }

        function confirmarEvento() {
            const tipo = document.getElementById('modalTipoEvento').value;
            const editId = document.getElementById('modalEventoEditId').value;
            const minuto = parseInt(document.getElementById('inputMinutoEvento').value) || 0;

            let nombreJug = '';
            let jugObj = null;

            if(equipoEventoSeleccionado === 'local') {
                const jugId = document.getElementById('selectJugadorPrincipal').value;
                jugObj = jugadoresGlobal.find(j => j.id == jugId);
                nombreJug = jugObj ? `#${jugObj.dorsal || ''} ${jugObj.nombre}` : 'Jugador';
            } else {
                const dorsalRiv = document.getElementById('inputDorsalRival').value.trim();
                nombreJug = dorsalRiv ? `Rival (#${dorsalRiv})` : 'Rival';
            }

            if (editId) {
                const idx = eventosGlobal.findIndex(e => e.id == editId);
                if (idx !== -1) {
                    eventosGlobal[idx].tipo = tipo;
                    eventosGlobal[idx].minuto = minuto;
                    eventosGlobal[idx].equipo = equipoEventoSeleccionado;
                    eventosGlobal[idx].resultado = resultadoEventoSeleccionado || '';
                    eventosGlobal[idx].jugador = nombreJug;
                    eventosGlobal[idx].jugadorId = jugObj ? jugObj.id : null;
                }
            } else {
                const nuevoEvento = {
                    id: Date.now(),
                    tipo,
                    equipo: equipoEventoSeleccionado,
                    minuto,
                    resultado: resultadoEventoSeleccionado || '',
                    jugador: nombreJug,
                    jugadorId: jugObj ? jugObj.id : null
                };

                if(tipo === 'cambio' && equipoEventoSeleccionado === 'local') {
                    const saleId = document.getElementById('selectJugadorSale').value;
                    const saleObj = jugadoresGlobal.find(j => j.id == saleId);
                    
                    if(!saleObj || !jugObj) {
                        alert('Debes seleccionar un jugador que sale y uno que entra.');
                        return;
                    }

                    nuevoEvento.jugadorSale = `#${saleObj.dorsal || ''} ${saleObj.nombre}`;
                    nuevoEvento.saleId = saleObj.id;
                    nuevoEvento.entraId = jugObj.id;

                    jugadoresEnCampoIds.delete(saleObj.id);
                    jugadoresEnCampoIds.add(jugObj.id);

                    renderizarJugadoresEnCampoChips();
                }

                eventosGlobal.push(nuevoEvento);
            }

            recalcularMarcador();
            renderizarEventosVivo();
            cerrarModalEvento();
        }

        function eliminarEvento(id) {
            if (!confirm('¿Deseas eliminar este evento?')) return;
            eventosGlobal = eventosGlobal.filter(e => e.id != id);
            recalcularMarcador();
            renderizarEventosVivo();
        }

        function editarEvento(id) {
            const ev = eventosGlobal.find(e => e.id == id);
            if (!ev) return;
            abrirModalEvento(ev.tipo, id);
        }

        function recalcularMarcador() {
            const golesLoc = eventosGlobal.filter(e => e.tipo === 'tiro' && e.resultado === 'gol' && e.equipo === 'local').length;
            const golesVis = eventosGlobal.filter(e => e.tipo === 'tiro' && e.resultado === 'gol' && e.equipo === 'visitante').length;
            document.getElementById('golesLocal').innerText = golesLoc;
            document.getElementById('golesVisitante').innerText = golesVis;
        }

        function renderizarEventosVivo() {
            const cont = document.getElementById('listaEventosPartido');
            if(eventosGlobal.length === 0) {
                cont.innerHTML = '<p class="text-gray-400 text-center py-4">Todavía no hay eventos registrados.</p>';
                return;
            }

            const ordenados = [...eventosGlobal].sort((a,b) => b.minuto - a.minuto);
            cont.innerHTML = ordenados.map(ev => {
                const icono = ev.tipo === 'tiro' ? (ICONO.tiro[ev.resultado] || '🎯') : ICONO[ev.tipo];
                const nomEquipo = ev.equipo === 'local' ? 'Nuestro Equipo' : document.getElementById('partidoRival').value;
                return `
                    <div class="flex items-center justify-between p-2 bg-gray-50 border rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold bg-slate-900 text-white px-2 py-0.5 rounded text-[10px]">${ev.minuto}'</span>
                            <span class="text-base">${icono}</span>
                            <div>
                                <p class="font-bold text-gray-800">${CONFIG_TIPO[ev.tipo].etiqueta} · ${nomEquipo}</p>
                                <p class="text-[10px] text-gray-500">${ev.equipo === 'visitante' ? ev.jugador : (ev.tipo === 'cambio' ? `Entra ${ev.jugador} / Sale${ev.jugadorSale}` : ev.jugador)}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="editarEvento(${ev.id})" class="p-1.5 bg-amber-100 text-amber-700 hover:bg-amber-200 rounded-lg transition" title="Editar evento">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button onclick="eliminarEvento(${ev.id})" class="p-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition" title="Eliminar evento">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        /* LÓGICA REVISADA DE CÁLCULO DUAL AUTOMÁTICO DE MINUTOS */
        function calcularMinutosAutomaticosJugador(jId, minutoLimite) {
            const esTitular = titularesIds.has(jId);
            const cambiosRelacionados = eventosGlobal
                .filter(e => e.tipo === 'cambio' && e.equipo === 'local')
                .sort((a,b) => a.minuto - b.minuto);

            let minutosAcumulados = 0;
            let enCampoActualmente = esTitular;
            let minutoUltimoCambio = 0;

            cambiosRelacionados.forEach(c => {
                if (c.saleId == jId) {
                    if (enCampoActualmente) {
                        minutosAcumulados += Math.max(0, c.minuto - minutoUltimoCambio);
                        enCampoActualmente = false;
                    }
                } else if (c.entraId == jId) {
                    enCampoActualmente = true;
                    minutoUltimoCambio = c.minuto;
                }
            });

            if (enCampoActualmente) {
                minutosAcumulados += Math.max(0, minutoLimite - minutoUltimoCambio);
            }

            return minutosAcumulados;
        }

        function renderizarResumenVivo() {
            const contStats = document.getElementById('tablaEstadisticasStats');
            const contMin = document.getElementById('listaMinutosJugadores');

            const contar = (tipo, equipo, filtro) => eventosGlobal.filter(e => e.tipo === tipo && e.equipo === equipo && (!filtro || filtro(e.resultado))).length;

            const golesL = contar('tiro', 'local', r => r === 'gol');
            const golesV = contar('tiro', 'visitante', r => r === 'gol');
            const tirosL = contar('tiro', 'local');
            const tirosV = contar('tiro', 'visitante');
            const tirosPuertaL = contar('tiro', 'local', r => r === 'gol' || r === 'parada');
            const tirosPuertaV = contar('tiro', 'visitante', r => r === 'gol' || r === 'parada');
            const cornersL = contar('corner', 'local');
            const cornersV = contar('corner', 'visitante');
            const faltasL = contar('falta', 'local');
            const faltasV = contar('falta', 'visitante');

            contStats.innerHTML = `
                <div class="flex justify-between border-b py-1"><span>Goles</span><span class="font-bold">${golesL} - ${golesV}</span></div>
                <div class="flex justify-between border-b py-1"><span>Tiros (A puerta)</span><span class="font-bold">${tirosL} (${tirosPuertaL}) - ${tirosV} (${tirosPuertaV})</span></div>
                <div class="flex justify-between border-b py-1"><span>Córners</span><span class="font-bold">${cornersL} - ${cornersV}</span></div>
                <div class="flex justify-between py-1"><span>Faltas</span><span class="font-bold">${faltasL} - ${faltasV}</span></div>
            `;

            const convocados = jugadoresGlobal.filter(j => convocadosIds.has(j.id));
            if(convocados.length === 0) {
                contMin.innerHTML = '<p class="text-gray-400 text-center py-2">Selecciona primero la convocatoria en Prepartido.</p>';
                return;
            }

            let minutosPart = Math.floor(cronoSegundos / 60);
            if(minutosPart === 0 && (estadoPartido === 'finalizado' || eventosGlobal.length > 0)) {
                minutosPart = 90;
            }

            contMin.innerHTML = convocados.map(j => {
                const minJugados = calcularMinutosAutomaticosJugador(j.id, minutosPart);
                const enCampo = jugadoresEnCampoIds.has(j.id);
                return `
                    <div class="flex justify-between items-center p-2 bg-gray-50 border rounded-lg">
                        <span class="font-semibold text-gray-800">
                            #${j.dorsal || '-'} ${j.nombre} ${j.apellidos}
                            ${enCampo ? '<span class="text-[9px] bg-emerald-100 text-emerald-800 px-1 rounded font-bold">En campo</span>' : '<span class="text-[9px] bg-gray-200 text-gray-600 px-1 rounded font-bold">Banquillo</span>'}
                        </span>
                        <span class="font-mono font-bold text-indigo-600">${minJugados}'</span>
                    </div>
                `;
            }).join('');
        }

        async function ejecutarSimulacionRapida() {
            if(!jugadoresGlobal || jugadoresGlobal.length === 0) await cargarDatosDesdeAPI();

            convocadosIds = new Set(jugadoresGlobal.slice(0, 14).map(j => j.id));
            titularesIds = new Set(jugadoresGlobal.slice(0, 11).map(j => j.id));
            jugadoresEnCampoIds = new Set(titularesIds);

            cronoSegundos = 5400; // 90 Minutos para simular
            estadoPartido = 'finalizado';

            eventosGlobal = [
                { id: 1, minuto: 12, equipo: 'local', tipo: 'tiro', resultado: 'gol', jugador: '#9 Álvaro Moreno', jugadorId: 9 },
                { id: 2, minuto: 25, equipo: 'visitante', tipo: 'tiro', resultado: 'gol', jugador: 'Rival (#9)' },
                { id: 3, minuto: 40, equipo: 'local', tipo: 'amarilla', resultado: '', jugador: '#4 David López', jugadorId: 4 },
                { id: 4, minuto: 58, equipo: 'local', tipo: 'tiro', resultado: 'gol', jugador: '#10 Daniel Serrano', jugadorId: 10 },
                { id: 5, minuto: 68, equipo: 'local', tipo: 'cambio', resultado: '', jugador: '#14 Iván Delgado', entraId: 14, jugadorSale: '#9 Álvaro Moreno', saleId: 9 },
                { id: 6, minuto: 75, equipo: 'visitante', tipo: 'amarilla', resultado: '', jugador: 'Rival (#5)' },
                { id: 7, minuto: 82, equipo: 'local', tipo: 'tiro', resultado: 'gol', jugador: '#14 Iván Delgado', jugadorId: 14 }
            ];

            await guardarYEnviarPartidoBD();
            alert('¡Simulación ejecutada! Los minutos jugados se han sumado automáticamente para todos los jugadores.');
        }

        async function resetearDatosBD() {
            if(!confirm('¿Deseas eliminar los datos guardados en la base de datos?')) return;
            await fetch('/api/partidos/reset', { method: 'DELETE' });
            eventosGlobal = [];
            convocadosIds = new Set();
            titularesIds = new Set();
            jugadoresEnCampoIds = new Set();
            cronoSegundos = 0;
            estadoPartido = 'pendiente';
            alert('Datos reseteados correctamente.');
            location.reload();
        }

        /* IMPRESIÓN DEL INFORME EN PDF DE SEGUIMIENTO EN VIVO */
        function generarEImprimirInformePDF() {
            const golesLoc = document.getElementById('golesLocal').innerText;
            const golesVis = document.getElementById('golesVisitante').innerText;
            const rival = document.getElementById('partidoRival').value;
            const fecha = document.getElementById('partidoFechaHora').value.replace('T', ' ');

            document.getElementById('pdfInfResultado').innerText = `${golesLoc} - ${golesVis}`;
            document.getElementById('pdfInfRival').innerText = rival;
            document.getElementById('pdfInfFecha').innerText = fecha;

            const contar = (tipo, equipo, filtro) => eventosGlobal.filter(e => e.tipo === tipo && e.equipo === equipo && (!filtro || filtro(e.resultado))).length;

            const golesL = contar('tiro', 'local', r => r === 'gol');
            const golesV = contar('tiro', 'visitante', r => r === 'gol');
            const tirosL = contar('tiro', 'local');
            const tirosV = contar('tiro', 'visitante');
            const tirosPuertaL = contar('tiro', 'local', r => r === 'gol' || r === 'parada');
            const tirosPuertaV = contar('tiro', 'visitante', r => r === 'gol' || r === 'parada');
            const cornersL = contar('corner', 'local');
            const cornersV = contar('corner', 'visitante');
            const faltasL = contar('falta', 'local');
            const faltasV = contar('falta', 'visitante');

            document.getElementById('tablaPdfStats').innerHTML = `
                <tr class="border-b"><td class="p-1.5 font-bold">Goles</td><td class="p-1.5 text-center font-bold">${golesL}</td><td class="p-1.5 text-center font-bold">${golesV}</td></tr>
                <tr class="border-b"><td class="p-1.5 font-bold">Tiros Totales (a puerta)</td><td class="p-1.5 text-center">${tirosL} (${tirosPuertaL})</td><td class="p-1.5 text-center">${tirosV} (${tirosPuertaV})</td></tr>
                <tr class="border-b"><td class="p-1.5 font-bold">Córners</td><td class="p-1.5 text-center">${cornersL}</td><td class="p-1.5 text-center">${cornersV}</td></tr>
                <tr class="border-b"><td class="p-1.5 font-bold">Faltas cometidas</td><td class="p-1.5 text-center">${faltasL}</td><td class="p-1.5 text-center">${faltasV}</td></tr>
            `;

            const ordenados = [...eventosGlobal].sort((a,b) => a.minuto - b.minuto);
            document.getElementById('tablaPdfEventos').innerHTML = ordenados.length > 0 ? ordenados.map(ev => `
                <tr class="border-b">
                    <td class="p-1.5 font-bold">${ev.minuto}'</td>
                    <td class="p-1.5">${ev.equipo === 'local' ? 'Nuestro Equipo' : rival}</td>
                    <td class="p-1.5 font-semibold">${CONFIG_TIPO[ev.tipo].etiqueta}</td>
                    <td class="p-1.5">${ev.equipo === 'visitante' ? ev.jugador : (ev.tipo === 'cambio' ? `Entra ${ev.jugador} / Sale${ev.jugadorSale}` : ev.jugador)}</td>
                </tr>
            `).join('') : '<tr><td colspan="4" class="p-2 text-center text-gray-500">Sin eventos registrados</td></tr>';

            const convocados = jugadoresGlobal.filter(j => convocadosIds.has(j.id));
            let minutosPart = Math.floor(cronoSegundos / 60);
            if(minutosPart === 0 && (estadoPartido === 'finalizado' || eventosGlobal.length > 0)) {
                minutosPart = 90;
            }

            document.getElementById('tablaPdfMinutos').innerHTML = convocados.length > 0 ? convocados.map(j => {
                const minJugados = calcularMinutosAutomaticosJugador(j.id, minutosPart);
                const enCampo = jugadoresEnCampoIds.has(j.id);
                return `
                    <tr class="border-b">
                        <td class="p-1.5 font-bold">#${j.dorsal || '-'}</td>
                        <td class="p-1.5">${j.nombre} ${j.apellidos}</td>
                        <td class="p-1.5 text-center font-bold">${enCampo ? 'En Campo' : 'Banquillo'}</td>
                        <td class="p-1.5 font-bold text-right">${minJugados}'</td>
                    </tr>
                `;
            }).join('') : '<tr><td colspan="4" class="p-2 text-center text-gray-500">Sin lista de convocatoria disponible</td></tr>';

            const seccionInforme = document.getElementById('seccion-informe-vivo-imprimir');
            seccionInforme.classList.remove('hidden');
            window.print();
            seccionInforme.classList.add('hidden');
        }

        /* CRUD PLANTILLA */
        async function renderizarPlantillaModulo() {
            if(!jugadoresGlobal || jugadoresGlobal.length === 0) {
                await cargarDatosDesdeAPI();
            }
            const contenedor = document.getElementById('contenedorListaPlantilla');
            
            if(jugadoresGlobal.length === 0) {
                contenedor.innerHTML = '<p class="text-xs text-gray-400 text-center py-4">No hay jugadores registrados en la plantilla.</p>';
                return;
            }

            contenedor.innerHTML = jugadoresGlobal.map(j => `
                <div class="flex items-center justify-between p-2.5 rounded-lg border bg-gray-50 text-xs">
                    <div class="flex items-center space-x-3">
                        <span class="font-bold text-sm bg-indigo-100 text-indigo-700 w-7 h-7 rounded-full flex items-center justify-center">#${j.dorsal || '-'}</span>
                        <div>
                            <p class="font-bold text-gray-800">${j.nombre} ${j.apellidos}</p>
                            <p class="text-[10px] text-gray-500">${j.posicion || 'Jugador'} - <span class="${(j.estado || 'Disponible') === 'Disponible' ? 'text-green-600' : 'text-red-500'} font-semibold">${j.estado || 'Disponible'}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="abrirModalEditar(${j.id})" class="p-1.5 bg-amber-100 text-amber-700 hover:bg-amber-200 rounded-lg transition" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button onclick="eliminarJugador(${j.id})" class="p-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function mostrarFormNuevoJugador() { document.getElementById('formNuevoJugador').classList.remove('hidden'); }
        function ocultarFormNuevoJugador() { document.getElementById('formNuevoJugador').classList.add('hidden'); }

        async function guardarJugador(e) {
            e.preventDefault();
            const nuevo = {
                nombre: document.getElementById('nuevoNombre').value,
                apellidos: document.getElementById('nuevoApellidos').value,
                dorsal: document.getElementById('nuevoDorsal').value,
                posicion: document.getElementById('nuevaPosicion').value,
                estado: 'Disponible'
            };

            try {
                const res = await fetch(API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Admin-Key': 'CAMBIA_ESTA_CLAVE' },
                    body: JSON.stringify(nuevo)
                });
                
                if(res.ok) {
                    ocultarFormNuevoJugador();
                    await cargarDatosDesdeAPI();
                    renderizarPlantillaModulo();
                } else {
                    alert('Error al guardar jugador');
                }
            } catch(e) {
                console.error("Error guardando jugador:", e);
            }
        }

        function abrirModalEditar(id) {
            const j = jugadoresGlobal.find(item => item.id === id);
            if(!j) return;
            document.getElementById('editId').value = j.id;
            document.getElementById('editNombre').value = j.nombre;
            document.getElementById('editApellidos').value = j.apellidos;
            document.getElementById('editDorsal').value = j.dorsal;
            document.getElementById('editPosicion').value = j.posicion || 'Centrocampista';
            document.getElementById('editEstado').value = j.estado || 'Disponible';
            document.getElementById('modalEditarJugador').classList.remove('hidden');
        }

        function cerrarModalEditarJugador() { document.getElementById('modalEditarJugador').classList.add('hidden'); }

        async function guardarEdicionJugador(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const datos = {
                nombre: document.getElementById('editNombre').value,
                apellidos: document.getElementById('editApellidos').value,
                dorsal: document.getElementById('editDorsal').value,
                posicion: document.getElementById('editPosicion').value,
                estado: document.getElementById('editEstado').value,
            };

            try {
                const res = await fetch(`${API_URL}/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Admin-Key': 'CAMBIA_ESTA_CLAVE' },
                    body: JSON.stringify(datos)
                });

                if(res.ok) {
                    cerrarModalEditarJugador();
                    await cargarDatosDesdeAPI();
                    renderizarPlantillaModulo();
                } else {
                    alert('Error al actualizar jugador');
                }
            } catch(e) {
                console.error("Error actualizando jugador:", e);
            }
        }

        async function eliminarJugador(id) {
            if(!confirm('¿Estás seguro de que deseas eliminar este jugador?')) return;

            try {
                const res = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                if(res.ok) {
                    await cargarDatosDesdeAPI();
                    renderizarPlantillaModulo();
                } else {
                    alert('Error al eliminar jugador');
                }
            } catch(e) {
                console.error("Error eliminando jugador:", e);
            }
        }

        function abrirModalPassword() { document.getElementById('modalCambiarPassword').classList.remove('hidden'); }
        function cerrarModalPassword() { document.getElementById('modalCambiarPassword').classList.add('hidden'); }
        function actualizarPassword(e) { e.preventDefault(); alert('Contraseña actualizada'); cerrarModalPassword(); }
    </script>
</body>
</html>
