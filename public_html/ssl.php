<?php
/**
 * Function:
 * User: YUN
 * Date: 2018/10/26 00:56
 * Description:
 */

$private_key = '-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCuzzbltOOgxHIQ
jX18ME+vhJV3EgBNq2DAdKXPmBdPkfZCah83bHWdqXsEo70bbjhcop5g5pkfgoiv
EtP5t5QVHTPNpAMF+HU3lpQqefe0Wx9WRmps5ccxJQTF201uKMFnncoUdAnPaqXU
ztfOSEqDB0VYQjm00B3S1fsXkTf13Ug3OX5WjdHfWmIsI/Csp6B2OSaEVscnj5kW
IQKOZDmvinFBjElbFnNTvFI4t5gtYiMsStMOf6BBDtf4+orv47pcb8ZD4xc+OU+O
csiKGJHlGvnxOfRiM2hiCm8nhGbgPbXVOXKgd3NiU2BTBuT8RcWk4Q7IVHkNiGaM
2GMKYaxDAgMBAAECggEADLqB4M//EyG6vIHQ9U3/P2SEDZt98incbacQu8DzUZPr
PoLDqyF2nvhMQNY7Wtf3uqcMqTmhRK4YjcbtMG2xlqf9saeToMeqoVWRjFY9NyC7
c2jFLxC8JFPxuQZy6OaGzqiqojqgzD2TvZ8iD58r7caFwhtwYD4XLdbu5ZRpYrmP
Onar7QxQu7jvyX0363iwI04+rPXLII9gvihKbSp1uVyUa7PF2uefJtwq4Gs13OMi
2z+IFQ5ps5cq5d2aM4vcakwva1KU7NzQv/mMgnIgm4now7AMIsxfP7ozfUCMlyZ6
coFzxHCHu0yp+sC23Q/WbzSY6OsoRyL26aa93KKBYQKBgQDi8JmpGCCGsQ0facMh
vgqyvRSdaqqidA1bj9W2/r9OvPjcz4w/r/qa2b6JAzFd5uQJ++GuDP7TmmZB6iB0
qZbrs+YBVCEHIzUyMiAivSS3kX52zvB7M0WsrqYNAXuelbeqpcapd0zOrScNztNG
juuzJ51r01rAGr4ykBg040wgpwKBgQDFMbUpzi+cuJ6dZg15Ro9uQpBdlQif9hw+
FgK77PDwwDtvhYRabF7mgYnRHgXIij90C5asKbYVSbJS1mOh6GpsDEm7F5BEEJ9j
ReH26f6iBBRy9FJ+0w8ZQSeypbXajAWi2B4eCPZ9cqFqy7qBk9UOdqn8yWk+FSoD
PlMyelLPBQKBgAiNlN0AockxxxLWA5qz9OdDpRFBweiZgx9eTmm1NDSdfqujzt9f
nIxVhI7ZZfTqDNIrghfzOW90NEJrtolvEtcTUqneJ9iDBTA9H2TvyAB7JU8JAZtD
FW8qretzkNsrPV7bHJ+qdWSctgoZL3FLVarM5Wv47USsPVref2sO3gGlAoGBAJ6M
QeH0AroagoWBKTIqNmZrpJFpo36hrcGJhvc8IdkgZmlbS7g8S+0/l+SIJBRCe5Q9
QQ75lon1MCiEcaUbLn3jP2DrKDZhuxVhebZCG1Z+u0ZWBQIthoVCqr1rmRS34kw1
QbnacP0aLoikdzd5+iLf6/rwoeqlr5reAJykV3JVAoGBAMATEt7X8fhkNW7pt9sB
+fa8bg6YGwCT3EEtctzk+s/O+adN5fT9gQ6gRO5pgId9cMtmf+7emvwO/pS4JqWW
pT5FxF3qGovOpugC2tc/c0ljxndQ69qgq2adzVVsYVoQvnE1m6zy4O9Il9LDAfkI
1T1uqiVdmTS3WfEHWuu3ok4H
-----END PRIVATE KEY-----';

$pi_key =  openssl_pkey_get_private($private_key, '');
$pu_key = openssl_pkey_get_details($pi_key);
$public_key = $pu_key['key'];
echo $pu_key['key'];

$data = '123412341';  // 需加密的内容
$encrypted = '';

openssl_public_encrypt($data,$encrypted,$public_key);//公钥加密
$encrypted = base64_encode($encrypted);
echo $encrypted,"\n";


echo "private key decrypt:\n";
openssl_private_decrypt(base64_decode($encrypted),$decrypted,$private_key);//私钥解密
echo $decrypted,"\n";