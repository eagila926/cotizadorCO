@extends('layouts.app')

@section('title', 'Fórmulas Establecidas | Cotizador Ortomolecular')

@section('content')

<style>
    /*
     * Autocomplete de fórmulas.
     * Se permite que el listado salga fuera de la tarjeta.
     */
    .card-buscador-formulas {
        overflow: visible !important;
        position: relative;
        z-index: 20;
    }

    .card-buscador-formulas .card-body {
        overflow: visible !important;
    }

    .card-buscador-formulas form {
        overflow: visible !important;
    }

    .buscador-formulas-wrapper {
        position: relative;
        overflow: visible !important;
        z-index: 100;
    }

    #sugerencias {
        position: absolute;
        top: calc(100% + 2px);
        left: 0;
        right: 0;

        z-index: 99999;

        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;

        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 6px;

        box-shadow:
            0 4px 8px rgba(0, 0, 0, 0.08),
            0 8px 20px rgba(0, 0, 0, 0.08);
    }

    #sugerencias .list-group-item {
        cursor: pointer;
        background: #ffffff;
        border-left: 0;
        border-right: 0;
    }

    #sugerencias .list-group-item:first-child {
        border-top: 0;
    }

    #sugerencias .list-group-item:last-child {
        border-bottom: 0;
    }

    #sugerencias .list-group-item:hover {
        background: #f8f9fa;
    }

    /*
     * La tarjeta inferior queda detrás del autocomplete.
     */
    .card-buscador-formulas + .card {
        position: relative;
        z-index: 1;
    }
</style>


{{-- ========================================================= --}}
{{-- BUSCADOR DE FÓRMULAS                                      --}}
{{-- ========================================================= --}}

<div class="card mb-3 card-buscador-formulas">

    <div class="card-body">

        <h4 class="mb-3">
            Fórmulas Establecidas
        </h4>

        <form
            action="{{ route('fe.add') }}"
            method="POST"
            class="row g-2 align-items-end"
            autocomplete="off"
        >

            @csrf

            <div class="col-12 col-md-6 position-relative buscador-formulas-wrapper">

                <label for="buscador" class="form-label">
                    Fórmula:
                </label>

                <input
                    type="text"
                    id="buscador"
                    class="form-control"
                    placeholder="Ingrese el código o nombre de la fórmula"
                    autocomplete="off"
                >

                <input
                    type="hidden"
                    name="formula_id"
                    id="formula_id"
                >

                <div
                    id="sugerencias"
                    class="list-group w-100"
                    style="display:none;"
                ></div>

            </div>

            <div class="col-auto">

                <button
                    type="submit"
                    id="btn-add"
                    class="btn btn-primary"
                    disabled
                >
                    Añadir
                </button>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FÓRMULAS SELECCIONADAS                                    --}}
{{-- ========================================================= --}}

