<?php
class My_date_helper
{


    /**
     * Returns a valid mysql representation for a date based on the $dateParam.
     * If an invalid $dateParam is provided, returns the current date.
     *
     * @param string $dateParam
     * @return string
     */
    public static function getMysqlDate($dateParam)
    {
        if (empty($dateParam)) {
            return date('Y-m-d');
        }

        try {
            $dateObj = new DateTime($dateParam);
            return $dateObj->format('Y-m-d');
        } catch (Exception $e) {
            return date('Y-m-d');
        }

    }
}



