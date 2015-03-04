<?php

class TodayDeliverySign
{

    protected $_str_params;

    /**
     * Метод генерации Подписи ( sign )
     * 
     * @param array $params Ассоциативный массив с данными
     * @param string $private_key Приватный ключ пользователя
     * 
     * @return string
     */
    public function generateSignKey($params, $private_key)
    {
        if (isset($params['sign'])) {
            unset($params['sign']);
        }

        // сортировка значений
        $params = $this->recursiveKsort($params);
        $p = array();
        $key = "";

        if (is_array($params)) {
            $this->_str_params = '';
            // получение
            $this->resursiveStr($params);
            $key = md5(hash('sha256', $this->_str_params . $private_key));
        }

        return $key;
    }

    private function recursiveKsort($a)
    {
        if (is_array($a)) {
            ksort($a);
            foreach ($a as $key => $element) {
                if (is_array($element)) {
                    $a[$key] = $this->recursiveKsort($element);
                }
            }
        }
        return $a;
    }

    private function resursiveStr($a)
    {
        if (is_array($a)) {
            foreach ($a as $key => $element) {
                if (is_array($element)) {
                    $this->resursiveStr($element);
                } else {
                    $this->_str_params = $this->_str_params . $element;
                }
            }
        }
        return $a;
    }

}