<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">
                Fórmulas seleccionadas
            </h5>

            <form
                action="{{ route('fe.clear') }}"
                method="POST"
                onsubmit="return confirm('¿Eliminar todas?');"
            >

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Eliminar todas las fórmulas
                </button>

            </form>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>
                            Nombre Fórmula
                        </th>

                        <th style="width:260px">
                            Tipo Etiqueta
                        </th>

                        <th>
                            Acciones
                        </th>

                        <th>
                            P Médico
                        </th>

                        <th>
                            P Distribuidor
                        </th>

                        <th>
                            P Paciente
                        </th>

                        <th>
                            Eliminar
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($rows as $r)

                        <tr data-id="{{ $r->id }}">

                            {{-- Nombre / código --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $r->codigo }}
                                </div>

                                <small class="text-muted">
                                    {{ $r->nombre_etiqueta }}
                                </small>

                            </td>


                            {{-- Tipo de etiqueta --}}
                            <td>

                                <select
                                    class="form-select form-select-sm sel-tipo"
                                >

                                    @foreach($tipos as $t)

                                        <option
                                            value="{{ $t }}"
                                            {{ $r->tipo === $t ? 'selected' : '' }}
                                        >
                                            {{ $t }}
                                        </option>

                                    @endforeach

                                </select>

                            </td>


                            {{-- Acciones --}}
                            <td class="text-nowrap">

                                {{-- Imprimir --}}
                                <a
                                    class="btn btn-secondary btn-sm"
                                    href="{{ route('fe.print', $r->id) }}"
                                    target="_blank"
                                    title="Imprimir"
                                >
                                    <i class="bi bi-printer"></i>
                                </a>


                                {{-- Ver ítems --}}
                                <a
                                    class="btn btn-success btn-sm"
                                    href="{{ route('fe.items', $r->id) }}"
                                    title="Ver ítems"
                                >
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>


                                {{-- Editar --}}
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ route('formulas.editar.cargar', $r->id) }}"
                                    title="Editar"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>


                                {{-- Generar receta PDF --}}
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm btn-receta-pdf"
                                    data-id="{{ $r->id }}"
                                    data-codigo="{{ $r->codigo }}"
                                    title="Receta PDF"
                                >
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>

                            </td>


                            {{-- Precios --}}
                            <td>
                                {{ number_format($r->precio_medico, 2) }}
                            </td>

                            <td>
                                {{ number_format($r->precio_distribuidor, 2) }}
                            </td>

                            <td>
                                {{ number_format($r->precio_publico, 2) }}
                            </td>


                            {{-- Eliminar --}}
                            <td>

                                <form
                                    action="{{ route('fe.remove', $r->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar esta fila?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted"
                            >
                                Sin registros.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Bootstrap Icons --}}
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>


{{-- ========================================================= --}}
{{-- AUTOCOMPLETE FÓRMULAS                                     --}}
{{-- ========================================================= --}}

<script>
(function () {

    const $buscador = document.getElementById('buscador');
    const $sugs = document.getElementById('sugerencias');
    const $idHidden = document.getElementById('formula_id');
    const $btnAdd = document.getElementById('btn-add');

    let timerBusqueda = null;


    /*
     * Limpiar selección.
     */
    function limpiarSeleccion() {

        $idHidden.value = '';
        $btnAdd.disabled = true;

    }


    /*
     * Ocultar sugerencias.
     */
    function ocultarSugerencias() {

        $sugs.style.display = 'none';
        $sugs.innerHTML = '';

    }


    /*
     * Buscar fórmulas.
     */
    $buscador.addEventListener('input', function () {

        const q = this.value.trim();

        limpiarSeleccion();


        if (timerBusqueda) {
            clearTimeout(timerBusqueda);
        }


        if (q.length < 2) {

            ocultarSugerencias();

            return;

        }


        timerBusqueda = setTimeout(function () {

            fetch(
                `{{ route('fe.buscar') }}?q=${encodeURIComponent(q)}`,
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            )

            .then(async response => {

                if (!response.ok) {

                    const errorText = await response.text();

                    console.error(
                        'Error búsqueda de fórmulas:',
                        response.status,
                        errorText
                    );

                    throw new Error(
                        `Error HTTP ${response.status}`
                    );

                }

                return response.json();

            })

            .then(data => {

                $sugs.innerHTML = '';


                if (!Array.isArray(data) || data.length === 0) {

                    const noResultados =
                        document.createElement('div');

                    noResultados.className =
                        'list-group-item text-muted';

                    noResultados.textContent =
                        'No se encontraron fórmulas.';

                    $sugs.appendChild(noResultados);

                    $sugs.style.display = 'block';

                    return;

                }


                data.forEach(function (it) {

                    const opcion =
                        document.createElement('button');


                    opcion.type = 'button';

                    opcion.className =
                        'list-group-item list-group-item-action';

                    opcion.textContent =
                        it.display;


                    opcion.addEventListener(
                        'click',
                        function () {

                            $buscador.value =
                                it.display;

                            $idHidden.value =
                                it.id;

                            $btnAdd.disabled =
                                false;

                            ocultarSugerencias();

                        }
                    );


                    $sugs.appendChild(opcion);

                });


                $sugs.style.display =
                    'block';

            })

            .catch(error => {

                console.error(
                    'Error autocomplete:',
                    error
                );

                $sugs.innerHTML = '';


                const mensaje =
                    document.createElement('div');

                mensaje.className =
                    'list-group-item text-danger';

                mensaje.textContent =
                    'Error al buscar fórmulas.';


                $sugs.appendChild(mensaje);

                $sugs.style.display =
                    'block';

            });

        }, 220);

    });


    /*
     * Cerrar autocomplete al hacer clic fuera.
     */
    document.addEventListener(
        'click',
        function (e) {

            if (
                !e.target.closest('#sugerencias') &&
                e.target !== $buscador
            ) {

                $sugs.style.display =
                    'none';

            }

        }
    );


    /*
     * Actualizar tipo de etiqueta.
     */
    document
        .querySelectorAll('.sel-tipo')
        .forEach(function (select) {

            select.addEventListener(
                'change',
                function () {

                    const row =
                        this.closest('tr');

                    const id =
                        row.dataset.id;


                    fetch(
                        `{{ route('fe.update') }}`,
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'

                            },

                            body: JSON.stringify({

                                formula_id: id,

                                tipo:
                                    this.value

                            })

                        }
                    )

                    .then(response => {

                        if (!response.ok) {

                            console.error(
                                'Error actualizando tipo:',
                                response.status
                            );

                        }

                    })

                    .catch(error => {

                        console.error(
                            'Error actualizando tipo:',
                            error
                        );

                    });

                }
            );

        });

})();
</script>



