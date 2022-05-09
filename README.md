# OTP Generator
OTP를 통해 웹 훅을 발생시키는 간단한 모듈입니다.

# How to operate
웹을 통해 스크립트가 동작됩니다.

url 주소 다음 경로에 해당하는 부분에 otp 번호가 입력되어야 합니다.
> ex) test.com/123456

otp 번호가 일치한다면 웹 훅 url을 호출 하여 다음 동작을 진행합니다.

# Ready to operate
otp.php 스크립트 내에서 읽혀지는 config 파일을 작성 해야합니다.

config 파일은 `config/config.php`입니다.

config 파일 내에 `SECRET_KEY`, `HOOK_URL` 상수가 존재해야 합니다.

`SECRET_KEY`는 OTP에 사용되는 비밀키값을, `HOOK_URL`은 웹 훅이 실행 될 url을 입력해야 합니다.

### example
```
<?php
//config/config.php
@define(SECRET_KEY, 'secretkey');
@define('HOOK_URL', 'https://webhook-test.com`);
?>
```

# Start to operate

1. 구글 OTP를 이용해 인증 설정 후 비밀 키를 스크립트 내 config 파일에 선언해줍니다.

2. 웹 훅을 통해 인증 이후 동작할 환경을 준비합니다.

3. Jenkins 아이템을 추가하여 빌드시 동작할 환경을 세팅해준 후 빌드가 유발될 웹 훅 URL을 config 파일에 선언해줍니다.

4. was를 통해 스크립트가 웹에서 동작 할 수 있도록 설정해줍니다.
간단한 예시는 다음과 같습니다.
```
# nginx
# site.conf
server {
  server_name otp.com;
  location / {
    root /var/www/otp;
    fastcgi_split_path_info ^(.+?\.php)(/.*)$;

    if (!-f $document_root/otp.php) {
      return 404;
    }

    fastcgi_pass unix:/var/run/fastcgi.socket;
    include fastcgi_params;

    fastcgi_param SCRIPT_FILENAME $document_root/otp.php;
  }
}
```

# References
https://github.com/PHPGangsta/GoogleAuthenticator
