<?php
class CPCurrencyAll{

  public static function cp_all_currencies_shortcode($atts){
    $html = '';
    
    if (isset($atts['basecurrency']) and $atts['basecurrency']!=''){
      $base_currency = trim(mb_strtoupper($atts['basecurrency']));
    } else {
      $base_currency = 'USD';
    }
    
    
    if (isset($atts['limit']) and $atts['limit']!=''){
      $limit = int($atts['limit']);
    } else {
      $limit = 500;
    }    

    //load libraries
    CPCommon::cp_load_scripts('datatable');
    CPCommon::cp_load_scripts('lazy');
    
    $html .= '
    <table class="cp-table cp-cryptocurrencies-table"></table>
    <script type="text/javascript">
    //get list of currencies
    var toCurrency = \''.$base_currency.'\';
    var apiUrl = \'https://api.coinmarketcap.com/v1/ticker/?convert=\'+\'toCurrency\'+\'&limit='.$limit.'\';
    jQuery.get( apiUrl, function( data ) {

      //prepare dataset for datatable
      var dataSet = [];
      for (var currentCurrency in data){
        var name = data[currentCurrency].name;
        var price = data[currentCurrency][\'price_usd\'].toLocaleString()+\' \'+toCurrency;
        var supply = parseInt(data[currentCurrency].available_supply).toLocaleString();
        var volume = parseInt(data[currentCurrency][\'24h_volume_usd\']+\' \').toLocaleString();
        var change = data[currentCurrency].percent_change_24h+\'%\';
        var marketCap = parseInt(data[currentCurrency][\'market_cap_usd\']).toLocaleString();
        var image = "<img class=\"lazy\" data-src=\"'.CP_URL.'images/"+data[currentCurrency].symbol.toLowerCase()+".png\" style=\"max-width:20px;\" />";
        
        dataSet.push([image+\' \'+name, marketCap, price, volume, supply, change]);
      }
      
      //show datatable
      jQuery(".cp-cryptocurrencies-table").DataTable({
        data: dataSet,
        columns: [{ title: "Coin" }, { title: "Market Cap, '.$base_currency.'" }, { title: "Price" }, { title: "Volume (24h), '.$base_currency.'" }, { title: "Circulating supply" }, { title: "Change (24h)" }, ],
        "order": [ [1, \'desc\'], [2, \'desc\'] ],
        "pageLength": 100,
        "lengthMenu": [ [10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"] ],
        drawCallback: function() {
          var lazy = jQuery(".cp-cryptocurrencies-table img").Lazy({
            chainable: false,
            defaultImage: \'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAMjSURBVHjaXFNLaFVXFF3nd+/7RhtJn4lRQ0xbQcQKrfUHqaSoaMDoQBw5Uumg1KGiOCjFOhHspNBCwYETkSKCpY0DbeLARoOKhjQ1mkT88HwvNr68vO+959P9XhINXs7mcA97r73W2ucwvPc1N6qGr7Z07N66oX1bJJFsA+NsOlee6Ls12vfHjeHeisbUwny28Odwz6r9Rw9tOt2yMtahIhLCi4OJCBw4dCjxYGhm9OT3v/1wc3D8IqUHFE7MF3935JNjJ75d80tscbHRjyWgoi0QfgrSa6Z9KZhSaE6FS/bs2twzNvZa/fskfb8GUgc4uDPVc+qb5l+NKCARp2QWI2xa1tJmiSenlQSTTZAig67OT7fe6BvJvZrMj4jUB17ip+NNl+OLS40siINqwOd4MfZOIVmBwmSaQD5EPDGFttb2tZeuDNwT3VsS3Qe69ddhBQjLGsrnEIK9tWcehHE6Vx6CqoA1ZSxflogP/P20Itet5tu40rDFWqKD0z5syMBIAp8VUIeqMbBawFQDck7Bj+Sx/cu1X8i2VraSCYtIQwATGNhgGlZaApjtzOck2BoTq8CZByGjNJVX+HjV0iapnTNcWQjqAEYAxSJcYGdNrBcSCIUjAGMUwhKxNBEacYBkLKbk2AszLj1H1AC/QaNYJgfdDMmYvSaczckgD6oFEkWIBjlIxfFmqhDwvtthf1hvSNdFOXiLNEJLY7MFAslRTJMveZSn/6PueTrPw7kMmI5jYHAkK15mXXrzerX7ow6TCisCkUVkkuMIKhLcki/EpFqy0EEVnLQwTmfCIZdO4OSP1/qFda46NMKye3fIfdGoFbos4cUNRMSiUvQQkrGCFWsm1GVoUULUtuDsz3ce995+3lu/MtkpMz70j9A7O0VnssHySkEQbQ5J0+DUzWjSzWgyKoQXNOLCpeeZ0xeGrlqHm/NvwU680MPX+0WuvcVfs6KVJT2fZsBq19LVJySMRGYihnPn00/OXBz73Tj8RXWDC19jDWwJpW7s+iy2r2uj/3nHcplSjKvsJCvdHQ4m/7wz8+jZ68pDyqs9pHsUmf8FGAD+bVsK2T9HVwAAAABJRU5ErkJggg==\'                            
          });
          lazy.update(); 
        },
      });
    } );
    </script>
    ';

    return $html;
  }
}