{{-- ========================================================= --}}
{{-- MODAL CREAR RECETA                                        --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="modalCrearRecetaFE"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                id="formCrearRecetaFE"
                method="POST"
            >

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">
                        Generar Receta
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"
                    ></button>

                </div>


                <div class="modal-body">


                    {{-- Fórmula --}}
                    <div class="mb-2">

                        <label
                            for="receta_formula_display"
                            class="form-label"
                        >
                            Fórmula
                        </label>

                        <input
                            type="text"
                            id="receta_formula_display"
                            class="form-control"
                            readonly
                        >

                    </div>


                    {{-- SO --}}
                    <div class="mb-2">

                        <label class="form-label">
                            SO
                        </label>

                        <input
                            type="text"
                            name="so"
                            class="form-control"
                            required
                            pattern="\d+"
                        >

                    </div>


                    {{-- Médico --}}
                    <div class="mb-2 position-relative">

                        <label
                            for="buscaMedReceta"
                            class="form-label"
                        >
                            Buscar médico
                        </label>

                        <input
                            type="text"
                            id="buscaMedReceta"
                            class="form-control"
                            placeholder="Nombre o cédula"
                            autocomplete="off"
                        >

                        <input
                            type="hidden"
                            name="cedula_medico"
                            id="cedula_medico"
                        >


                        <div
                            id="medicoStatusReceta"
                            class="form-text text-danger d-none"
                        >
                            Debe seleccionar un médico con firma para descargar el PDF.
                        </div>


                        <div
                            id="resBuscaMedReceta"
                            class="list-group mt-1"
                            style="
                                max-height:180px;
                                overflow:auto;
                                display:none;
                            "
                        ></div>

                    </div>


                    {{-- Paciente --}}
                    <div class="mb-2">

                        <label class="form-label">
                            Paciente (opcional)
                        </label>

                        <input
                            type="text"
                            name="paciente"
                            class="form-control"
                        >

                    </div>


                    {{-- Frascos --}}
                    <div class="mb-2">

                        <label class="form-label">
                            N° frascos
                        </label>

                        <input
                            type="number"
                            name="num_frascos"
                            class="form-control"
                            min="1"
                            value="1"
                        >

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cerrar
                    </button>


                    <button
                        type="button"
                        id="btnGenerarRecetaFE"
                        class="btn btn-primary"
                    >
                        Generar y descargar PDF
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- CONTROL MODAL RECETA                                      --}}
{{-- ========================================================= --}}

