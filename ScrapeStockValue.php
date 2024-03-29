<?php

require_once 'phpQuery-onefile.php';

class ScrapeStockValue
{
    public function handle($code)
    {
        usleep(2500000);
        if (! is_numeric($code)) {
            return false;
        }
        $html = file_get_contents("https://minkabu.jp/stock/{$code}");
        $doc = phpQuery::newDocument($html);
        $val = pq('.stock_price_diff')->text() . "\n";
        trim(explode('(', $val)[0]);

        if (trim(explode('(', $val)[0]) < 0) {
            return false;
        }
        return true;
    }
}