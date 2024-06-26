<!DOCTYPE html>
<?php
ini_set('display_errors', '0');

if (isset($_GET['date'])) {
    $date = DateTime::createFromFormat('Ymd', $_GET['date']);
    $outputDate = $date->format('Y년 m월 d일');
    $SearchDate = $_GET['date'];
    $message = $outputDate . " 급식";
} else {
    $SearchDate = date("Ymd");
    $message = "" . date("m", time()) . "월" . date("d", time()) . "일 급식";
}

// 캐싱 폴더 경로
$cacheFolder = 'DB';

// 날짜를 기준으로 파일명 생성
$fileName = $cacheFolder . '/' . $SearchDate . '.txt';

// 캐싱된 파일이 있는 경우
if (file_exists($fileName)) {
    // 파일에서 정보 읽어오기
    $cachedData = file_get_contents($fileName);
    $cachedData = json_decode($cachedData, true);

    // 캐싱된 정보로 업데이트
    $breakfast = $cachedData['breakfast'];
    $lunch = $cachedData['lunch'];
    $dinner = $cachedData['dinner'];
} else {
    // API 요청 및 응답 받아오기
    $sc_code = 7430310;
    $r_code = "G10";
    $KEY = "";
    
    $apiUrl = 'https://open.neis.go.kr/hub/mealServiceDietInfo?ATPT_OFCDC_SC_CODE='.$r_code.'&SD_SCHUL_CODE='.$sc_code."&KEY='.$KEY.'&MLSV_YMD=' . $SearchDate;
    $response = file_get_contents($apiUrl);

    // XML을 SimpleXMLElement로 파싱
    $xml = new SimpleXMLElement($response);

    // MMEAL_SC_NM 및 DDISH_NM 값을 추출
    $breakfast = [
        'mmealScNm' => (string)$xml->row[0]->MMEAL_SC_NM,
        'ddishNm' => preg_replace("/\([^)]+\)/", "", (string)$xml->row[0]->DDISH_NM),
    ];

    $lunch = [
        'mmealScNm' => (string)$xml->row[1]->MMEAL_SC_NM,
        'ddishNm' => preg_replace("/\([^)]+\)/", "", (string)$xml->row[1]->DDISH_NM),
    ];

    $dinner = [
        'mmealScNm' => (string)$xml->row[2]->MMEAL_SC_NM,
        'ddishNm' => preg_replace("/\([^)]+\)/", "", (string)$xml->row[2]->DDISH_NM),
    ];

    // 파일에 정보 저장
    file_put_contents($fileName, json_encode(['breakfast' => $breakfast, 'lunch' => $lunch, 'dinner' => $dinner]));
}
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="dsm-icon.ico" rel="icon">
<meta http-equiv="Title" content="대마고급식 급식">
<meta http-equiv="Subject" content="대덕소프트웨어마이스터고등학교 급식을 확인하세요.">
<meta http-equiv="Publisher" content="Donghyun Studio KR">
<meta property="og:type" content="website">
<meta property="og:title" content="대마고급식 급식">
<meta property="og:description" content="대덕소프트웨어마이스터고등학교 급식을 확인하세요.">
<meta property="og:image" content="dsm-icon.ico">
<meta property="og:url" content="https://대덕소마고급식.nanu.cc">
<meta name="naver-site-verification" content="0078b53e0d841cea04e905ed394c056495d91da3" />

<meta name="theme-color" content="#000000">
<link rel="canonical" href="https://대덕소마고급식.nanu.cc">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<head>
    <title>대덕소프트웨어마이스터고등학교 급식</title>
    <link rel="stylesheet" href="css.css">

</head>

<body>
    <div id="header">
        <div>대마고급식</div>
        <div>
            <a href="https://instagram.com/hi._.dsm_" class="header-link">@hi._.dsm_</a>
        </div>
    </div>
    <br>
    <div id="hero">
        <h1 class="date">
            <?php echo $message;?>
        </h1>
        <div id="meal-boxes">
            <div class="meal-box">아침
                <div class="food">
                    <?php echo $breakfast['ddishNm'] ?: '급식 미제공'; ?><br>
                </div>
            </div>
            <div class="meal-box">점심
                <div class="food">
                    <?php echo $lunch['ddishNm'] ?: '급식 미제공'; ?><br>
                </div>
            </div>
            <div class="meal-box">저녁
                <div class="food">
                    <?php echo $dinner['ddishNm'] ?: '급식 미제공'; ?><br>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="message2say" style="color: rgb(66, 66, 66);">
                "컴파일도 식후경"
            </div>
            <h3>대덕소마고급식</h3>
            <p>Donghyun Studio (KR)</p>
            <div id="txt">본 사이트는 어떠한 템플릿 없이 개발되었으며, 무단 복제 시에는 법적 책임이 있습니다.</div><br>
            <div id="txt">사이트 호스팅 : <a href="https://nanu.cc">NANU Cloud</a> ,OpenSource : <a
                    href="https://nanu.cc/SOIL">NANU SOIL</a><br><br><a
                    href="https://law.nanu.cc/legal/Privacy/">개인정보처리방침</a>
            </div>
        </div>
    </footer>
</body>
<script>
    function addOneDay() {
        calculateAndRedirect(1);
    }

    function subtractOneDay() {
        calculateAndRedirect(-1);
    }

    function calculateAndRedirect(days) {
        // 현재 날짜 객체 생성
        var currentDate = new Date();

        // days를 더하거나 빼서 날짜 계산
        currentDate.setDate(currentDate.getDate() + days);

        // YYYYMMDD 형식으로 변환
        var year = currentDate.getFullYear();
        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        var day = ('0' + currentDate.getDate()).slice(-2);
        var formattedDate = year + month + day;

        // 현재 URL에서 date 매개변수 제거
        var currentURL = window.location.href;
        var urlWithoutDate = currentURL.replace(/([&?]date=)[^\&]+/, '');

        // 계산한 날짜를 추가한 URL로 리다이렉트
        window.location.href = urlWithoutDate + (urlWithoutDate.includes('?') ? '&' : '?') + 'date=' + formattedDate;
    }
</script>

</html>