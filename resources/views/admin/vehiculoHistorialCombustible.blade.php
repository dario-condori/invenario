<div class="row">
    <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4 table-hover">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Precio</th>
                <th scope="col">Monto<br>cargado</th>
                <th scope="col">Volumen</th>
                <th scope="col">Factura</th>
                <th scope="col">-</th>
            </tr>
        </thead>
        <tbody>
            @php($total_costo=0)
            @php($total_litros=0)
            @forelse ($combustibles as $item)
                @php($total_costo += $item->costo)
                @php($total_litros += $item->volumen)
                <tr>
                    <td>{{ date('d/m/Y',strtotime($item->fecha)) }}</td>
                    <td>{{ $item->precio_unitario }}</td>
                    <td>
                        {{ number_format($item->costo,0) }}_Bs.
                    </td>
                    <td>
                        {{ number_format($item->volumen, 0) }}_lt.
                    </td>
                    <td>
                        00000
                        {{-- {{ $item->usuario->personal[0]->nombres }} {{ $item->usuario->personal[0]->apellido_1 }} --}}
                    </td>
                    <td>
                        {{-- <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Editar productos de la proforma" class="btn btn-success btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                            <span class="btn-label"><i class="fa fa-pen"></i></span>
                        </a> --}}
                        {{-- @if(!count($item->comercios)) --}}
                        {{-- <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Eliminar proforma" class="btn btn-danger btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                            <span class="btn-label"><i class="fa fa-trash"></i></span>
                        </a> --}}
                        {{-- @endif --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Sin historial de combustible ...!!!</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($combustibles))
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">TOTAL</td>
                    <td>{{ number_format($total_costo,0) }}_Bs.</td>
                    <td>{{ number_format($total_litros,0) }}_Bs.</td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
<div class="row">
    <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary mt-4 table-hover">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Servicio</th>
                <th scope="col">Costo<br>servicio</th>
                <th scope="col">Costo<br>material</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php($total_costo_servicio=0)
            @php($total_costo_material=0)
            @forelse ($mantenimiento as $item)
                @php($total_costo_servicio += $item->costo_servicio)
                @php($total_costo_material += $item->costo_material)
                <tr>
                    <td>{{ date('d/m/Y',strtotime($item->fecha)) }}</td>
                    <td>{{ $item->tipoServicio->descripcion }}</td>
                    <td>
                        {{ number_format($item->costo_servicio,2) }}_Bs.
                    </td>
                    <td>
                        {{ number_format($item->costo_material, 2) }}_Bs.
                    </td>
                    <td>
                        {{ number_format($item->costo_servicio + $item->costo_material, 2) }}_Bs.
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Sin servicios de mantenimiento ...!!!</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($mantenimiento))
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">TOTAL</td>
                    <td>{{ number_format($total_costo_servicio,2) }}_Bs.</td>
                    <td>{{ number_format($total_costo_material,2) }}_Bs.</td>
                    <td>{{ number_format($total_costo_servicio + $total_costo_material,2) }}_Bs.</td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>