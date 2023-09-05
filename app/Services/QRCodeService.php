<?php

namespace App\Services;

use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
use Endroid\QrCode\Label\Alignment\LabelAlignmentRight;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QRCodeService
{
    public $qr_code;
    public $qr_label = null;
    public $qr_logo = null;
    public $qr_result;

    /*
     * Recebe o conteúdo que será criado o QRCode
     * @PARAM $content : Link para ser aberto
     * @PARAM $width : tamanho do QRCode
     * @PARAM $margin : margem para a borda do QRCode
     * @PARAM $corFore1 : Cor 1 do QRCode
     * @PARAM $corFore2 : Cor 2 do QRCode
     * @PARAM $corFore3 : Cor 3 do QRCode
     * @PARAM $corBack1 : Cor 1 do Fundo
     * @PARAM $corBack2 : Cor 2 do Fundo
     * @PARAM $corBack3 : Cor 3 do Fundo
     *
     * CHAMADA OBRIGATÓRIA
     */
    public function code($content, $width=300, $margin=20, $corFore1=0, $corFore2=0, $corFore3=0, $corBack1=255, $corBack2=255, $corBack3=255)
    {
        $this->qr_code = QrCode::create($content)
            ->setSize($width)
            ->setMargin($margin)
            ->setForegroundColor(new Color($corFore1, $corFore2, $corFore3))
            ->setBackgroundColor(new Color($corBack1, $corBack2, $corBack3))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh);

        return $this;
    }

    /*
     * Recebe o texto para a Label do QRCode
     * @PARAM $text : Texto da Label
     * @PARAM $cor1 : Cor 1 do Texto
     * @PARAM $cor2 : Cor 2 do Texto
     * @PARAM $cor3 : Cor 3 do Texto
     * @PARAM $align : Alinhamento do Texto 1(Left) 2(Center) 3(Right)
     */
    public function label($text='', $cor1=0, $cor2=0, $cor3=0, $align=2)
    {
        if ($text == '') {$text = env('APP_NAME');}

        if ($align == 1) {
            $align = new LabelAlignmentLeft();
        } else if ($align == 2) {
            $align = new LabelAlignmentCenter();
        } else if ($align == 3) {
            $align = new LabelAlignmentRight();
        }

        $this->qr_label = Label::create($text)
            ->setTextColor(new Color($cor1, $cor2, $cor3))
            ->setAlignment($align);

        return $this;
    }

    /*
     * Recebe a Imagem para colocar no centro do QRCode
     * @PARAM $destino : Pasta da Imagem
     * @PARAM $name : Nome da Imagem
     * @PARAM $width : Tamanho que vai aparecer no QRCode
     */
    public function logo($destino='build/assets/images/', $name='image_logo_qrcode.png', $width=90)
    {
        $this->qr_logo = Logo::create($destino.$name)->setResizeToWidth($width);

        return $this;
    }

    /*
     * Monta o resultado QRCode
     */
    public function result()
    {
        $writer = new PngWriter;

        $this->qr_result = $writer->write($this->qr_code, $this->qr_logo, $this->qr_label);

        return $this;
    }

    /*
     * Salva a Imagem do QRCode em um Arquivo
     * @PARAM $destino : Pasta para gravação
     * @PARAM $name : Nome do Arquivo com .png para gerar o QRCode
     */
    public function save($destino, $name)
    {
        $this->result();

        $this->qr_result->saveToFile($destino.$name);
    }
}
