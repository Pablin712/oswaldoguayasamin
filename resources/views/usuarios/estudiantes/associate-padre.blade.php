<x-modal name="add-padre-modal" maxWidth="md">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Asociar Padre/Representante
        </h2>

        <form method="POST" action="{{ route('estudiantes.attach-padre', $estudiante) }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <x-input-label for="padre_id" value="Seleccionar Padre/Representante" />
                    @php
                        $padresDisponibles = \App\Models\Padre::with('user')
                            ->get()
                            ->filter(fn($p) => !$estudiante->padres->contains($p->id))
                            ->map(fn($p) => [
                                'id' => $p->id,
                                'name' => $p->user->name . ' - ' . $p->user->cedula
                            ])
                            ->values()
                            ->toArray();
                    @endphp
                    <x-searchable-select
                        id="padre_id"
                        name="padre_id"
                        :options="$padresDisponibles"
                        placeholder="Buscar padre o representante..."
                        :allow-clear="false"
                        :required="true"
                        dropdown-parent="#add-padre-modal"
                    />
                </div>

                <div>
                    <x-input-label for="parentesco" value="Parentesco" />
                    <x-searchable-select
                        id="parentesco"
                        name="parentesco"
                        :options="[
                            ['id' => 'padre', 'name' => 'Padre'],
                            ['id' => 'madre', 'name' => 'Madre'],
                            ['id' => 'tutor', 'name' => 'Tutor'],
                            ['id' => 'otro', 'name' => 'Otro']
                        ]"
                        placeholder="Seleccione parentesco..."
                        :allow-clear="false"
                        :required="true"
                        dropdown-parent="#add-padre-modal"
                    />
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="es_principal" name="es_principal" value="1" class="rounded border-gray-300">
                    <label for="es_principal" class="ml-2 text-sm text-gray-700">Representante Principal</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button type="button" @click="$dispatch('close-modal', 'add-padre-modal')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button>
                    Asociar
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
