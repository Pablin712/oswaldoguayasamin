@foreach($padre->estudiantes as $estudiante)
    <x-modal name="edit-estudiante-{{ $estudiante->id }}-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Editar Relación
            </h2>

            <form method="POST" action="{{ route('padres.update-estudiante', [$padre, $estudiante]) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <x-input-label for="parentesco_{{ $estudiante->id }}" value="Parentesco" />
                        <select id="parentesco_{{ $estudiante->id }}" name="parentesco" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="padre" {{ $estudiante->pivot->parentesco === 'padre' ? 'selected' : '' }}>Padre</option>
                            <option value="madre" {{ $estudiante->pivot->parentesco === 'madre' ? 'selected' : '' }}>Madre</option>
                            <option value="tutor" {{ $estudiante->pivot->parentesco === 'tutor' ? 'selected' : '' }}>Tutor</option>
                            <option value="otro" {{ $estudiante->pivot->parentesco === 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="es_principal_{{ $estudiante->id }}" name="es_principal" value="1" class="rounded border-gray-300" {{ $estudiante->pivot->es_principal ? 'checked' : '' }}>
                        <label for="es_principal_{{ $estudiante->id }}" class="ml-2 text-sm text-gray-700">Representante Principal</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button type="button" @click="$dispatch('close-modal', 'edit-estudiante-{{ $estudiante->id }}-modal')">
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button>
                        Actualizar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach
