<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laravel 10 Import Export CSV And EXCEL File - Techsolutionstuff') }}
        </h2>
    </x-slot>

    {{-- controla todos los mensajes --}}
    <x-forms.msgErrorsSession :errors="$errors" :success="session('success', [])" />

    <!-- Formulario de importación -->
    <div class="mx-6 my-6">
        <form method="POST" action="{{ route('banca.import') }}" enctype="multipart/form-data">
            @csrf
            <!-- Token CSRF para el primer formulario -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <!-- Contenido de la primera columna -->
                    <div class="mb-4">
                        <x-input label="Archivo:" placeholder="selecciona un archivo" type="file" name="archivo[]"
                            id="archivo" multiple required />
                    </div>

                    <div class="mb-4">
                        <x-native-select label="Separador de campos:" placeholder="Separador de campos"
                            wire:model="separador_campos" name="separador_campos">
                            <option value=",">Coma (,)</option>
                            <option value=";" selectedf>Punto
                                y coma (;)</option>
                            <option value="\t">Tabulación(/t)
                            </option>
                        </x-native-select>
                    </div>

                    <div class="mb-4">
                        <x-native-select label="Fin de línea:" placeholder="Fin de línea" wire:model="fin_linea"
                            name="fin_linea">
                            <option value="\n">LF (Salto de línea /n)</option>
                            <option value="\r">CR (Retorno de carro /r)</option>
                            <option value="\r\n" selected>CR+LF (Retorno de carro + Salto de línea /r/n)</option>
                            <option value="\x85">NEL (Nueva línea de siguiente línea /x85)</option>
                            <option value="\u2028">LS (Separador de línea /u2028)</option>
                            <option value="\x0B">VT (Tabulación vertical /x0B)</option>
                        </x-native-select>
                    </div>
                </div>

                <div>
                    <!-- Contenido de la segunda columna -->
                    <div class="mb-4">
                        <x-native-select label="Carácter para los strings:" placeholder="Carácter para los strings"
                            wire:model="caracter_string" name="caracter_string">
                            <option value='"' selected>Comillas dobles (")</option>
                            <option value="'">Comillas simples (')</option>
                        </x-native-select>
                    </div>

                    <div class="mb-4">
                        <label for="linea_encabezados">Línea encabezados:</label>
                        <x-input type="text" name="linea_encabezados" id="linea_encabezados" required
                            value="8" />
                    </div>

                    <div class="mb-4 flex justify-center mt-8">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Importar CSV/TSV</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="flex divide-x-4 justify-between mx-10">
        <div class="my-4">
            <div class="text-center md:text-left">
                <span class="font-bold">Total importados:</span> <span class="font-bold">{{ $totalImportados }}</span>
            </div>
        </div>
        <div class="my-4">
            <div class="text-center md:text-left">
                <span class="font-bold">Registros duplicados:</span> <span
                    class="font-bold">{{ $totalDuplicados }}</span>
            </div>
            @if ($totalDuplicados)
                <form action="{{ route('banca.eliminar.duplicados') }}" method="POST" class="mt-4>">
                    @csrf
                    <!-- Token CSRF para el segundo formulario -->
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar
                        Registros Duplicados</button>
                </form>
            @endif

        </div>
        <div class="my-4">
            <div class="text-center md:text-left">
                <span class="font-bold">Total movimientos:</span> <span class="font-bold">{{ $totalMovimientos }}</span>
            </div>
            @if (!$totalDuplicados && $totalImportados > $totalMovimientos)
                <form action="{{ route('banca.crearMovimientos') }}" method="POST" class="mt-4">
                    @csrf
                    <!-- Token CSRF para el tercer formulario -->
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        Pasar registros traspasados a la tabla de movimientos
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Aquí muestra la grilla de datos -->
    @if ($data)
        @livewire('tables.live-tabla', ['data' => $data, 'encabezado' => 'Datos Transferidos', 'titulos' => $titulos, 'campos' => $campos])
    @endif

    </div>
    @push('styles')
        <!-- Estilos específicos de la importación -->
        {{-- @wireuiStyles --}}
    @endpush

    @push('scripts')
        <!-- Scripts específicos de la importación -->
        {{-- @wireuiScripts --}}
    @endpush

    @push('modals')
        <!-- Modales específicos de la importación -->
        <!-- Agrega aquí tus modales -->
    @endpush
</x-app-layout>
