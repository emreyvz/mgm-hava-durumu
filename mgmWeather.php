<?php
/**
 * mgmWeather - a fast and reliable weather library
 * Written by Emre Yavuz & github.com/emreyvz
 */
class mgmWeather
{

    /**
     * Initial variables
     *
     *@param $location;
     *@param $locationId;
     *@param $latitude;
     *@param $longitude;
     *@param $currentDegree;
     *@param $currentCondition;
     *@param $currentHumidity;
     *@param $currentWindSpeed;
     *@param $currentPressure;
     *@param $currentSeaLevelPressure;
     *@param $sunrise;
     *@param $sunset;
     *@param $forecast;
     */


    public $location;
    public $locationId;
    public $latitude;
    public $longitude;
    public $currentDegree;
    public $currentConditionCode;
    public $currentHumidity;
    public $currentWindSpeed;
    public $currentPressure;
    public $currentSeaLevelPressure;
    public $sunrise;
    public $sunset;
    public $forecast;


    /**
     * Getter and Setter Functions
     */
    function setCurrentDegree($degree)
    {
        $this->currentDegree = $degree;
    }

    function setCurrentConditionCode($condition)
    {
        $this->currentCondition = $condition;
    }

    function setCurrentHumidity($humidity)
    {
        $this->currentHumidity = $humidity;
    }

    function setCurrentWindSpeed($speed)
    {
        $this->currentWindSpeed = $speed;
    }

    function setCurrentPressure($pressure)
    {
        $this->currentPressure = $pressure;
    }

    function setCurrentSeaLevelPressure($seaLevelPressure)
    {
        $this->currentSeaLevelPressure = $seaLevelPressure;
    }

    function setSunrise($time)
    {
        $this->sunrise = $time;
    }

    function setSunset($time)
    {
        $this->sunset = $time;
    }

    function setForecast($data)
    {
        $this->forecast = $data;
    }


    function getCurrentDegree()
    {
        return $this->currentDegree;
    }

    function getCurrentConditionCode()
    {
        return $this->currentCondition;
    }

    function getCurrentHumidity()
    {
        return $this->currentHumidity;
    }

    function getCurrentWindSpeed()
    {
        return $this->currentWindSpeed;
    }

    function getCurrentPressure()
    {
        return $this->currentPressure;
    }

    function getCurrentSeaLevelPressure()
    {
        return $this->currentSeaLevelPressure;
    }

    function getSunrise()
    {
        return $this->sunrise;
    }

    function getSunset()
    {
        return $this->sunset;
    }

    function getForecast()
    {
        return $this->forecast;
    }

    function getLongitude()
    {
        return $this->longitude;
    }

    function getLatitude()
    {
        return $this->latitude;
    }





    /**
     * Method for getting weather condition by using condition code
     * @return string
     */

    function getCurrentCondition()
    {

        $conditionCodes = Array(
            "PB"=>"Parçalı Bulutlu",
            "GSY"=>"Gökgürültülü Sağanak Yağışlı",
            "HSY"=>"Hafif Sağanak Yağışlı",
            "SY"=>"Sağanak Yağışlı",
            "A"=>"Açık",
            "AB"=>"Az Bulutlu",
            "CB"=>"Çok Bulutlu",
            "D"=>"Duman",
            "HY"=>"Hafif Yağmurlu",
            "HKY"=>"Hafif Kar Yağışlı",
            "MSY"=>"Yer Yer Sağanak Yağışlı",
            "KKY"=>"Karla Karışık Yağmurlu",
            "GKR"=>"Güneyli Kuvvetli Rüzgar",
            "SCK"=>"Sıcak",
            "PUS"=>"PUS",
            "Y"=>"Yağmurlu",
            "K"=>"Kar Yağışlı",
            "DY"=>"Dolu",
            "R"=>"Rüzgarlı",
            "KKR"=>"Kuzeyli Kuvvetli Rüzgar",
            "SGK"=>"Soğuk",
            "SIS"=>"Sis",
            "KY"=>"Kuvvetli Yağmurlu",
            "KSY"=>"Kuvvetli Sağanak Yağışlı",
            "YKY"=>"Yoğun Kar Yağışlı",
            "KF"=>"Toz veya Kum Fırtınası",
            "KGY"=>"Kuvvetli Gökgürültülü Sağanak Yağışlı"
        );
      
        return $conditionCodes[$this->getCurrentConditionCode()];

    }



    /**
     * Method for getting weather condition icon URL
     *
     * @param $condition
     * 
     * @return string
     */

    function getConditionIcon($conditionCode)
    {
        return "https://www.mgm.gov.tr/Images_Sys/hadiseler/" . $conditionCode . ".svg";
    }


    /**
     * Simple method for making request without header.
     *
     * @param $url
     * 
     * @return string
     */

    function requestWithNoHeader($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }



