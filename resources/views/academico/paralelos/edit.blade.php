<div x-data="{
    id: null,
    curso_id: null,
    periodo_academico_id: null,
    nombre: '',
    aula_id: null,
    cupo_maximo: 30
}" @open-edit-modal.window="
    id = $event.detail.id;
    curso_id = $event.detail.curso_id;
    periodo_academico_id = $event.detail.periodo_academico_id;
    nombre = $event.detail.nombre;
    aula_id = $event.detail.aula_id;
    cupo_maximo = $event.detail.cupo_maximo;
    $dispatch('open-modal', 'edit-paralelo-modal');
">
    <x-modal name="edit-paralelo-modal" maxWidth="lg">
        <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Editar Paralelo
        </h2>

        <form :action="`/paralelos/${id}`" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Curso -->
                <div>
                    <x-input-label for="edit_curso_id" :value="__('Curso *')" />
                    <x-searchable-select
                        id="edit_curso_id"
                        name="curso_id"
                        :options="\App\Models\Curso::orderBy('orden')->get()"
                        placeholder="Seleccione un curso"
                        label-field="nombre"
                        value-field="id"
                        required
                        class="mt-1"
                        x-model="curso_id"
                        dropdown-parent="#edit-paralelo-modal"
                    />
                    <x-input-error :messages="$errors->get('curso_id')" class="mt-2" />
                </div>

                <!-- Período Académico -->
                <div>
                    <x-input-label for="edit_periodo_academico_id" :value="__('Período Académico *')" />
                    <x-searchable-select
                        id="edit_periodo_academico_id"
                        name="periodo_academico_id"
                        :options="\App\Models\PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get()"
                        placeholder="Seleccione un período"
                        label-field="nombre"
                        value-field="id"
                        required
                        class="mt-1"
                        x-model="periodo_academico_id"
                        dropdown-parent="#edit-paralelo-modal"
                    />
                    <x-input-error :messages="$errors->get('periodo_academico_id')" class="mt-2" />
                </div>

                <!-- Nombre -->
                <div>
                    <x-input-label for="edit_nombre" :value="__('Nombre del Paralelo *')" />
                    <x-text-input id="edit_nombre" name="nombre" type="text"
                        class="mt-1 block w-full"
                        x-model="nombre"
                        placeholder="A, B, C, etc."
                        maxlength="10"
                        required />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Ejemplo: A, B, C o Matutino, Vespertino
                    </p>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Aula -->
                <div>
                    <x-input-label for="edit_aula_id" :value="__('Aula')" />
                    <x-searchable-select
                        id="edit_aula_id"
                        name="aula_id"
                        :options="\App\Models\Aula::orderBy('nombre')->get()"
                        placeholder="Sin asignar"
                        label-field="nombre"
                        value-field="id"
                        class="mt-1"
                        x-model="aula_id"
                        dropdown-parent="#edit-paralelo-modal"
                    />
                    <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
                </div>

                <!-- Cupo Máximo -->
                <div>
                    <x-input-label for="edit_cupo_maximo" :value="__('Cupo Máximo *')" />
                    <x-text-input id="edit_cupo_maximo" name="cupo_maximo" type="number"
                        class="mt-1 block w-full"
                        x-model="cupo_maximo"
                        min="1"
                        max="50"
                        required />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Número máximo de estudiantes (1-50)
                    </p>
                    <x-input-error :messages="$errors->get('cupo_maximo')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button type="button" @click="$dispatch('close-modal', 'edit-paralelo-modal')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button>
                    Actualizar
                </x-primary-button>
            </div>
        </form>
    </div>
    </x-modal>
</div>
