    $("#sirali").sortable({  // sıralamanın yapılacağı ul nin id si
        axis: 'y',   // sadece dikine sıralama yapmak için y eksenini seçiyoruz
        //revert: true, // sürükle bırak yaparken yavaş ve estetik olması için
        stop: function (event, ui) {
            var data = $(this).sortable('serialize'); // sıralama verisini oluşturuyoruz
            $.ajax({
                type: "POST", // post metodunu kullanıyoruz
                data: data, // data verisini yolluyoruz
                url: "../operations/kurumsalController.php",  // post edeceğimiz sayfamızın yolu
                success: function (data) { // veri işlendikten sonra sonucu alıyoruz.
                    if (data == "success") {
                        $('.sortable-response').text(" Sonuç: Başarılı"); // span da işlem sonucu başarılı ise belirtiyoruz
                    }
                    else {
                        $('.sortable-response').text(" Sonuç: Başarısız");// span da işlem sonucu başarısız ise belirtiyoruz
                    }
                }
            });
        }
    });

$('#widget').draggable();  //Bu kod ile mobil cihazlarda ve tabletlerde sürükle bırak özelliği çalışacaktır.
