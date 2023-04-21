<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <style>
            @page {margin: 100px 25px;}
            header {position: fixed; top: -60px;    left: 30px; right: 0px; background-color: white; height: 120px;}
            footer {position: fixed; bottom: -100px; left: 30px; right: 0px; background-color: white; height: 100px; }
            p { page-break-after: always; }
            p:last-child { page-break-after: never; }
        </style>
    </head>
    <body>
        <header><img src="build/assets/images/proposta_topo.png" alt="" width="98%"></header>
        <footer><img src="build/assets/images/proposta_rodape.png" alt="" width="98%"></footer>

        @if(isset($error))
            <div style="width: 100%; text-align: center; font-size: 20px; color: red; padding-top: 100px;">{{'Proposta não encontrada.'}}</div>
        @else
            <main>
                <table style="width: 100%; padding-top: 70px; padding-bottom: 50px; padding-left:30px; padding-right: 5px;">
                    <tr>
                        <td colspan="4" align="left" style="height:80px;">{{$registro['data_proposta_extenso']}}</td>
                        <td colspan="4" align="right" style="height:80px;">Proposta nº. {{$registro['numero_proposta'].'/'.$registro['ano_proposta']}}.</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px; font-weight: bold; height: 20px;">{{$registro['cliente_nome']}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px; height: 20px;">{{$registro['cliente_logradouro']}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px; height: 20px;">{{$registro['cliente_bairro'].' - '.$registro['cliente_cidade']}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px; height: 20px;">A/C: {{$registro['aos_cuidados']}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 40px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px; height: 20px;">{{$registro['texto_acima_tabela_servico']}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" align="left" style="font-size: 12px;">

                            @php
                                //Parte inicial da tabela para ser repetida a cada quebra da tabela
                                $t_inicial = '<table width="100%" style="border: 1px solid black; border-collapse: collapse; font-size: 12px;">
                                                <thead>
                                                    <tr style="background-color: #e3e6eb;">
                                                        <th align="center" style="border: 1px solid black; border-collapse: collapse; height:24px;">ITEM</th>
                                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">DESCRIÇÃO DOS EQUIPAMENTOS PREVENTIVOS</th>
                                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">VALOR UNITÁRIO</th>
                                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">QUANTIDADE</th>
                                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">VALOR TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';

                                //Parte final da tabela para fechar quando tiver a quebra
                                $t_final = '    </tbody>
                                            </table>';
                            @endphp

                            @php
                                //Colocando a parte inicial da tabela
                                echo $t_inicial;

                                //Guardando a quantidade de linhas total da tabela
                                $linhas_total = 0;

                                //Guardando a quantidade de linhas da ultima parte da tabela
                                $linhas_atual = 0;

                                //Soma dos valores totais da tabela pera formar o valor global da tabela
                                $valor_global=0;
                            @endphp

                            @foreach($registro['proposta_servicos'] as $servico)
                                @php
                                    $linhas_total++;

                                    $valor_global = $valor_global + $servico['servico_valor_total'];
                                @endphp

                                <!--
                                1. As quebras da tabela ocorrem nas linhas 18 e 43
                                2. Ao chegar nessas linhas: inclui a parte final / coloca a quebra / coloca uma div com padding-top / coloca a parte inicial
                                -->
                                @if($linhas_total == 18 or $linhas_total == 43)
                                    @php echo $t_final; @endphp

                                    <p>&nbsp;</p>
                                    <div style="padding-top: 90px;">&nbsp;</div>

                                    @php $linhas_atual = 0; @endphp

                                    @php echo $t_inicial; @endphp
                                @endif

                                <tr>
                                    <th align="center" style="border: 1px solid black; border-collapse: collapse; height:25px;">{{$servico['servico_item']}}</th>
                                    <td align="left" style="border: 1px solid black; border-collapse: collapse;">{{$servico['servico_nome']}}</td>
                                    <td align="right" style="border: 1px solid black; border-collapse: collapse;">R$ {{number_format($servico['servico_valor'], '2', ',', '.')}}</td>
                                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">{{$servico['servico_quantidade']}}</td>
                                    <td align="right" style="border: 1px solid black; border-collapse: collapse;">R$ {{number_format($servico['servico_valor_total'], '2', ',', '.')}}</td>
                                </tr>

                                @php $linhas_atual++; @endphp
                            @endforeach

                            </tbody>
                                <tfoot>
                                    <tr style="background-color: #e3e6eb;">
                                        <th style="border: 1px solid black; border-collapse: collapse; height:24px;">&nbsp;</th>
                                        <th style="border: 1px solid black; border-collapse: collapse;">&nbsp;</th>
                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">VALOR GLOBAL</th>
                                        <th align="center" style="border: 1px solid black; border-collapse: collapse;">R$</th>
                                        <th align="right" style="border: 1px solid black; border-collapse: collapse;">R$ {{number_format($valor_global, '2', ',', '.')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 50px;">&nbsp;</td>
                    </tr>

{{--                    <!-- Verificar necessidade de quebra -->--}}
{{--                    @if($linhas_atual == 21)--}}
{{--                        @php $linhas_atual = 0; @endphp--}}

{{--                        <p>&nbsp;</p>--}}
{{--                        <div style="padding-top: 90px;">&nbsp;</div>--}}
{{--                    @endif--}}

{{--                    <!-- Verificar necessidade de colocar padding -->--}}
{{--                    @if($linhas_atual > 21)--}}
{{--                        @php--}}
{{--                            $padding = 0;--}}

{{--                            if($linhas_atual == 22) {$padding = 90;}--}}
{{--                            if($linhas_atual == 23) {$padding = 70;}--}}
{{--                            if($linhas_atual == 24) {$padding = 30;}--}}
{{--                            if($linhas_atual == 25) {$padding = 30;}--}}
{{--                            if($linhas_atual == 26) {$padding = 20;}--}}
{{--                        @endphp--}}

{{--                        <div style="padding-top: {{$padding}}px;">&nbsp;</div>--}}
{{--                    @endif--}}

                    <tr>
                        <td colspan="8">
                            <div style="font-size: 12px; font-weight: bold; height: 30px;">1. DO VALOR DESCONTO</div>
                            <div style="font-size: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R$ {{$registro['valor_desconto']}} ({{$registro['valor_desconto_extenso']}})</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 30px;">&nbsp;</td>
                    </tr>

{{--                    <!-- Verificar necessidade de quebra -->--}}
{{--                    @if($linhas_atual == 21)--}}
{{--                        @php $linhas_atual = 0; @endphp--}}

{{--                        <p>&nbsp;</p>--}}
{{--                        <div style="padding-top: 90px;">&nbsp;</div>--}}
{{--                    @endif--}}

                    <tr>
                        <td colspan="8">
                            <div style="font-size: 12px; font-weight: bold; height: 30px;">2. DO VALOR TOTAL</div>
                            <div style="font-size: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R$ {{$registro['valor_total']}} ({{$registro['valor_total_extenso']}})</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 30px;">&nbsp;</td>
                    </tr>

{{--                    <!-- Verificar necessidade de quebra -->--}}
{{--                    @if($linhas_atual > 10)--}}
{{--                        @php $linhas_atual = 0; @endphp--}}

{{--                        <p>&nbsp;</p>--}}
{{--                        <div style="padding-top: 90px;">&nbsp;</div>--}}
{{--                    @endif--}}

                    <tr>
                        <td colspan="8">
                            <div style="font-size: 12px; font-weight: bold; height: 30px;">3. DA FORMA E CONDIÇÕES DE PAGAMENTO</div>
                            <div style="font-size: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$registro['forma_pagamento']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 30px;">&nbsp;</td>
                    </tr>

{{--                    <!-- Verificar necessidade de quebra -->--}}
{{--                    @if($linhas_atual > 8)--}}
{{--                        @php $linhas_atual = 0; @endphp--}}

{{--                        <p>&nbsp;</p>--}}
{{--                        <div style="padding-top: 90px;">&nbsp;</div>--}}
{{--                    @endif--}}

                    <tr>
                        <td colspan="8">
                            <div style="font-size: 12px; font-weight: bold; height: 30px;">4. DAS GENERALIDADES</div>

                            @php($ln=0)

                            @for($i=1; $i<=10; $i++)
                                @if($registro['paragrafo_'.$i] != '')
                                    @php($ln++)

                                    <table width="100%" style="font-size: 12px;">
                                        <tbody>
                                            <tr>
                                                <th style="width: 1%; height:15px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</th>
                                                <td style="width: 99%; height:15px; vertical-align: top;">{{$registro['paragrafo_'.$i]}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            @endfor

                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" align="right">
                            <div style="font-size: 12px; font-weight: bold; height: 20px;">SRMAIS - COMÉRCIO E SERVIÇOS EIRELI LTDA</div>
                            <div style="font-size: 12px; font-weight: bold; height: 20px;">CBMERJ 02-408|CREA/RJ 2019201827</div>
                            <div style="font-size: 12px; font-weight: bold; height: 20px;">CONTRATADA</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 50px;">&nbsp;</td>
                    </tr>
                </table>

            </main>

        @endif
    </body>
</html>
