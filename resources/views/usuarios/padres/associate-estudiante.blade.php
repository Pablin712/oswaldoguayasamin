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
                    <select id="estudiante_id" name="estudiante_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Estudiante::with('user')->get() as $e)
                            @if(!$padre->estudiantes->contains($e->id))
                                <option value="{{ $e->id }}">{{ $e->codigo_estudiante }} - {{ $e->user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="parentesco" value="Parentesco" />
                    <select id="parentesco" name="parentesco" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="padre">Padre</option>
                        <option value="madre">Madre</option>
                        <option value="tutor">Tutor</option>
                        <option value="otro">Otro</option>
                    </select>
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