    /**
     * Simple method for making request with setted header. 
     *
     * @param $url
     * 
     * @return string
     */
    function request($url)
    {

        $curl = curl_init($url);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Host: servis.mgm.gov.tr",
                "Connection: keep-alive",
                "Accept: application/json, text/plain, */*",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36",
                "Origin: https://www.mgm.gov.tr"
            )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }


    /**
     * Method that fetch all essential data from www.mgm.gov.tr and www.sunrise-sunset.org
     */
    function fetchData()
    {

        $cityDataJson = $this->request("https://servis.mgm.gov.tr/web/merkezler?il=" . $this->location);
        $cityData = json_decode($cityDataJson, true);
        $this->locationId =  $cityData[0]["merkezId"];
        $this->longitude =  $cityData[0]["boylam"];
        $this->latitude =  $cityData[0]["enlem"];
        $cityCurrentWeatherJson = $this->request("https://servis.mgm.gov.tr/web/sondurumlar?merkezid=" . $this->locationId);
        $cityCurrentWeather = json_decode($cityCurrentWeatherJson, true);
        $this->currentPressure =  $cityCurrentWeather[0]["aktuelBasinc"];
        $this->currentSeaLevelPressure =  $cityCurrentWeather[0]["denizeIndirgenmisBasinc"];
        $this->currentCondition =  $cityCurrentWeather[0]["hadiseKodu"];
        $this->currentHumidity =  $cityCurrentWeather[0]["nem"];
        $this->currentWindSpeed =  $cityCurrentWeather[0]["ruzgarHiz"];
        $this->currentDegree =  $cityCurrentWeather[0]["sicaklik"];
        $sunsetAndSunriseInfoJson = $this->requestWithNoHeader("https://api.sunrise-sunset.org/json?lat=" . $this->latitude . "&lng=" . $this->longitude);
        $sunsetAndSunriseInfo = json_decode($sunsetAndSunriseInfoJson, true);
        $this->sunrise =  date("H:i", strtotime($sunsetAndSunriseInfo['results']["sunrise"]) + 10800);
        $this->sunset =  date("H:i", strtotime($sunsetAndSunriseInfo['results']["sunset"]) + 10800);
        $weatherDatas = array();
        $weatherInfoDayByDayJson = $this->request("https://servis.mgm.gov.tr/web/tahminler/gunluk?istno=" . $this->locationId);
        $weatherInfoDayByDay = json_decode($weatherInfoDayByDayJson, true);
        $date = date("d-m-Y");
        array_push($weatherDatas, array('lowestDegree' => $weatherInfoDayByDay[0]['enDusukGun1'], 'highestDegree' =>  $weatherInfoDayByDay[0]['enYuksekGun1'], 'lowestHumidity' =>  $weatherInfoDayByDay[0]['enDusukNemGun1'], 'highestHumidity' => $weatherInfoDayByDay[0]['enYuksekNemGun1'], 'condition' =>  $weatherInfoDayByDay[0]['hadiseGun1'], 'windSpeed' => $weatherInfoDayByDay[0]['ruzgarHizGun1'], 'date' => $date));
        array_push($weatherDatas, array('lowestDegree' => $weatherInfoDayByDay[0]['enDusukGun2'], 'highestDegree' =>  $weatherInfoDayByDay[0]['enYuksekGun2'], 'lowestHumidity' =>  $weatherInfoDayByDay[0]['enDusukNemGun2'], 'highestHumidity' => $weatherInfoDayByDay[0]['enYuksekNemGun2'], 'condition' =>  $weatherInfoDayByDay[0]['hadiseGun2'], 'windSpeed' => $weatherInfoDayByDay[0]['ruzgarHizGun2'], 'date' => date('d-m-Y', strtotime($date . "+1 days"))));
        array_push($weatherDatas, array('lowestDegree' => $weatherInfoDayByDay[0]['enDusukGun3'], 'highestDegree' =>  $weatherInfoDayByDay[0]['enYuksekGun3'], 'lowestHumidity' =>  $weatherInfoDayByDay[0]['enDusukNemGun3'], 'highestHumidity' => $weatherInfoDayByDay[0]['enYuksekNemGun3'], 'condition' =>  $weatherInfoDayByDay[0]['hadiseGun3'], 'windSpeed' => $weatherInfoDayByDay[0]['ruzgarHizGun3'], 'date' => date('d-m-Y', strtotime($date . "+2 days"))));
        array_push($weatherDatas, array('lowestDegree' => $weatherInfoDayByDay[0]['enDusukGun4'], 'highestDegree' =>  $weatherInfoDayByDay[0]['enYuksekGun4'], 'lowestHumidity' =>  $weatherInfoDayByDay[0]['enDusukNemGun4'], 'highestHumidity' => $weatherInfoDayByDay[0]['enYuksekNemGun4'], 'condition' =>  $weatherInfoDayByDay[0]['hadiseGun4'], 'windSpeed' => $weatherInfoDayByDay[0]['ruzgarHizGun4'], 'date' => date('d-m-Y', strtotime($date . "+3 days"))));
        array_push($weatherDatas, array('lowestDegree' => $weatherInfoDayByDay[0]['enDusukGun5'], 'highestDegree' =>  $weatherInfoDayByDay[0]['enYuksekGun5'], 'lowestHumidity' =>  $weatherInfoDayByDay[0]['enDusukNemGun5'], 'highestHumidity' => $weatherInfoDayByDay[0]['enYuksekNemGun5'], 'condition' =>  $weatherInfoDayByDay[0]['hadiseGun5'], 'windSpeed' => $weatherInfoDayByDay[0]['ruzgarHizGun5'], 'date' => date('d-m-Y', strtotime($date . "+4 days"))));
        $this->forecast = $weatherDatas;
    }
}
