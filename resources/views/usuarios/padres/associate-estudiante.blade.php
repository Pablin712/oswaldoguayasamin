<x-modal name="add-estudiante-modal" maxWidth="md">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Asociar Estudiante
        </h2>

        <form method="POST" action="{{ route('padres.attach-estudiante', $padre) }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <x-input-label for="estudiante_id" value="Seleccionar Estudiante" />
                    @php
                        $estudiantesDisponibles = \App\Models\Estudiante::with('user')
                            ->get()
                            ->filter(fn($e) => !$padre->estudiantes->contains($e->id))
                            ->map(fn($e) => [
                                'id' => $e->id,
                                'name' => $e->codigo_estudiante . ' - ' . $e->user->name
                            ])
                            ->values()
                            ->toArray();
                    @endphp
                    <x-searchable-select
                        id="estudiante_id"
                        name="estudiante_id"
                        :options="$estudiantesDisponibles"
                        placeholder="Buscar estudiante..."
                        :allow-clear="false"
                        :required="true"
                        dropdown-parent="#add-estudiante-modal"
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
                        dropdown-parent="#add-estudiante-modal"
                    />
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="es_principal" name="es_principal" value="1" class="rounded border-gray-300">
                    <label for="es_principal" class="ml-2 text-sm text-gray-700">Representante Principal</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button type="button" @click="$dispatch('close-modal', 'add-estudiante-modal')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button>
                    Asociar
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
