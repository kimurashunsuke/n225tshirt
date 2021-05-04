<?php

require_once 'ScrapeStockValue.php';
require_once 'Scrape225Value.php';

class DrawPng
{
    const TTF_FONT_FILE = __DIR__ . '/Anton-Regular.ttf';
    const CANVAS_WIDTH = 2520;
    const CANVAS_HEIGHT = 2992;
    const PADDING = 10;
    const FONT_SIZE = 104;
    const FONT_STROKE_SIZE = 4;
    const COLOR_GRAY = '#222222';
    const COLOR_DARK_GRAY = '#222222';

    public function handle()
    {
        //画像を作る

        $canvas = new Imagick();
        $canvas->newImage(self::CANVAS_WIDTH, self::CANVAS_HEIGHT, "#FFFFFF");

        $draw = new ImagickDraw();
        $draw->setFont(self::TTF_FONT_FILE);
        $draw->setFontSize(self::FONT_SIZE);

        $x = 0;
        $y = self::FONT_SIZE + self::PADDING;

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

        foreach ($lines as $line) {
            //centering
            $metrics = $canvas->queryFontMetrics($draw, implode('', $line));
            $x = round((self::CANVAS_WIDTH - 1 - $metrics['textWidth']) / 2);

            foreach ($line as $str) {
                // 黒文字
                $box = $canvas->queryFontMetrics($draw, $str);
//                if (rand() % 2 == 1) {
                if (ScrapeStockValue::handle(trim($str))) {
                    // 白文字
                    $draw->setFillColor('#ffffff');
                    $draw->setStrokeWidth(self::FONT_STROKE_SIZE);
                    $draw->setStrokeColor(self::COLOR_DARK_GRAY);
                } else {
                    // 黒文字
                    $draw->setFillColor(self::COLOR_GRAY);
                    $draw->setStrokeColor(self::COLOR_GRAY);
                }
                $draw->annotation($x, $y, $str);

                $x += $box['textWidth'];
            }
            $y += $metrics['characterHeight'] + self::PADDING;
        }
        $str = 'NIKKEI225  ' . date('M.d,Y');
        // 署名
        //centering
        $metrics = $canvas->queryFontMetrics($draw, $str);
        $x = round((self::CANVAS_WIDTH - 1 - $metrics['textWidth']) / 2);
        $y += $metrics['textHeight'] + self::PADDING;
        if (Scrape225Value::handle()) {
            // 白文字
            $draw->setFillColor('#ffffff');
            $draw->setStrokeWidth(self::FONT_STROKE_SIZE);
            $draw->setStrokeColor(self::COLOR_DARK_GRAY);
        } else {
            // 黒文字
            $draw->setFillColor(self::COLOR_GRAY);
            $draw->setStrokeColor(self::COLOR_GRAY);
        }
        $draw->annotation($x, $y, $str);


        //画像として出力
        $canvas->drawImage($draw);
        $canvas->setImageFormat("png");
        $canvas->writeImage(date('Ymd') . '.png');
    }
}

DrawPng::handle();