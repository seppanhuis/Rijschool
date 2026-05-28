<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-800 p-6 text-white shadow-lg dark:border-zinc-800">
            <div class="max-w-3xl space-y-3">
                <p class="text-sm font-medium uppercase tracking-[0.24em] text-zinc-300">Rijschool Vierkante Wielen</p>
                <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">Beheer leerlingen, planning en informatie vanuit een rustige administratieomgeving.</h1>
                <p class="max-w-2xl text-sm leading-6 text-zinc-300 sm:text-base">
                    Gebruik de leerling-CRUD voor testdata, service-informatie en snelle navigatie binnen de afgeschermde shell.
                </p>
                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('leerlingen.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-zinc-200" wire:navigate>
                        Naar leerlingen
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Doelgroep</p>
                <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Jongeren met een fysieke beperking</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">De informatievoorziening en planning sluiten aan op persoonlijke begeleiding en duidelijke terugkoppeling.</p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Actieve modules</p>
                <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Leerlingen, instructeurs en mededelingen</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">De app is opgezet om overzicht, communicatie en beheer op één plek samen te brengen.</p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Techniek</p>
                <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Laravel, Blade, Tailwind en SQL</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">Stored procedures en joins ondersteunen de testdata en het overzichtsscherm van de leerlingmodule.</p>
            </div>
        </div>
    </div>
</x-layouts::app>