<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const modalEl =
            document.getElementById(
                'modalCrearRecetaFE'
            );

        const btnGenerar =
            document.getElementById(
                'btnGenerarRecetaFE'
            );

        const form =
            document.getElementById(
                'formCrearRecetaFE'
            );

        const status =
            document.getElementById(
                'medicoStatusReceta'
            );


        if (!modalEl || !btnGenerar || !form) {
            return;
        }


        const modal =
            new bootstrap.Modal(
                modalEl
            );


        btnGenerar.disabled =
            true;


        if (status) {

            status.classList.add(
                'd-none'
            );

            status.textContent =
                '';

        }


        /*
         * Cuadro de errores.
         */
        const errorBox =
            document.createElement('div');


        errorBox.className =
            'alert alert-danger d-none';

        errorBox.id =
            'errorRecetaFE';


        form
            .querySelector('.modal-body')
            .insertBefore(
                errorBox,
                form.querySelector(
                    '.modal-body'
                ).firstChild
            );


        /*
         * Abrir modal.
         */
        document
            .querySelectorAll(
                '.btn-receta-pdf'
            )
            .forEach(function (btn) {

                btn.addEventListener(
                    'click',
                    function () {

                        const id =
                            this.dataset.id;

                        const codigo =
                            this.dataset.codigo;


                        form.reset();


                        form.action =
                            `{{ url('formulas/establecidas') }}/${id}/receta`;


                        document
                            .getElementById(
                                'receta_formula_display'
                            )
                            .value =
                            codigo;


                        document
                            .getElementById(
                                'buscaMedReceta'
                            )
                            .value =
                            '';


                        document
                            .getElementById(
                                'cedula_medico'
                            )
                            .value =
                            '';


                        const resultados =
                            document.getElementById(
                                'resBuscaMedReceta'
                            );


                        resultados.innerHTML =
                            '';

                        resultados.style.display =
                            'none';


                        errorBox.classList.add(
                            'd-none'
                        );

                        errorBox.textContent =
                            '';


                        if (status) {

                            status.classList.add(
                                'd-none'
                            );

                            status.textContent =
                                '';

                        }


                        btnGenerar.disabled =
                            true;


                        modal.show();

                    }
                );

            });


        /*
         * Generar PDF.
         */
        btnGenerar.addEventListener(
            'click',
            function () {

                errorBox.classList.add(
                    'd-none'
                );

                errorBox.textContent =
                    '';

                btnGenerar.disabled =
                    true;


                window
                    .submitPdfFormWithPublicLinks(
                        form,
                        {
                            defaultFilename:
                                'receta.pdf',

                            errorMessage:
                                'Error al generar la receta.'
                        }
                    )

                    .then(function () {

                        btnGenerar.disabled =
                            false;

                        modal.hide();

                    })

                    .catch(function (err) {

                        btnGenerar.disabled =
                            false;

                        errorBox.textContent =
                            err.message ||
                            'No se pudo generar el PDF. Intente otra vez.';

                        errorBox.classList.remove(
                            'd-none'
                        );

                    });

            }
        );

    }
);
</script>



{{-- ========================================================= --}}
{{-- AUTOCOMPLETE MÉDICOS                                      --}}
{{-- ========================================================= --}}

