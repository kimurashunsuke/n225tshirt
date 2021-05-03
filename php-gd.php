<?php

require_once 'ScrapeStockValue.php';

class DrawPng
{
    const TTF_FONT_FILE = __DIR__ . '/Anton-Regular.ttf';
    const CANVAS_WIDTH = 2520;
    const CANVAS_HEIGHT = 2992;
    const PADDING = 10;
    const FONT_SIZE = 84;

    public function handle()
    {
        //画像を作る

        $im = imagecreatetruecolor(self::CANVAS_WIDTH, self::CANVAS_HEIGHT);
        imagefilledrectangle($im, 0, 0, self::CANVAS_WIDTH - 1, self::CANVAS_HEIGHT, 0xffffff);

        $x = 0;
        $y = self::FONT_SIZE * 2;

        $i = 0;
        $j = 0;
        $nikkei225 = include '225.php';
        foreach ($nikkei225 as $key => $code) {
            $lines[$i][$j] = $code;
            if ($j == 9 || $key === array_key_last($nikkei225)) {
                $i ++;
                $j = 0;
            } else {
                $lines[$i][$j] .= ' ';
                $j ++;
            }
        }

        // 署名
        $lines[] = ['.'];
//        $lines[] = ['NIKKEI225  ' . date('M.d,Y')];
        $lines[] = ['NIKKEI225  ' . 'Apr.30,2021'];

        foreach ($lines as $line) {
            //centering
            $box = imageftbbox(self::FONT_SIZE, 0, self::TTF_FONT_FILE, implode('', $line));
            $textWidth = $box[4] - $box[0];
            $textHeight = $box[1] - $box[5];
            $x = round((self::CANVAS_WIDTH - 1 - $textWidth) / 2);

            foreach ($line as $str) {
                // 黒文字
                $box = imagettftext(
                        $im,
                        self::FONT_SIZE,
                        0,
                        $x,
                        $y,
                        0x000000,
                        self::TTF_FONT_FILE,
                        $str);

                // 白文字
                if (ScrapeStockValue::handle(trim($str))) {
                    $im = self::drawOutlineFont($im, $x, $y, $str);
                }

                $textWidth = $box[4] - $box[0];
                $x += $textWidth;
            }
            $y += $textHeight + self::PADDING;
        }

        //画像として出力
        imagepng($im, '/var/www/html/' . date('Ymd') . '.png', 1);
    }

    private function drawOutlineFont ($im, $x, $y, $str)
    {
        if (! is_numeric(trim($str))) {
            return $im;
        }
        $outlineWeight = 9;
        foreach (str_split($str) as $char) {
            $box = imageftbbox(self::FONT_SIZE, 0, self::TTF_FONT_FILE, $char);
            $x2 = $x + $outlineWeight / 2;
            $y2 = $y - $outlineWeight / 2;
            $x += $box[4] - $box[0];

            $box = imagettftext(
                    $im,
                    self::FONT_SIZE - $outlineWeight * 1.4,
                    0,
                    $x2,
                    $y2,
                    0xffffff,
                    self::TTF_FONT_FILE,
                    $char);
        }
        return $im;
    }
}

DrawPng::handle();