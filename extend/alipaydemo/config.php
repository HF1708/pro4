<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2018041202543708",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAnjUwdqpoMM1oatYjpUueXZ/3OtA24aQGs5IsHPZWwS5H61acZfMlGO/OZofmdumc3UZQKS9n4uqI6LPYMjXHwGve6hSz7UW3xIbnbyz2DJaEZC01nHfg/nh8lG7S6/Du9aHt5OEpbjKqzftdDsSVHJG/EXl8sAbcQilVUeAFCyeEU3YiK+18pA32Fx+fl4TBWEIlmkk7uN4mulwpR8PfN+GNES89eDsHrLhjUdDaKhfIgod8AB2De+u3pUCTc9qHmYFDZh27/jZDEz12VT4DaO/9uYQK80m32IaAFQppIHnlV9hvnc5KYUsRHnUvcIP260BBFj8EEQ14uv7+Zu/t3wIDAQABAoIBADmwGWjbwDwzWiTCyqKmTSvEfajTbX+fiNYHsdApvv6X+p+EqGjAXUGXh8J5QX8QtiM1VVt/LrleXefEVEwSsjCm5NSkEeut5VFjA5bVZS6337SLi6XvTHpdwsd5Fa30351vm0g/FhVZolCTnJ4a7mhJeMtNajrhdYUmfzbooc4r2tv4dsoN9r3fsaDrHiAssEPFBGo5llgHPxevvTqwUDlQm3tMtKbgkDq4lnEWi5xqpMXDmV3kAkpY6J4BZDoaybCDjE9caGj6FTlXS2JiBIessWfiXWr8p24zDLVsKN/6JpZyhaOqe6tkj7P20Qi9McKCA0pothP5gMCiTeB7IOkCgYEAy+jOS5CHbNMzx3ih9uhWddise4OGKjt+9tcfH61W8ZcbxbHGNNLJiIAlHp3YHfTFXYxXtC6dZJLadOizjNURsmSlQrRthqaUsYhFZCCWUnxnAiWRFbspQ6em/cPyQsQ7k9E+CqZodJ4V1jJh6X+vdG5Nf+XMrmnpfgisZz1wI+MCgYEAxp+a0HaPgB5B1Q4LWAaTmYN94V/PvDtgKR4z3k8RJKxuAyZ1upD4HFYT9+LZq/fklvx7UGC8NL0s9AgbZ7Qfuav4gA7DRMOvK+LUHJmz/XrUJwhuGLIcYOuh057kFU3o3k4Pg8jfGTiraTdxoVMHy+euRVi548qlj/RP17KGRtUCgYByRJZGtkmN7JVZtPpemTjKdY/C76OhyxGNVmQ0pjjQzfNcSBFgzLbvbZBfpejUcLShheIoMO82yyzs0vK7ezOdmtUZmm6+RF+TVWA9ih1zQA+hnle9q9Kl/S+RidsbG0ifv2RbJ4HlyClIjZdc+JbkUmPPxoF7RBL68/VZLY7ILQKBgQCoapkI/h77kaxcjYYM47avypEoUueAQhBtjRCKBh0RLawyu5/DzDy1Oj/ARvgvGwkXBYtCQmQTi/zcByvFqTPlae5SFzJ30j1sRu94ONQnsMjHOByykAQEIoibOfVII0G7jhEVu3OAnU6q7rpJAnBv80kPwAYPIrtz7sLssJGu6QKBgCr/6Sx1PkL2qels+PbyGhMN0LTPvifhtcbxaV0836z6jYY6QCqYoWdulGtfRFttcvuRbtqYvZt+ggxjWJxQDbAb7oteVuwfgdydszmM/SaBY5uXk0Kw2UofLHQt8MCKAhQ7jjZ7MiwPYJnLtqtGajyUPO2TJnqthEtelIaqU36Q",
		
		//异步通知地址
		'notify_url' => "https://www.qqy.fun/pay/alipay/notify_url",
		
		//同步跳转
		'return_url' => "https://www.qqy.fun/pay/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4f949o5WDEBB938kUGFE7Qd7XhbwGiwHscvIXmY5N1G5S7VcgBHvceMkwupVyunU0VDBED+KKAtm55/OggK1yNePeQnJhWFs3eNHXdXp3UJwJy6NXfLtGrl0A2ftSJlUAvCjv5Dl7rdCP8ujmJZ2gFxJbFAzfEv9sAm9AhgKSKrkaUlCZJpXD1gSz2MVLsjxW76y9S6lrZbE0b4hlB1UElnyAumlXpWGpZyZBtp7Ah8N/u5nejrlg0oxgBVjb8VGFBRTA9pXjEozFjFVIHYhBz651FSgDi0IYuV891cqRFxlSMJMVburoKpPVbi2jgCeQ+6MeEgukam3gSOJuBtXXQIDAQAB",
);