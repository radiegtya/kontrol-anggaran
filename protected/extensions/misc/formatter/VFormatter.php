<?php

class VFormatter extends CWidget {

    /**
     * format number to rupiah
     * @param type $number
     * @return type
     */
    public static function getRupiah($number) {
        return number_format($number, 0, ",", ".");
    }

    public static function getReadmore($text) {
        $text = explode('[excerpt]', $text);
        $excerpt = $text[0];
        return $excerpt;
    }

    public static function getView($text) {
        $excerpt = str_replace('[excerpt]', '', $text);
        return $excerpt;
    }

    public static function getSeo($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%');
        $title = str_replace($regex, '-', $title);
        return $title;
    }

    public static function getClear($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%', '-');
        $title = str_replace($regex, '', $title);
        $title = strtolower($title);
        return $title;
    }

    public static function formatDate($oldDate, $divider = '/', $dividerTo = '-') {
        $arr = explode($divider, $oldDate);
        $newDate = $arr[2] . $dividerTo . $arr[1] . $dividerTo . $arr[0];
        return str_replace(' ', '', $newDate);
    }

    public static function terbilang($satuan) {
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($satuan < 12)
            return " " . $huruf[$satuan]; elseif ($satuan < 20)
            return self::terbilang($satuan - 10) . " belas"; elseif ($satuan < 100)
            return self::terbilang($satuan / 10) . " puluh" . self::terbilang($satuan % 10); elseif ($satuan < 200)
            return "seratus" . self::terbilang($satuan - 100); elseif ($satuan < 1000)
            return self::terbilang($satuan / 100) . " ratus" . self::terbilang($satuan % 100); elseif ($satuan < 2000)
            return "seribu" . self::terbilang($satuan - 1000); elseif ($satuan < 1000000)
            return self::terbilang($satuan / 1000) . " ribu" . self::terbilang($satuan % 1000); elseif ($satuan < 1000000000)
            return self::terbilang($satuan / 1000000) . " juta" . self::terbilang($satuan % 1000000); elseif ($satuan >= 1000000000)
            echo "Angka yang Anda masukkan terlalu besar";
    }

}
