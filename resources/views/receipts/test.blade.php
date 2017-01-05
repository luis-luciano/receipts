<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            
        </style>
    </head>
    <body>
        @foreach($contracts as $contract)
            <div class="content">
                <div class="dateOfIssue"><strong>FECHA DE EMISION: {{ $dateOfIssue }}</strong></div>
                <header>
                    <div class="contrato">
                        <p><strong>{{ (int)$contract->contrato }}</strong>
                        </p>
                    </div>

                    <div class="recibo1">
                        <p><strong>{{ $contract->receipt_number }}</strong>
                        </p>
                    </div>

                    <div class="vencim">
                        <p><strong>{{ $contract->due_date }}</strong>
                        </p>
                    </div>

                    <div class="mesF">
                        <p>{{ $contract->invoiced_month }}</p>
                    </div>

                    <div class="medidor">
                        <p>{{ trim($contract->medidor) }}</p>
                    </div>

                    <div class="sec">
                        <p>{{ $contract->sector }}</p>
                    </div>

                    <div class="rut">
                        <p>{{ $contract->ruta }}</p>
                    </div>

                    <div class="folio">
                        <p>{{ $contract->folio }}</p>
                    </div>

                    @if(!is_null($lecture = $contract->lecture))
                        <div class="ant">
                            <p>
                                {{ $lecture->lec_anterior }}
                            </p>
                        </div>
                        <div class="act">
                            <p>
                                {{ $lecture->lec_actual }}
                            </p>
                        </div>
                        <div class="consm">
                            <p>
                                {{ $lecture->consumo }}
                            </p>
                        </div>
                    @endif

                    <div class="prom">
                        <p>
                            {{ $contract->cons_promedio }}
                        </p>
                    </div>
                    <div class="mrezago">
                        <p>
                            {{ $contract->pagos_ven}}
                        </p>
                    </div>

                    <div class="nombre">
                        <p>
                            {{ trim($contract->nombre) }}
                        </p>
                    </div>
                    <div class="rfc">
                        <p>
                            {{ trim($contract->rfc_u) }}
                        </p>
                    </div>
                    <div class="tarifa">
                        <p>
                            {{ $contract->rate_description }}
                        </p>
                    </div>
                    <div class="direcc">
                        <p>
                            {!! $contract->service_address !!}
                        </p>
                    </div>
                    <div class="direccF">
                        <p>
                            {{ $contract->fiscal_address }}
                        </p>
                    </div>
                    <div class="ccatastral">
                        <p>
                            {{ $contract->cve_ubica }}
                        </p>
                    </div>
                </header>

                <section>
                    <table class="t1">
                        @if(!is_null($details = $contract->details))
                            @foreach ($details as $detail)
                                <tr>
                                    <td style="text-align: left">{{ transConcept($detail->concepto, $detail->descripcion) }} </td>
                                    <td>{{ ((float) $detail->importe_a != 0) ? trim($detail->importe_a) : "" }} </td>
                                    <td>{{ ((float) $detail->importe_v != 0) ? trim($detail->importe_v) : "" }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>

                    <div class="fact">FACTURACIÓN 2016</div>
                    <div class="total_description">
                        {{ $contract->total_format }}
                    </div>
                    <div class="total1">
                        {{ $contract->total }}
                    </div>

                    <div class="logo_mes">
                    {{-- <img class="logo_m" src="{{ asset('/assets/img/receipt/mes_recib.png') }}">   --}}
                       
                    </div>
                </section>
                <aside>
                    <table class="t2">
                        @if(!is_null($normalDetails = $contract->normalDetails))
                            @foreach ($normalDetails as $detail)
                                <tr>
                                    <td style="text-align: left">{{ $detail->concepto }} </td>
                                    <td>{{ ((float) $detail->cargo_mes != 0) ? trim($detail->cargo_mes) : "" }} </td>
                                    <td>{{ ((float) $detail->abono != 0) ? trim($detail->abono) : "" }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <div class="total_description2">
                        @if(!is_null($due = $contract->due))
                            {{ descriptiveAmount($due->totalAPagar) }}
                        @endif
                    </div>
                    <div class="total2">
                        @if(!is_null($due))
                            {{ $due->totalAPagar }}
                        @endif
                    </div>
                    <div class="recibo2">
                        @if(!is_null($normalHeader = $contract->normalHeader))
                            {{ $normalHeader->recibo }}
                        @endif
                    </div>
                </aside>
                <footer>
                    <table class="t3">
                        @if(!is_null($details = $contract->details))
                            @foreach ($details as $detail)
                                <tr>
                                    <td style="text-align: left">{{ transConcept($detail->concepto, $detail->descripcion) }} </td>
                                    <td>{{ ((float) $detail->importe_a != 0) ? trim($detail->importe_a) : "" }} </td>
                                    <td>{{ ((float) $detail->importe_v != 0) ? trim($detail->importe_v) : "" }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <div class="totalFA">
                        {{ $contract->total }}
                    </div>
                    <table class="t4">
                        @if(!is_null($normalDetails = $contract->normalDetails))
                            @foreach ($normalDetails as $detail)
                                <tr>
                                    <td style="text-align: left">{{ $detail->concepto }} </td>
                                    <td>{{ ((float) $detail->cargo_mes != 0) ? trim($detail->cargo_mes) : "" }} </td>
                                    <td>{{ ((float) $detail->abono != 0) ? trim($detail->abono) : "" }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <div class="totalPA">
                        @if(!is_null($due))
                            {{ $due->totalAPagar }}
                        @endif
                    </div>

                    <div class="tContrato">
                        <p>
                            {{ $contract->contrato }}
                        </p>
                    </div>
                    <div class="tRecibo">
                        <p>
                            {{ $contract->ReceiptNumber }}
                        </p>
                    </div>
                    <div class="tSec">
                        <p>
                            {{ $contract->sector }}
                        </p>
                    </div>
                    <div class="tRut">
                        <p>
                            {{ $contract->ruta }}
                        </p>
                    </div>
                    <div class="tFol">
                        <p>
                            {{ $contract->folio }}
                        </p>
                    </div>
                    <div class="tVen">
                        <p>
                            {{ $contract->due_date }}
                        </p>
                    </div>

                    <div class="tContrato2">
                        <p>
                            @if(!is_null($normalHeader = $contract->normalHeaders))
                                {{ $contract->contrato }}
                            @endif
                        </p>
                    </div>
                    <div class="tRecibo2">
                        <p>
                            @if(!is_null($normalHeader))
                                {{ $normalHeader->recibo }}
                            @endif
                        </p>
                    </div>
                    <div class="tSec2">
                        <p>
                            @if(!is_null($normalHeader))
                                {{ $contract->sector }}
                            @endif
                        </p>
                    </div>
                    <div class="tRut2">
                        <p>
                            @if(!is_null($normalHeader))
                                {{ $contract->ruta }}
                            @endif
                        </p>
                    </div>
                    <div class="tFol2">
                        <p>
                            @if(!is_null($normalHeader))
                                {{ $contract->folio }}
                            @endif
                        </p>
                    </div>
                    <div class="tVen2">
                        <p>
                            @if(!is_null($normalHeader))
                                {{ $paydayLimit }}
                            @endif
                        </p>
                    </div>
                    <div class="barcode">
                        {!! DNS1D::getBarcodeSVG($contract->monthly_payment_reference, "C128",0.75,30) !!}</br>
                        {{ $contract->monthly_payment_reference}}
                    </div>
                    <div class="barcode2">
                        @if(!is_null($normalHeader) && !is_null($due))
                                @php
                                    $reference = annualPaymentReference((int) $contract->contrato,$normalHeader->recibo,$paydayLimit,(int)$due->totalAPagar)
                                @endphp
                                {!! DNS1D::getBarcodeSVG($reference, "C128",0.75,30) !!}</br>
                                {{ $reference }}
                        @endif
                    </div>
                </footer>
            </div>
            <div class="saltoDePagina"></div>
        @endforeach
    </body>
</html>