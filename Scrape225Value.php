<?php

require_once 'phpQuery-onefile.php';

class Scrape225Value
{
    public function handle()
    {
        usleep(2500000);
        $html = file_get_contents("https://minkabu.jp/stock/100000018");
        $doc = phpQuery::newDocument($html);
        $val = pq('.stock_price_diff')->text() . "\n";
        trim(explode('(', $val)[0]);

        if (trim(explode('(', $val)[0]) < 0) {
            return false;
        }
        return true;
    }
}