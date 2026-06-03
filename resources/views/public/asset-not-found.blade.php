<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activo no encontrado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        <section class="w-full max-w-2xl text-center">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-red-500 text-white font-black text-2xl shadow-lg">
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

            <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl">
                <p class="text-sm uppercase tracking-widest text-red-400">
                    Consulta pública por QR
                </p>

                <h1 class="mt-3 text-3xl font-bold">
                    Activo no encontrado
                </h1>

                <p class="mt-4 text-slate-300 leading-7">
                    El código QR consultado no corresponde a un activo registrado o el enlace ya no es válido.
                </p>

                <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950/60 p-5 text-sm text-slate-400">
                    <p class="font-semibold text-slate-200">
                        {{ $systemName }}
                    </p>
                    <p class="mt-1">
                        {{ $institutionName }}
                    </p>
                </div>

                <p class="mt-6 text-xs text-slate-500">
                    Si encontraste un activo físico, repórtalo al área correspondiente.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
