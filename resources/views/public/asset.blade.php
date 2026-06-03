<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta pública del activo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        <section class="w-full max-w-4xl">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500 text-slate-950 font-black text-2xl shadow-lg">
                    <div class="mb-8 flex items-center justify-center gap-6">
    <img
        src="{{ asset('images/logos/IHE.jpg') }}"
        alt="Logo institución"
        class="h-28 w-auto max-w-[300px] rounded-2xl object-contain bg-white p-2 shadow-lg md:h-32"
    >

    <img
        src="{{ asset('images/logos/Logo_escuela.jpg') }}"
        alt="Logo sistema"
        class="h-28 w-auto max-w-[300px] rounded-2xl object-contain bg-white p-2 shadow-lg md:h-32"
    >
</div>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
                    {{ $systemName }}
                </h1>

                <p class="mt-2 text-sm md:text-base text-slate-400">
                    {{ $institutionName }}
                </p>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl">
                <div class="border-b border-slate-800 px-6 py-5 md:px-8">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-widest text-amber-400">
                                Consulta pública por QR
                            </p>

                            <h2 class="mt-1 text-2xl font-bold">
                                Información pública del activo
                            </h2>
                        </div>

                        @if($activo->estaDadoDeBaja())
                            <div class="rounded-full border border-red-500/40 bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-300">
                                Activo dado de baja
                            </div>
                        @else
                            <div class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-300">
                                Activo registrado
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid gap-6 p-6 md:grid-cols-[1.1fr_.9fr] md:p-8">
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                            <p class="text-sm text-slate-400">Nombre del activo</p>
                            <p class="mt-2 text-2xl font-bold text-white">
                                {{ $activo->nombre }}
                            </p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                                <p class="text-sm text-slate-400">Marca</p>
                                <p class="mt-2 text-lg font-semibold text-white">
                                    {{ $activo->marca ?: 'No especificada' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                                <p class="text-sm text-slate-400">Ubicación general</p>

                                @if($ubicacionVigente)
                                    <p class="mt-2 text-lg font-semibold text-white">
                                        {{ $ubicacionVigente->nombre }}
                                    </p>
                                @else
                                    <p class="mt-2 text-sm font-medium text-amber-300">
                                        Este activo no tiene una ubicación vigente registrada.
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if($activo->estaDadoDeBaja())
                            <div class="rounded-2xl border border-red-500/40 bg-red-500/10 p-5">
                                <p class="font-semibold text-red-300">
                                    Aviso
                                </p>
                                <p class="mt-1 text-sm text-red-100">
                                    Este activo se encuentra dado de baja y ya no forma parte del inventario operativo.
                                </p>
                            </div>
                        @endif

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                            <p class="text-sm text-slate-400">Información mostrada</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                Esta página muestra únicamente datos públicos del activo. La información administrativa,
                                técnica, económica, de responsables y de auditoría permanece restringida al personal autorizado.
                            </p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                        <p class="mb-4 text-sm text-slate-400">Fotografía del activo</p>

                        @if($activo->foto_url)
                            <img
                                src="{{ asset('storage/' . $activo->foto_url) }}"
                                alt="Fotografía pública del activo"
                                class="h-72 w-full rounded-2xl object-cover border border-slate-800 bg-slate-900"
                            >
                        @else
                            <div class="flex h-72 w-full items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-900 text-center text-slate-400">
                                Sin fotografía disponible
                            </div>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-800 px-6 py-4 text-center text-xs text-slate-500 md:px-8">
                    Acceso público generado mediante código QR institucional.
                </div>
            </div>
        </section>
    </main>
</body>
</html>
