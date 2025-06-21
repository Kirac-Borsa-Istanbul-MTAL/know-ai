<?php
function staticPrompt($search, $language, $level) {
    $prompt = "
        Lütfen aşağıdaki JSON formatına uyan bir çıktı üretiniz. Yanıtınızda ekstra açıklama, yorum veya metin bulunmasın; sadece belirtilen JSON yapısını kullanınız. Kullanıcının 'search' ve 'level' verilerini giriş olarak alınız ve bu verilere göre {$language} dilinde **tek bir içerik** oluşturunuz.
        
        **JSON formatında dikkat edilmesi gerekenler:**  
        - **\"detail\" alanı:**  
          - Konuyla ilgili **kapsamlı, öğretici ve derinlemesine bir açıklama** içermelidir.  
          - Açıklamada **tarihçe, kullanım alanları, örnekler ve önemli noktalar** yer almalıdır.  
          - Metin **en az 300 kelime uzunluğunda** olmalıdır.  
          - JSON formatını korumak için çift tırnak (`\"`) yerine tek tırnak (`'`) kullanılmalı veya kaçış karakteri (`\\\"`) ile belirtilmelidir.  
        
        - **\"questions\" alanı:**  
          - **İlk soru**  tek kelimelik ve kısa cevap gerektiren boşluk doldurma formatında oluşturun. Yazımı kolay, anlaşılır ve net bir şekilde hazırlanmalıdır.
          - **İkinci soru** test formatında olmalı, **birden fazla seçenek içermeli** ve doğru cevabın indeks numarası belirtilmelidir.  
        
        ---
        
        **JSON Formatı:**  
        
        {
            \"search\": \"{$search}\",
            \"level\": \"{$level}\",
            \"results\": {
                \"content\": {
                    \"header\": \"<Özet veya Başlık bilgisi>\",
                    \"detail\": \"<Kapsamlı ve öğretici açıklama>\",
                    \"sources\": [\"<Kaynak URL 1>\", \"<Kaynak URL 2>\"],
                    \"questions\": {
                        \"0\": {
                            \"question\": \"<Klasik soru>\",
                            \"answer\": \"<Doğru cevap>\"
                        },
                        \"1\": {
                            \"question\": \"<Test sorusu>\",
                            \"answers\": {
                                \"0\": \"<Şık 1>\",
                                \"1\": \"<Şık 2>\",
                                \"2\": \"<Şık 3>\",
                                \"3\": \"<Şık 4>\",
                                \"4\": \"<Şık 5>\"
                            },
                            \"correctAnswer\": 0
                        }
                    }
                }
            }
        }
    ";

    return $prompt;
}
?>