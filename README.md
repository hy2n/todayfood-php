# 대덕소프트웨어마이스터고등학교 급식 조회 SW

이 프로젝트는 대덕소프트웨어마이스터고등학교의 급식 정보를 조회하고 파싱하는 프로젝트입니다. 

급식 정보는 공공데이터포털의 API를 활용하여 실시간으로 가져오고 있습니다. 또한 캐싱을 통해 성능을 향상시키고 있습니다.

### 주요 기능

1. **날짜별 급식 조회**: 원하는 날짜의 아침, 점심, 저녁 급식을 조회할 수 있습니다.
2. **급식 캐싱**: API를 통해 가져온 급식 정보를 파일에 저장하여 반복적인 요청에 대한 성능을 향상시킵니다.
3. **간편한 이동**: 이전 날짜와 다음 날짜로의 간편한 이동 버튼이 제공됩니다.

### 사용 기술

- **PHP**: 서버 측 로직을 처리하기 위해 PHP를 사용하였습니다.
- **HTML/CSS**: 웹앱의 구조와 스타일링을 위해 HTML 및 CSS를 사용하였습니다.
- **JavaScript**: 날짜 계산 및 리다이렉션을 위한 클라이언트 측 스크립트로 JavaScript를 사용하였습니다.

### 사용 방법

1. 사이트에 접속합니다.
2. 원하는 날짜를 선택하거나, 기본값인 오늘 날짜로 조회합니다.
3. 해당 날짜의 아침, 점심, 저녁 급식을 확인합니다.
