<?php

namespace Starter\Utils;

class CString {

    /**
     * @param array|string $data
     * @param array|null $allowedTags
     * @return array|string
     */
    public static function escapeHtml ($data, $allowedTags = null) {
        if (is_array ($data)) {
            $result = array ();
            foreach ($data as $item) {
                $result[] = self::escapeHtml ($item);
            }
        } else {
            if (strlen ($data) > 0) {
                if (is_array ($allowedTags) && !empty ($allowedTags)) {
                    $allowed = implode ('|', $allowedTags);
                    $result = preg_replace ('/<([\/\s\r\n]*)(' . $allowed . ')([\/\s\r\n]*)>/si', '##$1$2$3##', $data);
                    $result = htmlspecialchars ($result, ENT_COMPAT, 'UTF-8', false);
                    $result = preg_replace ('/##([\/\s\r\n]*)(' . $allowed . ')([\/\s\r\n]*)##/si', '<$1$2$3>', $result);
                } else {
                    $result = htmlspecialchars ($data, ENT_COMPAT, 'UTF-8', false);
                }
            } else {
                $result = $data;
            }
        }
        return $result;
    } // escapeHtml ();

}; // CString;