<?php
/**
 * Function:
 * User: YUN
 * Date: 2018/10/24 22:13
 * Description:
 */

/**
 * 检查签名
 * @param $data
 * @param $key
 * @return string
 */
function checkSign($data, $key)
{
    $tmp = ksort($data);
    $tmp_str = '';
    foreach ($data as $k => $v)
    {
        if($k != "sign" && $v != "" && !is_array($v)){
            $tmp_str .= $k . "=" . $v . "&";
        }
    }

    $tmp_str = trim($tmp_str, "&");
    $tmp_str .= '&hash_key=' . $key;

    return md5($tmp_str) == $data['sign'];
}


/**
 * 数据加密
 * @param $data
 * @return string
 */
function private_encrypt($data)
{
    $config = include ROOT_PATH . 'config.php';

    $private_key = openssl_pkey_get_private($config['private_key'], '');
    openssl_private_encrypt($data, $result, $private_key);
    $private_key && openssl_free_key($private_key);
    return base64_encode($result);
}

/**
 * 数据解密
 * @param $data
 * @return string
 */
function private_decrypt($data)
{
    $result = '';
    $config = include ROOT_PATH . 'config.php';

    $private_key = openssl_pkey_get_private($config['private_key'], '');
    $data = base64_decode($data);
    openssl_private_decrypt($data, $result, $private_key);
    $private_key && openssl_free_key($private_key);
    return ($result);
}

function errorPage($message)
{
    exit($message);
}
