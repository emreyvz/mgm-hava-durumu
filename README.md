![](https://i.ibb.co/8r0K7fW/banner.png)

# Meteoroloji Genel Müdürlüğü Hava Durumu Sınıfı  (Unofficial)

Bu PHP sınıfı sayesinde www.mgm.gov.tr adresinden kolayca hava durumu bilgilerini alabilirsiniz. 
> Emre Yavuz tarafından PHP kullanarak yazılmıştır  | github.com/emreyvz

**Erişilebilen Property'ler**

- Anlık sıcaklık | getCurrentDegree()
- Şehir Enlem Boylam Bilgileri | getLongitude() & getLatitude()
- Gün doğumu ve günbatımı saatleri | getSunrise() & getSunset()
- Hava Durumu (örn: sağanak yağışlı) | getCurrentCondition()
- Hava Durumu Kodu (örn: SY) | getCurrentConditionCode()
- Anlık Nem | getCurrentHumidity()
- Anlık Rüzgar Hızı | getCurrentWindSpeed()
- Anlık Basınç | getCurrentPressure()
- Anlık Denize İndirgenmiş Basınç | getCurrentSeaLevelPressure()
- 5 günlük tahmin | getForecast()
- Hava Durumu ikon adresi (url) | getConditionIcon(@param)


# Örnekler
---
## Bir şehrin anlık sıcaklık değerini gösterme

```php
$mgmWeather = new mgmWeather();
$mgmWeather->location="Ankara";
$mgmWeather->fetchData();
echo "Sıcaklık:" .$mgmWeather->getCurrentDegree();
```



## Bir şehrin anlık rüzgar hızı değerini gösterme

```php
$mgmWeather = new mgmWeather();
$mgmWeather->location="İstanbul";
$mgmWeather->fetchData();
echo "Rüzgar Hızı:" .$mgmWeather->getCurrentWindSpeed();
```

## Bir şehrin 5 günlük hava tahminlerini alma

```php
$mgmWeather = new mgmWeather();
$mgmWeather->location="İstanbul";
$mgmWeather->fetchData();
foreach ($mgmWeather->getForecast() as $day) {
  echo "Tarih: ". $day['date'] ."<br>";
  echo "En Düşük Sıcaklık: ". $day['lowestDegree']."<br>";
  echo "En Yüksek Nem Oranı: ". $day['highestHumidity'];
}
```

## Lisans

<img src="https://opensource.org/files/osi_keyhole_300X300_90ppi_0.png" height="24" width="24">

- **[Apache 2.0 License](https://www.apache.org/licenses/LICENSE-2.0)**
- 2024 © Emre Yavuz
