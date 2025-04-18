<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

use MolnarSandorBenjamin\RackforestTest\helpers\ArrayHelper;

class PDO extends \PDO
{
    public function __construct($config)
    {
        $driver = ArrayHelper::getValue($config, 'driver', 'mysql');
        $port = ArrayHelper::getValue($config, 'port', '3306');
        $host = ArrayHelper::getValue($config, 'host');
        $dbname = ArrayHelper::getValue($config, 'dbname');

        return parent::__construct(
            "$driver:host=$host;port=$port;dbname=$dbname",
            ArrayHelper::getValue($config, 'username'),
            ArrayHelper::getValue($config, 'password'),
            ArrayHelper::getValue($config, 'options', [])
        );
    }

    /**
     * Replaces any parameter placeholders in a query with the value of that
     * parameter. Useful for debugging. Assumes anonymous parameters from
     * $params are are in the same order as specified in $query
     *
     * @param string $query The sql query with parameter placeholders
     * @param array $params The array of substitution parameters
     * @return string The interpolated query
     */
    public function interpolateQuery($query, $params) {
        $keys = array();
        $values = $params;

        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }

            if (is_string($value))
                $values[$key] = "'" . $value . "'";

            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";

            if (is_null($value))
                $values[$key] = 'NULL';
        }

        $query = preg_replace($keys, $values, $query);

        return $query;
    }
}