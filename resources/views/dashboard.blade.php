<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Glow Beauty Salon CRM</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#fffaf7] text-slate-900 antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-[250px_1fr]">
            <aside class="bg-[#20151b] px-5 py-6 text-white lg:min-h-screen">
                <div class="flex items-center gap-3">
                    <div class="grid size-11 place-items-center rounded-2xl bg-gradient-to-br from-rose-400 to-orange-300 text-xl font-black text-[#3b1726] shadow-lg shadow-rose-950/30">G</div>
                    <div>
                        <p class="font-semibold tracking-tight">Glow Beauty</p>
                        <p class="text-xs text-rose-200">Salon CRM</p>
                    </div>
                </div>

                <nav class="mt-10 flex gap-2 overflow-x-auto pb-2 lg:flex-col lg:overflow-visible" aria-label="Primary navigation">
                    <a class="flex items-center gap-3 rounded-xl bg-white/12 px-4 py-3 text-sm font-semibold text-white" href="{{ route('dashboard') }}">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3v10Zm0 8h8v-4H3v4Zm12 0h6V11h-6v10Zm0-18v4h6V3h-6Z"/></svg>
                        Overview
                    </a>
                    <span class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-rose-100/65">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm13 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Leads
                    </span>
                    <span class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-rose-100/65">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/></svg>
                        Follow-ups
                    </span>
                    <span class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-rose-100/65">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4zM8 8h8M8 12h6M8 16h4"/></svg>
                        Templates
                    </span>
                </nav>

                <div class="mt-10 rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs font-medium uppercase tracking-[0.16em] text-rose-200">Today at Glow</p>
                    <p class="mt-2 text-2xl font-semibold">{{ $pendingReminderCount }}</p>
                    <p class="mt-1 text-sm leading-5 text-rose-100/70">client follow-ups are ready for your team.</p>
                </div>
            </aside>

            <main class="min-w-0 p-5 sm:p-8 lg:p-10">
                <header class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-rose-500">Monday, {{ now()->format('F j') }}</p>
                        <h1 class="mt-1 text-3xl font-bold tracking-tight text-[#261a20] sm:text-4xl">Good morning, Glow team.</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">A beautiful day to turn consultations into loyal clients.</p>
                    </div>
                    <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#311922] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/15 transition hover:-translate-y-0.5 hover:bg-[#482330]">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                        Add new lead
                    </button>
                </header>

                <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="CRM summary">
                    <article class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between"><span class="grid size-10 place-items-center rounded-xl bg-rose-50 text-rose-500"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg></span><span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></div>
                        <p class="mt-5 text-3xl font-bold tracking-tight">{{ $leadCount }}</p><p class="mt-1 text-sm text-slate-500">Leads in your pipeline</p>
                    </article>
                    <article class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm">
                        <span class="grid size-10 place-items-center rounded-xl bg-orange-50 text-orange-500"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18M7 15l4-4 3 3 5-7"/></svg></span>
                        <p class="mt-5 text-3xl font-bold tracking-tight">{{ \Illuminate\Support\Number::currency($pipelineValue, 'PKR', 'en_PK') }}</p><p class="mt-1 text-sm text-slate-500">Potential salon revenue</p>
                    </article>
                    <article class="rounded-2xl border border-violet-100 bg-white p-5 shadow-sm">
                        <span class="grid size-10 place-items-center rounded-xl bg-violet-50 text-violet-500"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/></svg></span>
                        <p class="mt-5 text-3xl font-bold tracking-tight">{{ $pendingReminderCount }}</p><p class="mt-1 text-sm text-slate-500">Follow-ups to complete</p>
                    </article>
                    <article class="rounded-2xl border border-teal-100 bg-white p-5 shadow-sm">
                        <span class="grid size-10 place-items-center rounded-xl bg-teal-50 text-teal-500"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4zM8 8h8M8 12h6M8 16h4"/></svg></span>
                        <p class="mt-5 text-3xl font-bold tracking-tight">{{ $activeTemplateCount }}</p><p class="mt-1 text-sm text-slate-500">Ready-to-send templates</p>
                    </article>
                </section>

                <section class="mt-8 rounded-2xl border border-rose-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between"><div><p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-500">Your sales flow</p><h2 class="mt-1 text-xl font-bold tracking-tight">Pipeline overview</h2></div><span class="text-sm text-slate-400">{{ $leadCount }} total leads</span></div>
                    <div class="mt-6 grid gap-3 md:grid-cols-3">
                        @foreach ($pipelineStages as $stage)
                            <div class="rounded-xl bg-slate-50 p-4">
                                <div class="flex items-center justify-between"><span class="flex items-center gap-2 text-sm font-semibold"><span class="size-2.5 rounded-full" style="background-color: {{ $stage->color }}"></span>{{ $stage->name }}</span><span class="text-lg font-bold">{{ $stage->leads_count }}</span></div>
                                <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200"><div class="h-full rounded-full" style="width: {{ $leadCount > 0 ? max(8, ($stage->leads_count / $leadCount) * 100) : 0 }}%; background-color: {{ $stage->color }}"></div></div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="mt-8 grid gap-8 xl:grid-cols-[minmax(0,1.45fr)_minmax(320px,0.85fr)]">
                    <section class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm">
                        <div class="flex items-center justify-between px-5 py-5 sm:px-6"><div><h2 class="text-xl font-bold tracking-tight">Latest leads</h2><p class="mt-1 text-sm text-slate-500">Fresh conversations waiting to glow.</p></div><span class="text-sm font-semibold text-rose-500">All leads →</span></div>
                        <div class="overflow-x-auto"><table class="w-full min-w-[620px] text-left text-sm"><thead class="border-y border-slate-100 bg-slate-50 text-xs uppercase tracking-wider text-slate-400"><tr><th class="px-6 py-3 font-semibold">Client</th><th class="px-4 py-3 font-semibold">Stage</th><th class="px-4 py-3 font-semibold">Value</th><th class="px-6 py-3 font-semibold">Follow-up</th></tr></thead><tbody class="divide-y divide-slate-100">
                            @forelse ($leads as $lead)
                                <tr class="transition hover:bg-rose-50/40"><td class="px-6 py-4"><div class="flex items-center gap-3"><span class="grid size-9 place-items-center rounded-full bg-gradient-to-br from-rose-100 to-orange-100 text-xs font-bold text-rose-700">{{ strtoupper(mb_substr($lead->first_name, 0, 1).mb_substr($lead->last_name ?? '', 0, 1)) }}</span><div><p class="font-semibold text-slate-800">{{ $lead->first_name }} {{ $lead->last_name }}</p><p class="mt-0.5 text-xs text-slate-400">{{ $lead->source }}</p></div></div></td><td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><span class="size-1.5 rounded-full" style="background-color: {{ $lead->pipelineStage->color }}"></span>{{ $lead->pipelineStage->name }}</span></td><td class="px-4 py-4 font-semibold text-slate-700">{{ $lead->estimated_value ? \Illuminate\Support\Number::currency($lead->estimated_value, 'PKR', 'en_PK') : '—' }}</td><td class="px-6 py-4"><p class="font-medium text-slate-700">{{ $lead->next_follow_up_at?->format('M j') ?? 'Not set' }}</p><p class="mt-0.5 text-xs text-rose-500">{{ $lead->pending_reminders_count }} open {{ \Illuminate\Support\Str::plural('reminder', $lead->pending_reminders_count) }}</p></td></tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-500">No leads yet. Add your first salon enquiry to get started.</td></tr>
                            @endforelse
                        </tbody></table></div>
                    </section>

                    <div class="space-y-8">
                        <section class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm sm:p-6"><div class="flex items-center justify-between"><div><h2 class="text-xl font-bold tracking-tight">Upcoming glow-ups</h2><p class="mt-1 text-sm text-slate-500">Keep every client feeling cared for.</p></div><span class="grid size-9 place-items-center rounded-xl bg-rose-50 text-rose-500"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/></svg></span></div><div class="mt-5 space-y-4">
                            @forelse ($upcomingReminders as $reminder)
                                <div class="flex gap-3"><div class="mt-1 grid size-9 shrink-0 place-items-center rounded-full bg-orange-50 text-orange-500"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 2M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"/></svg></div><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ $reminder->title }}</p><p class="mt-1 text-xs text-slate-500">{{ $reminder->lead->first_name }} {{ $reminder->lead->last_name }} · {{ ucfirst($reminder->channel) }}</p><p class="mt-1 text-xs font-semibold text-rose-500">{{ $reminder->due_at->diffForHumans() }}</p></div></div>
                            @empty
                                <p class="py-4 text-sm text-slate-500">Your follow-up list is clear.</p>
                            @endforelse
                        </div></section>

                        <section class="rounded-2xl bg-[#311922] p-5 text-white shadow-lg shadow-rose-950/15 sm:p-6"><p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-200">Client pulse</p><h2 class="mt-2 text-xl font-bold">Recent activity</h2><div class="mt-5 space-y-4 border-l border-rose-300/30 pl-5">
                            @forelse ($recentActivities as $activity)
                                <div class="relative"><span class="absolute -left-[1.72rem] top-1 size-2.5 rounded-full border-2 border-[#311922] bg-rose-300"></span><p class="text-sm font-semibold">{{ $activity->subject }}</p><p class="mt-1 text-xs text-rose-100/70">{{ $activity->lead->first_name }} {{ $activity->lead->last_name }} · {{ $activity->occurred_at->diffForHumans() }}</p></div>
                            @empty
                                <p class="text-sm text-rose-100/70">Activity will appear here as your team follows up.</p>
                            @endforelse
                        </div></section>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