<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const $input =
            document.getElementById(
                'buscaMedReceta'
            );

        const $res =
            document.getElementById(
                'resBuscaMedReceta'
            );

        const $hidden =
            document.getElementById(
                'cedula_medico'
            );

        const $btnGenerar =
            document.getElementById(
                'btnGenerarRecetaFE'
            );

        const $status =
            document.getElementById(
                'medicoStatusReceta'
            );


        if (!$input) {
            return;
        }


        let timerMedico = null;


        if ($btnGenerar) {

            $btnGenerar.disabled =
                true;

        }


        if ($status) {

            $status.classList.add(
                'd-none'
            );

        }


        /*
         * Buscar médico.
         */
        $input.addEventListener(
            'input',
            function () {

                const q =
                    this.value.trim();


                $res.innerHTML =
                    '';

                $res.style.display =
                    'none';

                $hidden.value =
                    '';


                if ($btnGenerar) {

                    $btnGenerar.disabled =
                        true;

                }


                if ($status) {

                    $status.classList.add(
                        'd-none'
                    );

                    $status.textContent =
                        '';

                }


                if (timerMedico) {

                    clearTimeout(
                        timerMedico
                    );

                }


                if (q.length < 2) {
                    return;
                }


                timerMedico =
                    setTimeout(
                        function () {

                            fetch(
                                `{{ route('medicos.buscar') }}?q=${encodeURIComponent(q)}`,
                                {
                                    headers: {
                                        'Accept':
                                            'application/json'
                                    }
                                }
                            )

                            .then(
                                async function (
                                    response
                                ) {

                                    if (
                                        !response.ok
                                    ) {

                                        const text =
                                            await response.text();

                                        console.error(
                                            'Error buscando médico:',
                                            response.status,
                                            text
                                        );

                                        throw new Error(
                                            `HTTP ${response.status}`
                                        );

                                    }

                                    return response.json();

                                }
                            )

                            .then(
                                function (data) {

                                    $res.innerHTML =
                                        '';


                                    if (
                                        !Array.isArray(data) ||
                                        data.length === 0
                                    ) {

                                        const item =
                                            document.createElement(
                                                'div'
                                            );

                                        item.className =
                                            'list-group-item';

                                        item.textContent =
                                            'No se encontraron médicos.';


                                        $res.appendChild(
                                            item
                                        );

                                        $res.style.display =
                                            'block';

                                        return;

                                    }


                                    data.forEach(
                                        function (it) {

                                            const firmaOk =
                                                !!it.firma;


                                            const btn =
                                                document.createElement(
                                                    'button'
                                                );


                                            btn.type =
                                                'button';


                                            btn.className =
                                                'list-group-item list-group-item-action d-flex justify-content-between align-items-center';


                                            const contenido =
                                                document.createElement(
                                                    'div'
                                                );


                                            const nombre =
                                                document.createElement(
                                                    'strong'
                                                );

                                            nombre.textContent =
                                                it.label;


                                            const cedula =
                                                document.createElement(
                                                    'div'
                                                );

                                            cedula.className =
                                                'small text-muted';

                                            cedula.textContent =
                                                it.cedula;


                                            contenido.appendChild(
                                                nombre
                                            );

                                            contenido.appendChild(
                                                cedula
                                            );


                                            const badge =
                                                document.createElement(
                                                    'span'
                                                );


                                            badge.className =
                                                firmaOk
                                                    ? 'badge bg-success'
                                                    : 'badge bg-danger';


                                            badge.textContent =
                                                firmaOk
                                                    ? 'Firma'
                                                    : 'Sin firma';


                                            btn.appendChild(
                                                contenido
                                            );

                                            btn.appendChild(
                                                badge
                                            );


                                            btn.addEventListener(
                                                'click',
                                                function () {

                                                    $hidden.value =
                                                        it.cedula;

                                                    $input.value =
                                                        it.label;

                                                    $res.innerHTML =
                                                        '';

                                                    $res.style.display =
                                                        'none';


                                                    if (
                                                        !firmaOk
                                                    ) {

                                                        if (
                                                            $status
                                                        ) {

                                                            $status.textContent =
                                                                'El médico seleccionado no tiene firma. No se puede generar el PDF.';

                                                            $status.classList.remove(
                                                                'd-none'
                                                            );

                                                        }


                                                        if (
                                                            $btnGenerar
                                                        ) {

                                                            $btnGenerar.disabled =
                                                                true;

                                                        }

                                                    } else {

                                                        if (
                                                            $status
                                                        ) {

                                                            $status.classList.add(
                                                                'd-none'
                                                            );

                                                            $status.textContent =
                                                                '';

                                                        }


                                                        if (
                                                            $btnGenerar
                                                        ) {

                                                            $btnGenerar.disabled =
                                                                false;

                                                        }

                                                    }

                                                }
                                            );


                                            $res.appendChild(
                                                btn
                                            );

                                        }
                                    );


                                    $res.style.display =
                                        'block';

                                }
                            )

                            .catch(
                                function (error) {

                                    console.error(
                                        'Error buscando médicos:',
                                        error
                                    );

                                }
                            );

                        },
                        180
                    );

            }
        );


        /*
         * Cerrar resultados al hacer click afuera.
         */
        document.addEventListener(
            'click',
            function (e) {

                if (
                    !e.target.closest(
                        '#resBuscaMedReceta'
                    ) &&
                    e.target !== $input
                ) {

                    $res.style.display =
                        'none';

                }

            }
        );

    }
);
</script>

@endsection