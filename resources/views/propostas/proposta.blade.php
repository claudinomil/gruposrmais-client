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
            @page {margin: 100px 50px 100px 50px;}
            header {position: fixed; top: -60px;    left: 0px; right: 0px; background-color: white; height: 120px;}
            footer {position: fixed; bottom: -100px; left: 0px; right: 0px; background-color: white; height: 100px; }
            p { page-break-after: always; }
            p:last-child { page-break-after: never; }
        </style>
    </head>
    <body>
{{--        <header><img src="{{ asset('build/assets/images/proposta_topo.png') }}" alt="" width="100%"></header>--}}
{{--        <footer><img src="{{ asset('build/assets/images/proposta_rodape.png') }}" alt="" width="100%"></footer>--}}

    <header><img src="http://sistema.gruposrmais.com.br/build/assets/images/proposta_topo.png" alt="" width="100%"></header>
    <footer><img src="http://sistema.gruposrmais.com.br/build/assets/images/proposta_rodape.png" alt="" width="100%"></footer>



        @if(isset($error))
            <div style="width: 100%; text-align: center; font-size: 20px; color: red; padding-top: 100px;">{{'Proposta não encontrada.'}}</div>
        @else

            <!--
             Início de padding-top: 100px
             cada folha tem 29 x 20px = 580px
            -->

            @php
                $linhas = 0;
            @endphp

            <main>
                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px; padding-top: 80px;">
                    <tr>
                        <td align="left" style="width: 50%; height:20px; vertical-align: top;">{{$registro['data_proposta_extenso']}}</td>
                        <td align="right" style="width: 50%; height:20px; vertical-align: top;">Proposta nº. {{$registro['numero_proposta'].'/'.$registro['ano_proposta']}}.</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 50%; height:20px; vertical-align: top;"><b>{{$registro['cliente_nome']}}</b></td>
                        <td align="right" style="width: 50%; height:20px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 50%; height:20px; vertical-align: top;">{{$registro['cliente_logradouro']}}</td>
                        <td align="right" style="width: 50%; height:20px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 50%; height:20px; vertical-align: top;">{{$registro['cliente_bairro'].' - '.$registro['cliente_cidade']}}</td>
                        <td align="right" style="width: 50%; height:20px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 50%; height:20px; vertical-align: top;"><b>A/C: {{$registro['aos_cuidados']}}</b></td>
                        <td align="right" style="width: 50%; height:20px; vertical-align: top;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;"><?php echo $registro['texto_acima_tabela_servico']; ?></td>
                    </tr>
                </table>

                @php $linhas++; @endphp
                @php
                    //Parte inicial da tabela para ser repetida a cada quebra da tabela
                    $t_inicial = '<table width="100%" style="border: 1px solid #79829c; border-collapse: collapse; font-size: 11px;">
                                    <thead>
                                        <tr style="background-color: #00feff;">
                                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;">&nbsp;<b>ITEM</b>&nbsp;</th>
                                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;">&nbsp;<b>DESCRIÇÃO DOS EQUIPAMENTOS PREVENTIVOS</b>&nbsp;</th>
                                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;">&nbsp;<b>VALOR UNITÁRIO</b>&nbsp;</th>
                                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;">&nbsp;<b>QUANTIDADE</b>&nbsp;</th>
                                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;">&nbsp;<b>VALOR TOTAL</b>&nbsp;</th>
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

                    //Soma dos valores totais da tabela pera formar o valor global da tabela
                    $valor_global=0;
                @endphp

                @foreach($registro['proposta_servicos'] as $servico)
                    @php
                        $valor_global = $valor_global + $servico['servico_valor_total'];
                    @endphp

                    @php $linhas++; @endphp
                    <tr>
                        <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$servico['servico_item']}}&nbsp;</th>
                        <td align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$servico['servico_nome']}}&nbsp;</td>
                        <td align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;R$ {{number_format($servico['servico_valor'], '2', ',', '.')}}&nbsp;</td>
                        <td align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$servico['servico_quantidade']}}&nbsp;</td>
                        <td align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;R$ {{number_format($servico['servico_valor_total'], '2', ',', '.')}}&nbsp;</td>
                    </tr>

                    @if($linhas == 28)
                        @php echo $t_final; @endphp

                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php echo $t_inicial; @endphp

                        @php $linhas = 0; @endphp
                    @endif
                @endforeach

                    @php $linhas++; @endphp
                    <tr style="background-color: #00feff;">
                        <th style="height:25px;">&nbsp;</th>
                        <th align="right" colspan="2" style="border-right: 1px solid #79829c; border-collapse: collapse; height:25px;">&nbsp;<b>VALOR GLOBAL</b>&nbsp;</th>
                        <th align="center" style="height:25px;">&nbsp;<b>R$</b>&nbsp;</th>
                        <th align="center" style="height:25px;">&nbsp;<b>{{number_format($valor_global, '2', ',', '.')}}</b>&nbsp;</th>
                    </tr>

                    @if($registro['valor_desconto'] > 0)

                        @php $linhas++; @endphp
                        <tr style="border-top: 1px solid #79829c; border-collapse: collapse; background-color: #00feff;">
                            <th style="height:25px;">&nbsp;</th>
                            <th align="right" colspan="2" style="border-right: 1px solid #79829c; border-collapse: collapse; height:25px;">&nbsp;<b>DESCONTO {{$registro['porcentagem_desconto']}}%</b>&nbsp;</th>
                            <th align="center" style="height:25px;">&nbsp;<b>R$</b>&nbsp;</th>
                            <th align="center" style="height:25px;">&nbsp;<b>{{$registro['valor_desconto']}}</b>&nbsp;</th>
                        </tr>
                    @endif
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;"><b>1. DO VALOR DA PROPOSTA</b></td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R$ {{$registro['valor_total']}} ({{$registro['valor_total_extenso']}})</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;"><b>2. DA FORMA E CONDIÇÕES DE PAGAMENTO</b></td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$registro['forma_pagamento']}}</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="left" style="width: 100%; height:20px; vertical-align: top;"><b>3. DAS GENERALIDADES</b></td>
                    </tr>
                </table>

                @php $ln = 0; @endphp

                @if($registro['paragrafo_1'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_1']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_2'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_2']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_3'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_3']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_4'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_4']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_5'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_5']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_6'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_6']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_7'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_7']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_8'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_8']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_9'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_9']}}</td>
                        </tr>
                    </table>
                @endif

                @if($registro['paragrafo_10'] != '')
                    @php $ln++; @endphp

                    @if($linhas == 29)
                        <p>&nbsp;</p>
                        <div style="padding-top: 100px;">&nbsp;</div>

                        @php $linhas = 0; @endphp
                    @endif

                    @php $linhas++; @endphp
                    <table width="100%" style="font-size: 12px;">
                        <tr>
                            <td style="width: 1%; height:20px; vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.{{$ln}}.&nbsp;</td>
                            <td style="width: 99%; height:20px; vertical-align: top;">{{$registro['paragrafo_10']}}</td>
                        </tr>
                    </table>
                @endif

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="right" style="width: 100%; vertical-align: top;"><b>SRMAIS - COMÉRCIO E SERVIÇOS EIRELI LTDA</b></td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="right" style="width: 100%; vertical-align: top;"><b>CBMERJ 02-408|CREA/RJ 2019201827</b></td>
                    </tr>
                </table>

                @if($linhas == 29)
                    <p>&nbsp;</p>
                    <div style="padding-top: 100px;">&nbsp;</div>

                    @php $linhas = 0; @endphp
                @endif

                @php $linhas++; @endphp
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td align="right" style="width: 100%; vertical-align: top;"><b>CONTRATADA</b></td>
                    </tr>
                </table>
            </main>

        @endif
    </body>
</html>
