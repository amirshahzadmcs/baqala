<?php

if (!function_exists('dd')) {
    /**
     * Dump the variables and terminate the script.
     *
     * @param mixed ...$vars
     */
    function dd(...$vars)
    {
        echo '<html><head><style>';
        echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
        echo 'pre { background: #280538; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }';
        echo 'code { color: rgb(240, 237, 237); }';
        echo '</style></head><body>';

        foreach ($vars as $var) {
            echo '<pre><code>';
            print_formatted($var);
            echo '</code></pre>';
        }

        echo '</body></html>';
        exit;
    }

    /**
     * Print formatted array/object with type indications.
     *
     * @param mixed $var
     * @param int $level
     */
    function print_formatted($var, $level = 0)
    {
        $indent = str_repeat('    ', $level); // 4 spaces for indentation

        if (is_array($var)) {
            echo $indent . "Array:\n";
            foreach ($var as $key => $value) {
                echo $indent . "    [$key] => ";
                if (is_array($value) || is_object($value)) {
                    echo "\n";
                    print_formatted($value, $level + 1);
                } else {
                    echo format_value($value) . "\n";
                }
            }
        } elseif (is_object($var)) {
            echo $indent . "Object (" . get_class($var) . "):\n";
            foreach (get_object_vars($var) as $key => $value) {
                echo $indent . "    $key => ";
                if (is_array($value) || is_object($value)) {
                    echo "\n";
                    print_formatted($value, $level + 1);
                } else {
                    echo format_value($value) . "\n";
                }
            }
        } else {
            echo $indent . format_value($var) . "\n";
        }
    }

    /**
     * Format the value for display.
     *
     * @param mixed $value
     * @return string
     */
    function format_value($value)
    {
        if (is_null($value)) {
            return 'NULL';
        } elseif (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        } elseif (is_string($value)) {
            return '"' . htmlspecialchars($value) . '"';
        }
        return htmlspecialchars((string)$value);
    }
}
