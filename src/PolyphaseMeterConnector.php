<?php
declare(strict_types = 1);

namespace ws\loewe\polyphase_meter;

use Exception;

class PolyphaseMeterConnector {

    /**
     * the delimiter marking the first line of a new {@link PolyphaseMeterReading}
     *
     * @var string
     */
    private static string $DELIMITER = 'LOG5LK13BE803039';

    /**
     * the URI from where to read raw data, usually something like <code>/dev/ttyUSB0</code>
     *
     * @var string
     */
    private string $deviceUri;

    /**
     * This method creates an instance of this class to read raw data from the given file or device.
     *
     * @param string $deviceUri the file or device to read raw data from
     */
    function __construct(string $deviceUri) {
        $this->deviceUri = $deviceUri;
    }

    /**
     * This method tries to read a {@link PolyphaseMeterReading} from this connector.
     *
     * @return PolyphaseMeterReading the current reading
     * @throws Exception if reading from the raw input fails
     */
    public function read(): PolyphaseMeterReading {
        $foundStart = false;
        $foundEnd = false;

        $rawData = '';

        $input = fopen($this->deviceUri, 'r');

        if($input === false) {
            throw new Exception("Cannot open '" . $this->deviceUri . "' for reading.");
        }

        while (!$foundStart) {
            $line = fgets($input);

            if (strstr($line, self::$DELIMITER) !== false) {
                $rawData = $rawData . $line;
                $foundStart = true;
            }
        }

        while (!$foundEnd) {
            $line = fgets($input);
            $rawData = $rawData . $line;

            if (strstr($line, self::$DELIMITER) !== false) {
                $foundEnd = true;
            }
        }

        fclose($input);

        return new PolyphaseMeterReading($rawData);
    }
}
